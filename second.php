<!DOCTYPE html>

<?php

$wordpressHome = "../";

//Figure out if the image is real and what format it is

$imageData = $_FILES["image"];
$type = $imageData['type'];
$ext = "";

if($type == "image/jpg" || $type== "image/jpeg")
  $ext = "jpg";
if($type == "image/png")
  $ext = "png";

if($type != "image/png" && $type != "image/jpg" && $type != "image/jpeg")
  {
  //echo "<h2 style=\"color:red\">Sorry, we can only process PNG or JPG images.</h2> <br /> <a href=\"begin.php\">Try Again</a>";
  }

// 
//

else {
  $hash = substr(base_convert(hash("md5", date("d m Y G i s u"), false), 16, 32), 0, 11);
  $filename = $hash . "." . $ext; 
//  $target_dir = "uploads/";
  $target_dir = "wp-content/uploads/" . date("Y") . "/";
  //Check to see if year directory exists:
  if(!is_dir($wordpressHome.$target_dir))
    mkdir($wordpressHome.$target_dir);
  //Check to see if month directory exists:
  $target_dir .=  date("m") . "/";
  if(!is_dir($wordpressHome.$target_dir))
    mkdir($wordpressHome.$target_dir);
  
  $target_file = $wordpressHome. $target_dir . $filename;
  
  /*if(*/move_uploaded_file($imageData["tmp_name"], $target_file);//) echo "worked<br />";
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
  
  function updateCaman()
  {
    for(var i=0;i<controls.length;++i)
    {
      var $tfilter = controls[i];
      var $tvalue = $("#" + controls[i]).val();
      $("#" + controls[i] + "_label").text($tvalue);
      if($tfilter != "gamma" && parseInt($tvalue) != 0) {
        caman[$tfilter](parseFloat($tvalue, 10));
      }
      if($tfilter == "gamma" && parseInt($tvalue) != 1) {
        caman[$tfilter](parseInt($tvalue)+1);
      }
    }
  }

  function safeBase64(input)
  {
    var output="";
    for(var i=0;i<input.length;++i)
    {
      if(input.charAt(i) == '/')
        output += "^";
      else if(input.charAt(i) == ':')
        output += "*";
      else if(input.charAt(i) == ';')
        output += "_";
      else if(input.charAt(i) == '+')
        output += "-";
      else if(input.charAt(i) == '=')
        output += "~";
      else {
        output += input.charAt(i);
      }
    } 
    return output;
  //  return input;
  }

  function ajaxSend(imageData, imageName, imageType, imageDir, imageTitle, imageCaption, imageDescription)
  {
  
    $.ajax({
      method: "POST", 
      url: "acceptImages.php",
      data: {data: safeBase64(imageData), name: imageName, type: imageType, dir: safeBase64(imageDir), title: safeBase64(imageTitle), caption: safeBase64(imageCaption), description: safeBase64(imageDescription)}
    }); 
   /*
    $("#Jdata").val(imageData);
    $("#Jname").val(imageName);
    $("#Jtype").val(imageType);
    $("#Jdir").val(imageDir);
    $("#Jtitle").val(imageTitle);
    $("#Jcaption").val(imageCaption);
    $("#Jdescription").val(imageDescription);
    $("#testForm").submit(); */
  } 
  
  var controls= Array("brightness", "saturation", "exposure", "gamma", "clip", "stackBlur", "contrast", "vibrance", "hue", "sepia", "noise", "sharpen");
  var filters = {};
  $( document ).ready(function() {
    for(var i=0;i<controls.length;++i)
      $("#"+controls[i]).val("0");


//  $( "input" ).each(function() {
//    var filter=this.data("filter");
//    filters.push(filter);
//  });
    $( "input" ).on("change", function() {
      //var $tfilter = $(this).data("filter");
      //var $tval = $(this).val();
      caman.revert(false);
      updateCaman();
      caman.render();
    });
  
    $( "#save" ).on("click", function(){
      caman.revert(false);
      updateCaman();
      caman.render(function(){
        var imageData = caman.toBase64("<?php echo "jpeg"; ?>");
        $("#txtarea").text(safeBase64(imageData));
        ajaxSend(imageData, "<?php echo $hash; ?>", "<?php echo $ext; ?>", "<?php echo $target_dir; ?>", $("#title").val(), $("#caption").val(),$("#descrip").val());
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
  <!--form action="wordpress/acceptImages.php" id="testForm" method="post">
    <input type="hidden" name="data" id="Jdata" value=""/>
    <input type="hidden" name="name" id="Jname" value=""/>
    <input type="hidden" name="type" id="Jtype"  value=""/>
    <input type="hidden" name="dir" id="Jdir"  value=""/>
    <input type="hidden" name="title" id="Jtitle"  value=""/>
    <input type="hidden" name="caption" id="Jcaption"  value=""/>
    <input type="hidden" name="description" id="Jdescription"  value=""/>
  </form-->
</div>
</body>
</html>
