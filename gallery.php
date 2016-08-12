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
    //$list = ce_get_database_list("cathdcb_photodatabase", "cathdcb_cath", "858Cath!", "photos");
    $list = ce_get_database_list("david_database", "david_caman", "kuR[GuBHE801", "photos2");

    foreach($list as $imagedata)
    {
      ?> <a href="view.php?s=<?php
      echo $imagedata['filename'];
      ?>"><img src="images/<?php
      echo ce_add_thumbnail_suffix($imagedata['filename']);
      ?>" /></a> <?php
    }

  ?>
  </div>


</body>
</html>
