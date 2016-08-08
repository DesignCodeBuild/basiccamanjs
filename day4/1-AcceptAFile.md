#Accept A File Upload

##First, double-check your **send** file (which is the index.html page with the **form** you just created in the last step):

Make sure the form includes the **enctype** parameter. This helps the data from your uploaded image to be transmitted to and read accurately by the server so the image does not appear broken. 

```html
  <form ... enctype="multipart/form-data">
```

##Start filters.php

Create a new HTML file in your code editor and call it **filters.php**

Again, start off with your standard HTML setup:

```html
<!DOCTYPE html>
<html>
<head>
  <title>My Title</title>
</head>
<body>
</body>
</html>
```
**Save it, then follow the instructions below to add PHP to this file:**

##Create the PHP Section

Add a php section at the top, BEFORE the DOCTYPE line.

```php
<?php

?>
<!DOCTYPE html> ...
```
##Now, add this code inside the **php** tag.

**This will enable your page to retrieve information about the image file that was uploaded. See the comments after the // below for explanations of each $argument:**

```php
require_once("basicCaman.php");

//This retrieves all the image data that we sent from the previous HTML file.  It is an array.
$image_data = $_FILES["image"];
//Part of the array is the "mime type" which identifies what kind of image it is that we're using.
$mimeType = $image_data['type'];

// This uses a function to determine the file extension based on the mime type.
//   If it is unsupported, it will return (false).
$image_extension = ce_find_extension($mimeType);

// Variable for file name
$target_file;

echo "This is a " . $image_extension . " file!";

```
**Now, let's check to see if the PHP arguments work before adding more to the code.

To check it, first upload (FTP) your new **filters.php** file to your site. Then, get **basicCaman.php** from here and also upload it to your site. 

You can read about what **basicCaman.php** is and why you need it **here**.

##Check for errors

Now instead of this:

```php
echo "This is a " . $image_extension . " file!";
```

##Test this step:


Do this:

```php
if($image_extension === false)
{
  // Redirect to the previous page, and tell it that the image type was incorrect.
  header( "Location: begin.php?q=type" ) ;
  
}
else
{
  // Create a random string of numbers and characters to use as a file name.
  $random_string = ce_random_string();
  // Make a file name from the random numbers and extension.
  $filename = $random_string . "." . $image_extension;

  // Figure out where we will put the images.
  $dir = "tmp_images/";
  // Combine the file name and directories to determine where the file will go
  $target_file = $dir . $filename;
  //echo $target_file;

  // Move the temporary image file to a new location.
  if(move_uploaded_file($image_data["tmp_name"], $target_file))
  {
    // This will crop it to no more than 640 px per side.
    ce_img_resize($target_file, $target_file, $image_extension, 640,640,true);
  }
  // If moving the file is unsuccessful, redirect to the last page to report that it didn't work.
  else
  {
    // Redirect to the previous page, and tell it that there was an unknown error
    header( 'Location: begin.php?q=error' ) ;
  }
}
```

##FINAL

```php
<?php
require_once("basicCaman.php");

//This retrieves all the image data that we sent from the previous HTML file.  It is an array.
$image_data = $_FILES["image"];
//Part of the array is the "mime type" which identifies what kind of image it is that we're using.
$mimeType = $image_data['type'];

// This uses a function to determine the file extension based on the mime type.
//   If it is unsupported, it will return (false).
$image_extension = ce_find_extension($mimeType);

if($image_extension === false)
{
  // Redirect to the previous page, and tell it that the image type was incorrect.
  header( "Location: begin.php?q=type" ) ;

}
else
{
  // Create a random string of numbers and characters to use as a file name.
  $random_string = ce_random_string();
  // Make a file name from the random numbers and extension.
  $filename = $random_string . "." . $image_extension;

  // Figure out where we will put the images.
  $dir = "tmp_images/";
  // Combine the file name and directories to determine where the file will go
  $target_file = $dir . $filename;
  //echo $target_file;

  // Move the temporary image file to a new location.
  if(move_uploaded_file($image_data["tmp_name"], $target_file))
  {
    // This will crop it to no more than 640 px per side.
    ce_img_resize($target_file, $target_file, $image_extension, 640,640,true);
  }
  // If moving the file is unsuccessful, redirect to the last page to report that it didn't work.
  else
  {
    // Redirect to the previous page, and tell it that there was an unknown error
    //header( 'Location: begin.php?q=error' ) ;
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>My Title</title>
</head>
<body>
</body>
</html>

```
