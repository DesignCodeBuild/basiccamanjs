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
h1, h3, .ctr {
  text-align:center;
}
</style>
<script>
function reaction(rid)
{ // rid = reaction id
  
  
}
</script>
</head>
<body>
  <?php
    include("basicCaman.php");
    $list = ce_get_database_list("david_database", "david_caman", "kuR[GuBHE801", "photos");
    
    foreach($list as $image)
    {
      if($_POST['s'] == $image['filename'])
      {
        echo "<h1>" . $image['title'] . "</h1>";
        echo "<img src='./images/" . $image['filename'] . "' alt='" . $image['title'] . "' />";
        echo "<input type='hidden' id='filename' value='" . $image["filename"] . "' />";
	echo "<h3>" . $image['caption'] . "</h3>";
	echo "<div class='ctr'>" . $image['description'] . "</div>";
        
        $reactions = explode("|",$image['reactions']);
        for($i=0;$i<count($reactions);++$i)
        {
	  echo "<span class='irct'>" . $reactions[$i] ."</span>";
	  echo "<a href='javascript:react('$i')'>" . "<img src='reactions/$i.png' /></a>"
        }
        
        
        
        break;
      }
    }    
    
  ?>
</body>
</html>
