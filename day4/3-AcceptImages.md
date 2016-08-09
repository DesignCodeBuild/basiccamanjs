#Accepting Images

This is another php file.  Set up the php:

```php
<?php


?>
```

And save it as **acceptImages.php**.

This file will **put the images into the database**.

##Include basicCaman.php

First include basicCaman.php, which will give us a lot of necessary functions.

```php
  require_once('basicCaman.php');
```

##Next, gather the information.

We will eventually be gathering data about the images to put in the database.  This collects the data and puts it in variables.

```php
  $image_data = ce_unescape_string($_POST['data']);
  $image_tmp_location = ce_unescape_string($_POST['tmploc']);
  $image_type = $_POST['type'];
  $image_mime_type = ce_create_mime_type($image_type);
  $image_caption = ce_unescape_string($_POST['caption']);
```

##Define image directory & choose an image name

```php
  $image_directory = "./images/";

  $image_name = ce_random_string();
```

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
    $data['title'] = $image_title;
    $data['caption'] = $image_caption;
    $data['description'] = $image_description;
    ce_add_to_database($data, C_DATABASENAME, C_USERNAME, C_PASSWORD, C_TABLE);
```

##Type in database info:

Instead of C\_DATABASENAME, C\_USERNAME, C\_PASSWORD, and C\_TABLE, type your login information.

##FINAL

Everything put together:

```php
<?php
  require_once('basicCaman.php');

  $image_data = ce_unescape_string($_POST['data']);
  $image_tmp_location = ce_unescape_string($_POST['tmploc']);
  $image_type = $_POST['type'];
  $image_mime_type = ce_create_mime_type($image_type);
  $image_description = ce_unescape_string($_POST['description']);
  $image_caption = ce_unescape_string($_POST['caption']);
  $image_title = ce_unescape_string($_POST['title']);

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
    $data['title'] = $image_title;
    $data['caption'] = $image_caption;
    $data['description'] = $image_description;
    ce_add_to_database($data, C_DATABASENAME, C_USERNAME, C_PASSWORD, C_TABLE);
  }
  else
  {
    // say "nothing" so we know why it didn't put it in the database.
    echo "nothing.";
  }
?>
```
