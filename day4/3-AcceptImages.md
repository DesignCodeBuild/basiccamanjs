#Accepting Images

This is another php file.  Set up the php:

```php
<?php


?>
```

And save it as **acceptImages.php**.

This file will **put the images into the database**. So, this file provides the code to send images to a database, but first you will need to actually have a database. [Follow the steps here](https://github.com/DesignCodeBuild/basiccamanjs/blob/master/day3/2-createDatabase.md) if you have not created one yet. 

##Include basicCaman.php

First include basicCaman.php, which will give us a lot of necessary functions.

```php
  require_once('basicCaman.php');
```

##Next, gather the information.

We will eventually be gathering data about the images to put in the database.  This collects the data and puts it in variables. Copy these lines, below, and paste them inside the PHP tag below the basicCaman.php line:

```php
  $image_data = ce_unescape_string($_POST['data']);
  $image_tmp_location = ce_unescape_string($_POST['tmploc']);
  $image_type = $_POST['type'];
  $image_mime_type = ce_create_mime_type($image_type);
  $image_caption = ce_unescape_string($_POST['caption']);
```

##Define image directory & choose an image name

Enter these lines below the previous lines. Add comments above any lines to provide reference notes for yourself by prefacing them with //:

```php
  $image_directory = "./images/";

  $image_name = ce_random_string();
```
See where it says "./images/"? The code is telling the application to store the uploaded image inside that folder on your server. So, you will need to make sure there is a folder called "images" on your server (using an FTP client i.e. CyberDuck) create this folder in the same directory as your php files, and make sure it has the right permissions. Basically, chmod 777 or "others read write execute". 


##Check if data actually exists

If there's no actual image data, we shouldn't put an empty image in the database.

```php
  if($image_data != "")
  {
    // Database code goes here.
  }
  else
  {
    // say "nothing" so we know why it didn't put it in the database.
    echo "nothing.";
  }
```

##Save the file on the server & in the database.

In the place that says //Database code goes here, type this:

```php
    // delete old file
    unlink($image_tmp_location);
    $filestream = fopen($image_directory.$image_name.".".$image_type, "wb");
    fwrite($filestream, ce_base64_to_image($image_data));
    fclose($filestream);
  
    ce_create_thumbnails($image_directory . $image_name . "." . $image_type);
    $data['filename'] = $image_name.".".$image_type;
    $data['caption'] = $image_caption;
    ce_add_to_database($data, C_DATABASENAME, C_USERNAME, C_PASSWORD, C_TABLE);
```

##Type in database info:

Instead of C\_DATABASENAME, C\_USERNAME, C\_PASSWORD, and C\_TABLE, type your login information. They will need to be inside double quotes, so for example:

```
    ce_add_to_database($data, "yourdatabasename", "yourusername", "yourpassword", "yourtablename");
```

##FINAL

Everything put together:

```php
<?php
  require_once('basicCaman.php');

  $image_data = ce_unescape_string($_POST['data']);
  $image_tmp_location = ce_unescape_string($_POST['tmploc']);
  $image_type = $_POST['type'];
  $image_mime_type = ce_create_mime_type($image_type);
  $image_caption = ce_unescape_string($_POST['caption']);

  $image_directory = "./images/";

  $image_name = ce_random_string();

  if($image_data != "")
  {
    // delete old file
    unlink($image_tmp_location);
    $filestream = fopen($image_directory.$image_name.".".$image_type, "wb");
    fwrite($filestream, ce_base64_to_image($image_data));
    fclose($filestream);
  
    ce_create_thumbnails($image_directory . $image_name . "." . $image_type);
    $data['filename'] = $image_name.".".$image_type;
    $data['caption'] = $image_caption;
    ce_add_to_database($data, C_DATABASENAME, C_USERNAME, C_PASSWORD, C_TABLE);
  }
  else
  {
    // say "nothing" so we know why it didn't put it in the database.
    echo "nothing.";
  }
?>
```
You can upload this file to your server now - but you won't be able to properly test it until you **[add a SAVE button](https://github.com/DesignCodeBuild/basiccamanjs/blob/master/day4/4-SendImages.md)** to the filter.php page. 
