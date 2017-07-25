# Add a View Page From the Gallery

## This page will display a full-size version of an image selected from the Gallery

Again, start with a simple HTML template, below - and name it **view.php**:

```
<!DOCTYPE html>
<html>
<head>
<title>Detail View</title>
    <link href="http://yourname.designcodebuild.com/images/icon.png" rel="apple-touch-icon" sizes="114x114" />
    <link rel="stylesheet" href="http://mxcd.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <link rel="stylesheet" href="style.css" />
    <script type="text/javascript" src="caman.full.js"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
<script>


</script>
</head>
<body>

</body>
</html>
```

This time, you are going to add PHP code inside the BODY that will not only pull in the large version of the image chosen from the gallery - but will also pull in the caption, and dynamically create the **containers** and **formatting** for the image. 

## Pull in the image with PHP
 
Inside the &lt;body&gt; tags, type or paste this code:

```
  <?php
    include("basicCaman.php");
    $list = ce_get_database_list("your_database", "your_databaseusername", "yourdatabasepassword", "yourtablename");
    
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
```

Substitute the **ce_get_database_list** with your database credentials. 

