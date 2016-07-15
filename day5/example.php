<?php
require_once("../basicCaman.php");

//This retrieves all the image data that we sent from the previous HTML file.  It is an array.
$image_data = $_FILES["image"];
//Part of the array is the "mime type" which identifies what kind of image it is that we're using.
$mimeType = $image_data['type'];

// This uses a function to determine the file extension based on the mime type.
//   If it is unsupported, it will return (false).
$image_extension = ce_find_extension($mimeType);

$target_file;

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
    header( 'Location: begin.php?q=error' ) ;
  }
}

?>
<!DOCTYPE html>
<html>
<head>
<title>Initial Caman JS Tests</title>
<script type="text/javascript" src="../day2/caman.full.js"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
<script type="text/javascript" src="../basicCaman.js"></script>
<script>
$( document ).ready(function() {
  var camanObject = Caman("#toEdit");
  $(" #vintage ").on("click", function(){
    camanObject.revert(false);
    camanObject["vintage"]();
    camanObject.render();
  });
});
</script>
</head>
<body>
  <img src="<?php echo $target_file; ?>" id="toEdit" />
<br /><br />
  <button class="btn btn-default" style="width:120px" id="vintage">Vintage</button>
</body>
</html>

