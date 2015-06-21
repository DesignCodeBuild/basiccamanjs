#Simplified Caman.js & Wordpress

## Important notes
+ Use the NEWEST release of CamanJS: the one from github.  Because 4.1.1 and the CDN version have a bug in Caman.revert(true)
+ Must transfer image from CamanJS to php through AJAX, and must reconfigure base64 because it contains '/', ';', ':', '+', '/'.  Currently, it converts to html character codes.
+ It is difficult to deal with thumbnails because there is a specific size (in this case, 604, 270) that is determined by the theme, where the url will vary.
+ We basically only need to use basicCaman.js and basicCaman.php.

##Using it / ideas for using it
We can split the process into four sections:
+ Pre: Setup wordpress and create a page with the photo gallery.
+ Section 1: Choose a file to upload (e.g. begin.php)
+ Section 2: Edit the image with CamanJS (e.g. second.php)
+ Section 3: Send the image to (e.g. acceptImages.php)

####Pre: Using wordpress
Create a wordpress page (or post).  Inside it, insert a gallery.  The gallery can be located anywhere in the page, but **there can only be one gallery per page**.  Find the page ID by going to edit the page and clicking **Get Shortlink**.  This will be useful later.

####Section 1: Choose a file
Create a button to choose an image to upload.  Style the page, and this is the important code:
```html
  <form action="second.php" method="post" enctype="multipart/form-data" id="imageForm">
      <input type="file" name="image" id="image" onChange="uploadImage()" />
  </form>
```
Initially, a submit button can be used; however, it might be more effective to go directly to the edit page:
```javascript
function uploadImage()
{
  document.getElementById("imageForm").submit();
}
```
Or, using jQuery:
```javascript
$( document ).ready(function() {
  $("#image").on("change, function(){
    $("#imageForm").submit();
  });
});
```

####Section 2: Save the file
Recieve the image data like this:
```php
$imageData = $_FILES["image"];
```
Note that $imageData is an array containing information related to the file.  For initial purposes, we probably want to save this file somewhere on the server to use it:
```php
$imageData = $_FILES["image"];
$filename = $imageData["name"];
$temporaryLocation = $imageData["tmp_name"];
move_uploaded_file($temporaryLocation, $filename);
```
It's important that some users may not upload correct data types: we can only handle png and jpg images.
```php
$imageType = $imageData["type"];
```
We can write if statements that check mime types from $imageType to see if it is accepted.  This will follow the general structure of*function ce_find_extention()* in *basicCaman.php*  or to save time, use these libraries.  First, include **basicCaman.php**
```php
require_once("/path/to/basicCaman.php");
```
Next, use *ce_find_extention()*: This function will return *(false)* if given an invalid mime type; otherwise, it will return the string "png" or "jpg".  We can use if loops to determine what happens.
```php
$imageExtention = ce_find_extention($imageType);
if($imageExtention === false) // === instead of == because $imageExtention can be either boolean or string; == would probably work too.
{
  echo "Sorry, we only accept png and jpg images.";
}
else
{
  move_uploaded_file($temporaryLocation, $filename);
}
```

##Currently...
+ begin.php -> second.php -> w/acceptImages.php (through ajax)
  - begin.php is only a prompt to upload an image
  - second.php:
    + begins by copying the image from /tmp (on server) to [wordpresshome]/wp-content/uploads/year/month/_filename.ext_
    + It then allows for camanjs to edit the image.
    + Once the image is edited, it converts it to base64 ascii characters, which are modified and sent through ajax post request to wordpress/acceptImages.php
  - acceptImages.php (using wordpress functions):
    + Deals with all the info that just got submitted
    + Creates necessary thumbnails
    + Add image to mysql databases so that wordpress knows that it exists and is an image
    + Alter the photo gallery to include that image (updates actually don't matter; current code will add images without reverting to previous versions)
