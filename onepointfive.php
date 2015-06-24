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

// This uses a function to determine the file extention based on the mime type.
//   If it is unsupported, it will return (false).
$image_extention = ce_find_extention($mimeType);

if($image_extention === false)
{
  // Redirect to the previous page, and tell it that the image type was incorrect.
  header( "Location: begin.php?q=type" ) ;
}
else 
{
  // Create a random string of numbers and characters to use as a file name.
  $random_string = ce_random_string();
  // Make a file name from the random numbers and extention.
  $filename = $random_string . "." . $image_extention; 

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

  });
</script>
<style>
div.picture
{
  position:block;
  margin-left:auto;
  margin-right:auto;
  width:640px;
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
  <button id="vintage">Vintage</button>
  </td>
  <td style="width:128px">
  <button id="lomo">Lomo</button>
  </td>
  <td style="width:128px">
  <button id="clarity">Clarity</button>
  </td>
  <td style="width:128px">
  <button id="sinCity">Sin City</button>
  </td>
  <td style="width:128px">
  <button id="sunrise">Sunrise</button>
  </td>
  </tr>

  <tr>
  <td>
  <button id="crossProcess">Cross Process</button>
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
  
</body>
</html>
