<!DOCTYPE html>
<html>
<head>
<title>View [img}</title>
<style>
img {
  display:block;
  max-width:70%;
  margin: 0 auto;
}
h1 {
  text-align:center;
}
</style>
<script>
</script>
</head>
<body>
  <?php
    include("basicCaman.php");
    $list = ce_get_database_list("david_database", "david_caman", "kuR[GuBHE801", "photos");
    
    foreach($list as $imagedata)
    {
      ?> <a href="images/<?php
      echo $imagedata['filename'];
      ?>"><img src="images/<?php
      echo ce_add_thumbnail_suffix($imagedata['filename']);
      ?>" /></a> <?php
    }
    
  ?>
</body>
</html>
