<?php
// Important functions that make this easier
require_once("basicCaman.php");

// Identify where wordpress is installed relative to our current directory.
$wordpress_home = "../";

//Figure out if the image is real and what format it is

//This retrieves all the image data that we sent from the previous HTML file.  It is an array.
$image_data = $_FILES["image"];
//Part of the array is the "mime type" which identifies what kind of image it is that we're using.
$mimeType = $image_data['type'];

// This uses a function to determine the file extension based on the mime type.
//   If it is unsupported, it will return (false).
$image_extension = ce_find_extension($mimeType);

if($image_extension === false)
{
  // Redirect to the previous page, and tell it that the image type was incorrect.
  header( "Location: begin.php?q=type" ) ;
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
  
  // Move the temporary image file to a new location.
  if(move_uploaded_file($image_data["tmp_name"], $target_file))
  {
    // This will crop it to no more than 640 px per side.
    ce_smaller_image($target_file);
  }
  // If moving the file is unsuccessful, redirect to the last page to report that it didn't work.
  else
  {
    // Redirect to the previous page, and tell it that the image type was incorrect.
    header( 'Location: begin.php?q=error' ) ;
  }
}

?>
<!doctype html>
<html>
<head>
  <title>Select A Filter</title>
  <script type="text/javascript" src="caman/caman.full.min.js"></script>
  <script type="text/javascript" src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
  <script type="text/javascript" src="basicCaman.js"></script>
<script>
  var camanObject = Caman("#toEdit");

  $( document ).ready(function() {

    $(" #vintage ").on("click", function(){
      camanObject.revert(false);
      camanObject["vintage"]();
      camanObject.render();
    });
    $(" #lomo ").on("click", function(){
      camanObject.revert(false);
      camanObject["lomo"]();
      camanObject.render();
    });
    $(" #sinCity ").on("click", function(){
      camanObject.revert(false);
      camanObject["sinCity"]();
      camanObject.render();
    });
    $(" #crossProcess ").on("click", function(){
      camanObject.revert(false);
      camanObject["crossProcess"]();
      camanObject.render();
    });
    $(" #clarity ").on("click", function(){
      camanObject.revert(false);
      camanObject["clarity"]();
      camanObject.render();
    });
    $(" #sunrise ").on("click", function(){
      camanObject.revert(false);
      camanObject["sunrise"]();
      camanObject.render();
    });

    $(" #revert ").on("click", function(){
      camanObject.revert(false);
    });
    $(" #next ").on("click", function(){
      var imageData = camanObject.toBase64("<?php echo ce_caman_image_type($image_extension); ?>");
      $("#imageData").val(ceEscapeString(imageData));
      $("#infoForm").submit();
    });

  });
</script>
<link rel="stylesheet" type = "text/css" href="bootstrap/bootstrap.min.css" />
<style>
div.picture
{
  position:block;
  margin-left:auto;
  margin-right:auto;
  width:640px;
}
div.two
{
  position:block;
  margin-left:auto;
  margin-right:auto;
  width:250px;
}
</style>
</head>
<body>
<h1 style="text-align:center">Add a filter?</h1>
<div class="picture">
  <img src="<?php echo $target_file; ?>" id="toEdit" />
</div>
<table style="width:640px;position:block;margin-left:auto;margin-right:auto;">
  <tr>
  <td style="width:128px">
  <button class="btn btn-default" style="width:120px" id="vintage">Vintage</button>
  </td>
  <td style="width:128px">
  <button class="btn btn-default" style="width:120px" id="lomo">Lomo</button>
  </td>
  <td style="width:128px">
  <button class="btn btn-default" style="width:120px" id="clarity">Clarity</button>
  </td>
  <td style="width:128px">
  <button class="btn btn-default" style="width:120px" id="sinCity">Sin City</button>
  </td>
  <td style="width:128px">
  <button class="btn btn-default" style="width:120px" id="sunrise">Sunrise</button>
  </td>
  </tr>

  <tr>
  <td>
  <button class="btn btn-default" style="width:120px" id="crossProcess">Cross Process</button>
  </td>
  <td>
  </td>
  <td>
  </td>
  <td>
  </td>
  <td>
  </td>

  </tr>
</table>
<div class="two">
  <button class="btn btn-danger" style="width:100px;float:left;" id="remove">Remove Filters</button>
  <button class="btn btn-primary" style="width:100px;float:right;" id="next">Next -&gt;</button>
</div>

<form action="third.php" method="post" id="infoForm">
  <input type="hidden" name="tmp_location" id="tmpImageLocation" value="<?php echo ce_escape_string($target_file); ?>" />
  <input type="hidden" name="data" id="imageData" value="" /> <!--Will be filled in with javascript-->
  <input type="hidden" name="type" id="imageType" value="<?php echo $image_extension; ?>" />
</form>
  
</body>
</html>
