<!DOCTYPE html>
<html>
<head>
<title>Gallery</title>
<style>
#contain {
  width:670px;
  display:block;
  margin: 0 auto;
}
#img {
  width:100px;
  margin: 5px;
  float:left;
}
h1 {
  text-align:center;
}
</style>
<script>
</script>
</head>
<body>
  <h1>Gallery</h1>
  <div id="contain">
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
  </div>
</body>
</html>
