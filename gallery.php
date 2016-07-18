<!DOCTYPE html>
<html>
<head>
<title>Gallery</title>
    <link href="http://yourname.designcodebuild.com/images/icon.png" rel="apple-touch-icon" sizes="114x114" />
    <link rel="stylesheet" href="http://mxcd.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <link rel="stylesheet" href="style.css" />
    <script type="text/javascript" src="caman.full.js"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
<script>

</script>
</head>
<body>
<h1>Gallery</h1>
  <div id="contain">
  <?php
    include("basicCaman.php");
    $list = ce_get_database_list("halley_photodatabase", "halley_shopaholi", "858Halley!", "photos");

    foreach($list as $imagedata)
    {
      ?> <a href="images/<?php
      echo $imagedata['filename'];
      ?>"><img src="images/<?php
      echo ce_add_thumbnail_suffix($imagedata['filename']);
      ?>" /></a> <?php
    }

  ?>
  </div>
</body>
</html>
