<!DOCTYPE html>

<?php
// Important functions that make this easier
require_once("basicCaman.php");

// Identify where wordpress is installed relative to our current directory.
$wordpress_home = "../";

//Base64-encoded image
$image_data = ce_unescape_string($_POST['data']);
//png or jpg
$image_type = $_POST['type'];
//Old location: so we can delete it when completed.
$image_tmp_location = ce_unescape_string($_POST['tmp_location']);

//Don't run if there's no image there
if($image_data != "")
{
  //Write to "tmp location" (w) as binary (b)
  $filestream = fopen($image_tmp_location, "wb");
  fwrite($filestream, ce_base64_to_image($image_data));
  fclose($filestream);
}

?>
<html>
<head>
  <title>Edit Image <?php echo $image_tmp_location; ?></title>
  <script type="text/javascript" src="caman/caman.full.min.js"></script>
  <script type="text/javascript" src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
  <script type="text/javascript" src="basicCaman.js"></script>
<script>
  var caman = Caman("#toEdit");
  
  var MyControls = {brightness: "brightness", saturation: "saturation", exposure: "exposure", gamma:"gamma", clip: "clip", stackBlur: "stackBlur", contrast:"contrast", vibrance:"vibrance", hue:"hue", sepia:"sepia", noise:"noise", sharpen:"sharpen"};

  $( document ).ready(function() {

    ceResetRanges(MyControls);

    $( "input" ).on("change", function() {
      caman.revert(false);
      ceUpdateCaman(caman, MyControls);
      caman.render();
    });

    $( "#undo" ).on("click", function() {
      ceResetRanges(MyControls);
      caman.revert(true);
    });
  
    $( "#save" ).on("click", function(){
      caman.revert(false);
      ceUpdateCaman(caman, MyControls);
      caman.render(function(){
      var imageData = caman.toBase64("<?php echo ce_caman_image_type($image_type); ?>");
      var allData = {data: ceEscapeString(imageData), tmploc: ceEscapeString("<?php echo $image_tmp_location; ?>"), type: "<?php echo $image_type; ?>", title: ceEscapeString($("#title").val()), caption: ceEscapeString($("#caption").val()), description: ceEscapeString($("#descrip").val())};
        ceAjaxSend("acceptImages.php", allData, "../index.php/photo-gallery/");
//"../index.php/photo-gallery/", imageData, "<?php echo $random_string; ?>", "<?php echo $image_extention; ?>", "<?php echo $wp_media_dir; ?>", $("#title").val(), $("#caption").val(),$("#descrip").val());
      });
    });
  
  });
</script>
<link rel="stylesheet" type="text/css" href="bootstrap/bootstrap.min.css" />
<style>
  div.container
  {
    display:block;
    width:800px;
  }
  div.fright
  {
    float:right;
    width:350px;
  }
  div.leftForm
  {
    float:left;
    width:200px;
  }
  div.featured
  {
    display:block;
    margin-top:10px;
    margin-left: auto;
    margin-right: auto;
    width:640px;
  }
#title_d
  {
    display:block;
    margin-right:auto;
    margin-left:auto;
    width:320px;
  }
#caption_d
  {
    float: left;
    width:320px;
  }
#descrip_d
  {
    float:right;
    width:320px;
  }
</style>
</style>
</head>
<body>
<h1 style="text-align:center;">Final Touches</h1>
<div class="featured">
  <div id="title_d">Title: <input type="text" id="title" /></div>
  <div id="caption_d">Caption: <input type="text" id = "caption" /></div>
  <div id="descrip_d">Description: <input type="text" id="descrip" /></div><br />
    <br style="clear:both;"/> 
  <button class="btn btn-danger" style="float:left;width:150px;margin-left:100px;" id="undo">Undo Changes</button>
  <button class="btn btn-primary" style="float:right;width:150px;margin-right:100px;" id="save">Save</button>
    <br style="clear:both;" />
</div>
<div class="featured">
  <img id="toEdit" src="<?php echo $image_tmp_location; ?>" />
</div>
<form action="third.php" method="post">
  <div style="display:block;margin-left:auto;margin-right:auto;width:550px">
    <div style="float:left;width:240px;">
      Brightness (<span id="brightness_label">0</span>) <br />
      <input type="range" name="brightness" id="brightness" data-filter="brightness" min="-100" max="100" /> <br />
      Saturation (<span id="saturation_label">0</span>) <br />
      <input type="range" name="saturation" id="saturation" data-filter="saturation" min="-100" max="100" /> <br />
      Exposure (<span id="exposure_label">0</span>) <br />
      <input type="range" name="exposure" id="exposure" data-filter="exposure" min="-100" max="100" /> <br />
      Gamma (<span id="gamma_label">0</span>) <br />
      <input type="range" name="gamma" id="gamma" data-filter="gamma" min="0" max="10" /> <br />
      Clip (<span id="clip_label">0</span>) <br />
      <input type="range" name="clip" id="clip" data-filter="clip" min="0" max="100" /> <br />
      Blur (<span id="stackBlur_label">0</span>) <br />
      <input type="range" name="stackBlur" id="stackBlur" data-filter="stackBlur" min="0" max="20" /> <br />
    </div>
    <div style="float:right;width:240px;">
      Contrast (<span id="contrast_label">0</span>) <br />
      <input type="range" name="contrast" id="contrast" data-filter="contrast" min="-100" max="100" /> <br />
      Vibrance (<span id="vibrance_label">0</span>) <br />
      <input type="range" name="vibrance" id="vibrance" data-filter="vibrance" min="-100" max="100" /> <br />
      Hue (<span id="hue_label">0</span>) <br />
      <input type="range" name="hue" id="hue" data-filter="hue" min="0" max="100" /> <br />
      Sepia (<span id="sepia_label">0</span>) <br />
      <input type="range" name="sepia" id="sepia" data-filter="sepia" min="0" max="100" /> <br />
      Noise (<span id="noise_label">0</span>) <br />
      <input type="range" name="noise" id="noise" data-filter="noise" min="0" max="10" /> <br />
      Sharpen (<span id="sharpen_label">0</span>) <br />
      <input type="range" name="sharpen" id="sharpen" data-filter="sharpen" min="0" max="100" /> <br />
    </div>
  </div>
</form>
  <!--textarea id="txtarea"></textarea-->
  <form action="acceptImages.php" id="testForm" method="post">
    <input type="hidden" name="data" id="Jdata" value=""/>
    <input type="hidden" name="type" id="Jtype"  value=""/>
    <input type="hidden" name="tmploc" id="Jdir"  value=""/>
    <input type="hidden" name="title" id="Jtitle"  value=""/>
    <input type="hidden" name="caption" id="Jcaption"  value=""/>
    <input type="hidden" name="description" id="Jdescription"  value=""/>
  </form>
</div>
</body>
</html>
