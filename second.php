<!DOCTYPE html>

<?php
// Important functions that make this easier
require_once("basicCaman.php");

// Identify where wordpress is installed relative to our current directory.
$wordpressHome = "../";

//Figure out if the image is real and what format it is

//This retrieves all the image data that we sent from the previous HTML file.  It is an array.
$imageData = $_FILES["image"];
//Part of the array is the "mime type" which identifies what kind of image it is that we're using.
$mimeType = $imageData['type'];

// This uses a function to determine the file extention based on the mime type.
//   If it is unsupported, it will return (false).
$imageExtention = ce_find_extention($mimeType);

if($imageExtention === false)
{
  // Redirect to the previous page, and tell it that the image type was incorrect.
  header( "Location: begin.php?q=type" ) ;
}
else 
{
  // Create a random string of numbers and characters to use as a file name.
  $random_string = ce_random_string();
  // Make a file name from the random numbers and extention.
  $filename = $random_string . "." . $imageExtention; 

  // Figure out where we will put the images.
  $wp_media_dir = ce_get_media_directory($wordpressHome);
  // Combine the file name and directories to determine where the file will go
  $target_file = $wordpressHome . $wp_media_dir . $filename;
  
  // Move the temporary image file to a new location.  If it works, nothing happens.
  if(move_uploaded_file($imageData["tmp_name"], $target_file))
    {}
  // If moving the file is unsuccessful, redirect to the last page to report that it didn't work.
  else
  {
    // Redirect to the previous page, and tell it that the image type was incorrect.
    header( 'Location: begin.php?q=error' ) ;
  }
}

?>
<html>
<head>
  <title>Edit Image <?php echo $target_file; ?></title>
  <script type="text/javascript" src="caman/caman.full.min.js"></script>
  <script type="text/javascript" src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
  <script type="text/javascript" src="basicCaman.js"></script>
<script>
  caman = Caman("#toEdit");
  
  var MyControls = {brightness: "brightness", saturation: "saturation", exposure: "exposure", gamma:"gamma", clip: "clip", stackBlur: "stackBlur", contrast:"contrast", vibrance:"vibrance", hue:"hue", sepia:"sepia", noise:"noise", sharpen:"sharpen"};

  $( document ).ready(function() {

    ceResetRanges(MyControls);

    $( "input" ).on("change", function() {
      caman.revert(false);
      ceUpdateCaman(caman, MyControls);
      caman.render();
    });
  
    $( "#save" ).on("click", function(){
      caman.revert(false);
      ceUpdateCaman(caman, MyControls);
      caman.render(function(){
        var imageData = caman.toBase64("<?php echo "jpeg"; ?>");
        $("#txtarea").text(ceEscapeString(imageData));
        ceAjaxSend("acceptImages.php","redirectForm", imageData, "<?php echo $random_string; ?>", "<?php echo $imageExtention; ?>", "<?php echo $wp_media_dir; ?>", $("#title").val(), $("#caption").val(),$("#descrip").val());
      });
    });
  
  });
</script>
<style>
  div.container
  {
    display:block;
    width:800px;
  }
  div.leftForm
  {
    float:left;
    width:200px;
  }
  img.featured
  {
    float:left;
    width:550px;
  }
#title_d, #caption_d, #descrip_d
  {
    float: left;
    width:400px;
  }
</style>
</head>
<body>
<div class="container">
  <div class="leftForm">
    <form action="third.php" method="post">
      Brightness (<span id="brightness_label">0</span>)
      <input type="range" name="brightness" id="brightness" data-filter="brightness" min="-100" max="100" /> <br />
      Saturation (<span id="saturation_label">0</span>)
      <input type="range" name="saturation" id="saturation" data-filter="saturation" min="-100" max="100" /> <br />
      Exposure (<span id="exposure_label">0</span>)
      <input type="range" name="exposure" id="exposure" data-filter="exposure" min="-100" max="100" /> <br />
      Gamma (<span id="gamma_label">0</span>)
      <input type="range" name="gamma" id="gamma" data-filter="gamma" min="0" max="10" /> <br />
      Clip (<span id="clip_label">0</span>)
      <input type="range" name="clip" id="clip" data-filter="clip" min="0" max="100" /> <br />
      Blur (<span id="blur_label">0</span>)
      <input type="range" name="stackBlur" id="stackBlur" data-filter="stackBlur" min="0" max="20" /> <br />
      Contrast (<span id="contrast_label">0</span>)
      <input type="range" name="contrast" id="contrast" data-filter="contrast" min="-100" max="100" /> <br />
      Vibrance (<span id="vibrance_label">0</span>)
      <input type="range" name="vibrance" id="vibrance" data-filter="vibrance" min="-100" max="100" /> <br />
      Hue (<span id="hue_label">0</span>)
      <input type="range" name="hue" id="hue" data-filter="hue" min="0" max="100" /> <br />
      Sepia (<span id="sepia_label">0</span>)
      <input type="range" name="sepia" id="sepia" data-filter="sepia" min="0" max="100" /> <br />
      Noise (<span id="noise_label">0</span>)
      <input type="range" name="noise" id="noise" data-filter="noise" min="0" max="10" /> <br />
      Sharpen (<span id="sharpen_label">0</span>)
      <input type="range" name="sharpen" id="sharpen" data-filter="sharpen" min="0" max="100" /> <br />
    </form>
  </div>
  <div id="title_d">Title: <input type="text" id="title" /></div><br />
  <div id="caption_d">Caption: <input type="text" id = "caption" /></div>
  <div id="descrip_d">Description: <input type="text" id="descrip" /></div>
  <img src="<?php echo $target_file; ?>" id="toEdit" class="featured" /><br />
  <!--textarea id="txtarea"></textarea-->
  <button id="save">Save</button>
  <form action="acceptImages.php" id="testForm" method="post">
    <input type="hidden" name="data" id="Jdata" value=""/>
    <input type="hidden" name="name" id="Jname" value=""/>
    <input type="hidden" name="type" id="Jtype"  value=""/>
    <input type="hidden" name="dir" id="Jdir"  value=""/>
    <input type="hidden" name="title" id="Jtitle"  value=""/>
    <input type="hidden" name="caption" id="Jcaption"  value=""/>
    <input type="hidden" name="description" id="Jdescription"  value=""/>
  </form>
  <form action="../index.php/photo-gallery/" method="get" id="redirectForm"></form>
</div>
</body>
</html>
