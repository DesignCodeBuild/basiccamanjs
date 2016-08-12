<?php
	
		require_once("basicCaman.php");
		
//This retrieves all the image data that we sent from the previous HTML file.  It is an array.
$image_data = $_FILES["fileToUpload"];
//Part of the array is the "mime type" which identifies what kind of image it is that we're using.
$mimeType = $image_data['type'];

// This uses a function to determine the file extension based on the mime type.
//   If it is unsupported, it will return (false).
$image_type = $image_extension = ce_find_extension($mimeType);

if($image_extension === false)
{
  // Redirect to the previous page, and tell it that the image type was incorrect.
  header( "Location: index2.php?error=Wrong%20File%20Extension" ) ;

}
else
{
  // Create a random string of numbers and characters to use as a file name.
  $random_string = ce_random_string();
  // Make a file name from the random numbers and extension.
  $filename = $random_string . "." . $image_extension;

  // Figure out where we will put the images.
  $dir = "tmp_images/";
  // Combine the file name and directories to determine where the file will go
  $target_file = $dir . $filename;
  //echo $target_file;

  // Move the temporary image file to a new location.
  if(move_uploaded_file($image_data["tmp_name"], $target_file))
  {
    // This will crop it to no more than 640 px per side.
    ce_smaller_image($target_file);
  }
  // If moving the file is unsuccessful, redirect to the last page to report that it didn't work.
  else
  {
    // Redirect to the previous page, and tell it that there was an unknown error
    //header( 'Location: begin.php?q=error' ) ;
  }
}
?>
<!DOCTYPE html>
<!--
1. choose a file [password?]
2. add filters
3. (optional) upload
4. gallery. [open to anyone to view] -->
<html>
	<head> 
		
		<title> Catstagram! </title>

		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<script type="text/javascript" src="basicCaman.js"></script>
		<script type="text/javascript" src="caman.full.js"></script>
		<script type="text/javascript" src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
		<style>
			body {
				background-color:#E2DEDE;
			}
			.ourbutton {
				width:512px;
			}
			h1 {
				text-align:center;
			}
			.ctr {
				display:block;
				margin:0 auto;
			}
			.relativecontainer {
				position:relative;
				top:0;
				left:0;
				width:512px;
				height:512px;
			}
			.filterbox {
				display:block;
				margin:0 auto;
				width:640px;
				padding: 0 40px;
			}
			.filterbutton {
				width: 100px;
				height: 50px;
				-moz-border-radius: 50px / 25px;
				-webkit-border-radius: 50px / 25px;
				border-radius: 50px / 25px;
				float:left;
				margin: 6px;
			}
			#caption {
				width:100%;
				height:100px;
			}
		</style>
		<script>
			function makeButtons() {
				var filterslist= [["vintage", "Vintage"], ["lomo", "Lomo"],["clarity", "Clarity"], ["sinCity", "Sin City"], ["sunrise", "Sunrise"], ["crossProcess", "Cross Process"], ["orangePeel", "Orange Peel"], ["love", "Love"], ["grungy", "Grungy"], ["jarques", "Jarques"], ["pinhole", "Pinhole"], ["oldBoot", "Old Boot"], ["glowingSun", "Glowing Sun"], ["hazyDays", "Hazy Days"], ["herMajesty", "Her Majesty"], ["nostalgia", "Nostalgia"], ["hemingway", "Hemingway"], ["concentrate", "Conecentrate"] ];
				
				/*
					1. Create the buttons
						1.  create the actual HTML buttons
					2. Make the buttons work
						1. Connect javascript to those buttons
					*/
				for(var i = 0;i<filterslist.length;++i)
				{
					var buttonElement = document.createElement("button");
					$(buttonElement).html(filterslist[i][1]); 
					$(buttonElement).addClass("btn btn-primary filterbutton");
					$(buttonElement).attr('id', filterslist[i][0]);
					$("#filterbox").append(buttonElement);
				}
				
				$(".filterbutton").click(function() {
					var buttonid = $(this).attr('id');
					camanObject.revert(false);
					camanObject[buttonid]();
					camanObject.render();
				});
				
			}
			
			var camanObject = Caman("#toEdit");
			$( document ).ready(function() {
				makeButtons();
				$("#reset").click(function() {
					camanObject.revert(true);
				});
				$("#NextStep").click(function() {
					camanObject.render(function(){
						var imageData = camanObject.toBase64("<?php echo ce_caman_image_type($image_extension); ?>");
						var allData = {data: ceEscapeString(imageData), tmploc: ceEscapeString("<?php echo $target_file; ?>"), type: "<?php echo $image_extension; ?>", caption: ceEscapeString($("#caption").val())};
						ceAjaxSend("acceptImages.php", allData, "gallery.php");
					});
				});
	
	
	
			});
			
			
			
		</script>
		
	</head>
	<body> 
		<h1> Catstagram </h1>
		<textarea id="caption"></textarea>
		<h1> Edit Your Picture! </h1>
		<img src="<?php echo $target_file; ?>" class="ctr" id="toEdit" />
		<br />
		<br />
		<div class="filterbox" id="filterbox">
			
			
		</div>
		<br />
		  <br style="clear:both;" />
		  <br />
		<button class="btn btn-primary ctr" id="reset">Reset</button>
		
		<br />
		<button class="btn btn-primary ctr" id="NextStep">Next Step</button>
	</body>
</html>