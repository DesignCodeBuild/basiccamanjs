<!DOCTYPE html>

<?php
$imageData = $_FILES["image"];
$type = $imageData['type'];
$ext = "";

if($type == "image/jpg" || $type== "image/jpeg")
  $ext = "jpg";
if($type == "image/png")
  $ext = "png";

if($type != "image/png" && $type != "image/jpg" && $type != "image/jpeg")
  {}
  //echo "<h2 style=\"color:red\">Sorry, we can only process PNG or JPG images.</h2> <br /> <a href=\"begin.php\">Try Again</a>";
else {
  $filename = substr(hash("md5", date("d m Y G i s u"), false), 0, 12) . "." . $ext;
  $target_dir = "uploads/";
  $target_file = $target_dir . $filename;
  
  if(move_uploaded_file($imageData["tmp_name"], $target_file)) echo "worked<br />";
//  else echo "didn't work<br />";
  
//  echo "<a href=\"" . $target_file . "\">" . $target_file . "</a>";
  }

?>
<html>
<head>
  <title>Edit Image <?php echo $target_file; ?></title>
  <script type="text/javascript" src="caman/caman.full.min.js"></script>
  <script type="text/javascript" src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
<script>
  caman = Caman("#toEdit");
  $( document ).ready(function() {
    var controls= Array("brightness", "saturation", "exposure", "gamma", "clip", "stackBlur", "contrast", "vibrance", "hue", "sepia", "noise", "sharpen");
    for(var i=0;i<controls.length;++i)
      $("#"+controls[i]).val("0");

  var filters = {};

//  $( "input" ).each(function() {
//    var filter=this.data("filter");
//    return filters[filter]=this.val();
//  });
  $( "input" ).on("change", function() {
    //var $tfilter = $(this).data("filter");
    //var $tval = $(this).val();
    caman.revert(false);
    for(var i=0;i<controls.length;++i)
    {
      var $tfilter = controls[i];
      var $tvalue = $("#" + controls[i]).val();
      if($tfilter != "gamma")
        caman[$tfilter](parseInt($tvalue));
      else
        caman[$tfilter](parseInt($tvalue)+1);
    }
    caman.render();
  });
/*
    $("#brightness").change(function(){
      Caman("#toEdit", function(){
        this.revert(false);
        this.brightness(parseInt($("#brightness").val()));
        this.render();
      }) });
    $("#saturation").change(function(){
      Caman("#toEdit", function(){
        this.revert();
        this.saturation($("#saturation").val());
        this.render();
      }) });
    $("#exposure").change(function(){
      Caman("#toEdit", function(){
        this.revert();
        this.exposure($("#exposure").val());
        this.render();
      }) });
    $("#gamma").change(function(){
      Caman("#toEdit", function(){
        this.revert();
        this.gamma((parseInt($("#gamma").val())+1).toString());
        this.render();
      }) });
    $("#clip").change(function(){
      Caman("#toEdit", function(){
        this.revert();
        this.clip($("#clip").val());
        this.render();
      }) });
    $("#stackBlur").change(function(){
      Caman("#toEdit", function(){
        this.revert();
        this.stackBlur($("#stackBlur").val());
        this.render();
      }) });
    $("#contrast").change(function(){
      Caman("#toEdit", function(){
        this.revert();
        this.contrast(parseInt($("#contrast").val()));
        this.render();
      }) });
    $("#vibrance").change(function(){
      Caman("#toEdit", function(){
        this.revert();
        this.vibrance($("#vibrance").val());
        this.render();
      }) });
    $("#hue").change(function(){
      Caman("#toEdit", function(){
        this.revert();
        this.hue($("#hue").val());
        this.render();
      }) });
    $("#sepia").change(function(){
      Caman("#toEdit", function(){
        this.revert();
        this.sepia($("#sepia").val());
        this.render();
      }) });
    $("#noise").change(function(){
      Caman("#toEdit", function(){
        this.revert();
        this.noise($("#noise").val());
        this.render();
      }) });
    $("#sharpen").change(function(){
      Caman("#toEdit", function(){
        this.revert();
        this.sharpen($("#sharpen").val());
        this.render();
      }) });
*/
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
  img.right
  {
    float:right;
    width:550px;
  }
</style>
</head>
<body>

<div class="container">
  <div class="leftForm">
    <form action="third.php" method="post">
      Brightness:
      <input type="range" name="brightness" id="brightness" data-filter="brightness" min="-100" max="100" /> <br />
      Saturation:
      <input type="range" name="saturation" id="saturation" data-filter="saturation" min="-100" max="100" /> <br />
      Exposure:
      <input type="range" name="exposure" id="exposure" data-filter="exposure" min="-100" max="100" /> <br />
      Gamma:
      <input type="range" name="gamma" id="gamma" data-filter="gamma" min="0" max="10" /> <br />
      Clip:
      <input type="range" name="clip" id="clip" data-filter="clip" min="0" max="100" /> <br />
      Blur:
      <input type="range" name="stackBlur" id="stackBlur" data-filter="stackBlur" min="0" max="20" /> <br />
      Contrast:
      <input type="range" name="contrast" id="contrast" data-filter="contrast" min="-100" max="100" /> <br />
      Vibrance:
      <input type="range" name="vibrance" id="vibrance" data-filter="vibrance" min="-100" max="100" /> <br />
      Hue:
      <input type="range" name="hue" id="hue" data-filter="hue" min="0" max="100" /> <br />
      Sepia:
      <input type="range" name="sepia" id="sepia" data-filter="sepia" min="0" max="100" /> <br />
      Noise:
      <input type="range" name="noise" id="noise" data-filter="noise" min="0" max="10" /> <br />
      Sharpen:
      <input type="range" name="sharpen" id="sharpen" data-filter="sharpen" min="0" max="100" /> <br />
    </form>
  </div>
  <img src="<?php echo $target_file; ?>" id="toEdit" style="float:right;width:550px;" />
</div>
</body>
</html>
