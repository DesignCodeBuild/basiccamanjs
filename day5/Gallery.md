#Gallery

##Create your gallery page.

Create a new .php file and name it gallery.php. Start it off as another basic web page by either typing the code below or copying and pasting the code from yesterday's **select.php** file - but delete everything inside ````<body>... </body>```` and ````<script>... </script>````. It should look like this:

````
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


</body>
</html>
````
**(Where it says http://yourname.designcode... of course change yourname to your directory name.)**

##Add the code to display the uploaded and edited images

**Inside ````<body>... </body>````, add this:

````
 <h1>Gallery</h1>
  <div id="contain">
  <?php
    include("basicCaman.php");
    $list = ce_get_database_list("yourname_database", "yourname_caman", "kuR[GuBHE801", "photos");
    
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
````

And again, where it says "yourname", change it to the name of your database. **Hint:** you probably named the database after your application, rather than your own name. If you are unsure, go to yourname.designcodebuild.com:2083, log in, find the **phpMyAdmin** button to look at your database and confirm. Write down the database details in your notebook.




