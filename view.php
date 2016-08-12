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
<script type="text/javascript" src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
<script>
function likeThis()
{
  var filename = $("#mainimg").attr("src");

  // crop it so it's just "l3i34ysdclsi.png";
  var position = filename.lastIndexOf("/");
  filename = filename.substring(position+1);

  // make the url;
  var likeurl = "likes.php?file=" + filename;
  
  $.ajax({
    method: "GET", 
    context: this,
    url: likeurl
  }).done(function (result) {
    if(result == 'y')
    {
      var Likes = parseInt($("#likecount").text());
      $("#likecount").text(Likes + 1);
      
    }
  });
}
</script>
</head>
<body>
  <?php
    include("basicCaman.php");
    $list = ce_get_database_list("david_database", "david_caman", "kuR[GuBHE801", "photos2");
    
    if(isset($_GET['s']))
    {
      foreach($list as $image)
      {
        if($_GET['s'] == $image['filename'])
        {
          echo "<h1>" . $image['title'] . "</h1>";
          echo "<img src='./images/" . $image['filename'] . "' alt='" . $image['title'] . "' id='mainimg' />";
          echo "<input type='hidden' id='filename' value='" . $image["filename"] . "' />";
	  echo "<h3>" . $image['caption'] . "</h3>";
	  echo "<div class='ctr'>" . $image['description'] . "</div>";
          
          echo "<div id='likes'><span id='likecount'>" . $image['likes'] . "</span> Likes.  <a href='javascript:likeThis()' id='lti'>Like this image</a></div>";
          
          
          break;
        }
      }    
    }
    
  ?>
</body>
</html>
