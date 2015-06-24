#Simplified Caman.js & Wordpress

## Important notes
+ Remember to add capital/lowercase support for extentions
+ Use the NEWEST release of CamanJS: the one from github.  Because 4.1.1 and the CDN version have an issue in Caman.revert(true)
+ Must transfer image from CamanJS to php through AJAX, and must reconfigure base64 because it contains '/', ';', ':', '+', '/'.  Currently, it converts to html character codes.
+ It is difficult to deal with thumbnails because there is a specific size (in this case, 604, 270) that is determined by the theme, where the url will vary.
+ We basically only need to use basicCaman.js and basicCaman.php.

##Using it / ideas for using it
We can split the process into four sections:
+ **Pre**: Setup wordpress and create a page with the photo gallery.
+ **Section 1**: Choose a file to upload (e.g. begin.php)
+ **Section 2**: Edit the image with CamanJS (e.g. second.php)
+ **Section 3**: Send the image to (e.g. acceptImages.php)

####Pre: Wordpress
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
if($imageExtention === false) // === instead of == because 
    // $imageExtention can be either boolean or string
    // Nevertheless, == would probably work too.
{
  echo "Sorry, we only accept png and jpg images.";
}
else
{
  move_uploaded_file($temporaryLocation, $filename);
}
```
Eventually, it would be nice to see real evidence that this image actually has been uploaded (perhaps this should happen a bit sooner).  Write html, but leave the previous php in the very beginning -- or at least in the head.
```php
<img src="<?php echo $filename; ?>" />
```
####Optional functionality
Now that we have added html around the php, our message, *"Sorry, we only accept png and jpg images."* probably won't be very useful.  Instead, it might be nice to give the user another opportunity to choose a file.  So, we will go back to the file-choosing page and give the alert there.

First, make sure that the initial block of php in the second file is before the <html> and <!doctype> markings.  Then, replace the "Sorry, we..." line with this, to redirect to the previous page.
```php
header( 'Location: choose_file.php?q=type' );
```
(In this repository,"choose_file.php" is actually begin.php).  Now, looking at choose_file.php, we will add an area to alert the user if there are issues.
```php
<h3 style="color:red">
<?php
  if(isset($_GET['q'])
  {
    if($_GET['q'] == 'type')
    {
      echo "Sorry, we can only accept png and jpg files.  ";
      echo "Please find another file.";
    }
  }
?>
</h3>
```
####Section 2 (cont)
Continuing, it is now important to choose what tools to include to edit images.  Currently, the following are supported:

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; **brightness, saturation, exposure, gamma, clip, stackBlur, contrast, vibrance, hue, sepia, noise, sharpen**

Not all must be used if some seem useless.  Make note of the range limits:

```
brightness: -100 to 100
saturation: -100 to 100
exposure: -100 to 100
gamma: 0 to 10 (In reality, 1 to 10, basicCaman.js will deal 
       with that so that 0 can always be the base)
clip: 0 to 100
stackBlur: 0 to 20
contrast: -100 to 100
vibrance: -100 to 100
hue: 0 to 100
sepia: 0 to 100
noise: 0 to 100 (although 100 is excessive)
sharpen: 0 to 100
```

For each chosen tool, add a range and span (to label).

```html
Brightness (<span id="bright_label">0</span>)<br />
<input type="range" name="brightness" id="bright" min="-100" max="100" /> <br />
```

Also position the image in a reasonable spot.

Additionally, create boxes (&lt;input type="text"&gt; or &lt;textarea&gt;) to identify title, caption, and description.

Now, add javascript.  Begin by including necessary files: jQuery, Caman.js, and basicCaman.js
```html
<script type="text/javascript" src="caman/caman.full.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
<script type="text/javascript" src="basicCaman.js"></script>
```
Now, either within &lt;script&gt;&lt;/script&gt; or in an external file, start by making a Caman object, and initialize it with the id of the &lt;img&gt;:
```javascript
var camanObject = Caman("#imageID");
```
Next, in order to use basicCaman.js, we must create an array associating an editing tool to a range slider.  This array has two functions: to identify which tools are being used, and to specify which range is associated with which tool.  If we are only using brightness and contrast, imagine id="bright" and id="contr".  We would then write this array:
```javascript
var editingTools = {brightness: "bright", contrast:"contr"};
```
(This will make the following true)
```javascript
editingTools["brightness"] == "bright"
```

#### A Note About Naming ID's
Note that when labeling the value of the range (as in &lt;span id="bright_label"&gt;0&lt;/span&gt;), it must be in this form: [id of the associated range slider] + "_label".  This is seen here:
```html
Brightness (<span id="bright_label">0</span>)<br />
<input type="range" name="brightness" id="bright" min="-100" max="100" /> <br />
```
It is possible to label it differently.  However, the suffix must remain the same for all labels, and all labels must begin with the id corresponding to the slider.  This would be valid:
```html
Brightness (<span id="bright_number">0</span>)<br />
<input type="range" name="brightness" id="bright" min="-100" max="100" /> <br />
```
but not this:
```html
Brightness (<span id="number_bright">0</span>)<br />
<input type="range" name="brightness" id="bright" min="-100" max="100" /> <br />
```
However, if you use a different suffix, make sure to specify when using ceResetRanges() and ceUpdateCaman().

#### Section 2 (cont)
Continuing with javascript, we note that without intervention, ranges will assume the position last chosen by a user, not the value assigned in the html.  We use jquery to automatically reset the ranges once it loads.
```javascript
$( document ).ready(function(){
  ceResetRanges(editingTools); // this is from basicCaman.js
    // If suffix is NOT "_label", then you must also pass the suffix
    //   to the function: ceResetRanges(editingTools, "_alt_suffix");
});
```
**All other javascript from now on must be placed within the .ready(function(){ _here_ });** I have not gotten it to work otherwise

We are now beginning to make the camanjs actually functional.  We want the image to update every time a range is changed ( like [here](http://camanjs.com/examples/) ) so act whenever an <input> changes: (this is within $(document).ready)
```javascript
$("input").on("change", function(){
  // First, revert to the original image data
    // "false" prevents the object from immediately
    // rendering and updating in the browser, saving us time.
  camanObject.revert(false); 

  // This function is from basicCaman.js
    // If suffix is not _label, it must be
    // ceUpdateCaman(camanObject, editingTools, "_alt_suffix");
  ceUpdateCaman(camanObject, editingTools);

  // Update it in the browser.
  camanObject.render();
});
```

######I'm running out of time, so a summary of the rest:
+ Change the php so that it saves in the wordpress directory (incl. random string)
+ Add a button and javascript to handle exporting the data to base64
+ base64 encode.
+ Now, you have to create a php file to accept all of this data.
+ In this third file:
  - Save new image to file
  - Use basicCaman.php: make sure that paths are correct, esp. line 3 or 4 of basicCaman.php
  - Create thumbnails.
  - Insert into wordpress databases
  - Edit your gallery to include the new image.

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
