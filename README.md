#Simplified [Caman.js](https://github.com/meltingice/CamanJS) & Wordpress

## Important notes
+ Require a title
+ Check for image type on the first (begin.php) page
+ Remember to add capital/lowercase support for extensions
+ Use the NEWEST release of CamanJS: the one from github.  Because 4.1.1 and the CDN version have an issue in Caman.revert(true)
+ Must transfer image from CamanJS to php through AJAX, and must reconfigure base64 because it contains '/', ';', ':', '+', '/'.  Currently, it converts to html character codes.
+ It is difficult to deal with thumbnails because there is a specific size (in this case, 604, 270) that is determined by the theme, where the url will vary.
+ We basically only need to use basicCaman.js and basicCaman.php.

##Using it / ideas for using it
We can split the process into four sections:
+ **Pre**: Setup wordpress and create a page with the photo gallery.
+ **Section 1**: Choose a file to upload (e.g. begin.php)
+ **Section 2**: Edit the image with CamanJS preset filters (e.g. second.php)
+ **Section 3**: Fine-tune with CamanJS ranges (eg. third.php)
+ **Section 4**: Send the image to (e.g. acceptImages.php)

####Pre: Wordpress & others
Create a wordpress page (or post).  Inside it, insert a gallery.  The gallery can be located anywhere in the page, but **there can only be one gallery per page**.  Find the page ID by going to edit the page and clicking **Get Shortlink**.  This will be useful later.

Later sections do not identify what javascript libraries to include.  The following may are good to have in the head, although they might not all be needed.
```html
<script type="text/javascript" src="caman/caman.full.min.js"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
<script type="text/javascript" src="basicCaman.js"></script>
```

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
  $("#image").on("change", function(){
    $("#imageForm").submit();
  });
});
```
Also useful: check to make sure it is actually an image.  Create a span to hold potential issues:
```html
<span style="color:red;font-weight:900;" id="alarm"></span>
```
And then alter the javascript function:
```javascript
function uploadImage()
{
  // Gets the image name
  var str=document.getElementById('image').value;
  // eg. "image.png" splits into an array "image", "png"
  var strParts = str.split(".");
  // Choose the last part (strParts.length-1), and make it lowercase
  var strExt = strParts[strParts.length-1].toLowerCase();
  // If it is a valid image type
  if(strExt == "jpg" || strExt == "png" || strExt == "jpeg")
  {
    // Submit the form
    document.getElementById("imageForm").submit();
  }
  // If it is NOT a valid image type
  else
  {
    // Give an error.
    document.getElementById("alarm").innerHTML = "Only supports JPG and PNG files.";
  }
}
```

####Section 2: Save the file
Create a file at the location specified in the "action" of the form; in the previous example, it's "second.php"
Recieve the image data like this:
```php
$imageData = $_FILES["image"];
```
Note that $imageData is an array containing information related to the file.  It contains: __name__ (original file name), __type__ (file type, eg. image/jpeg), __tmp&#95;name__ (the temporary location at which file data is stored), and more.
Note that it _does not_ contain the actual file data; the file data is stored in the temporary file.

For initial purposes, we probably want to save this file somewhere on the server to use it.  When doing this, we __move__ the temporary file to a permanent location.
```php
$imageData = $_FILES["image"];
$file_dir = "tmp_images/";
$filename = $file_dir . $imageData["name"];
$temporaryLocation = $imageData["tmp_name"];
move_uploaded_file($temporaryLocation, $filename);
```
We need to know what kind of image this is: png or jpg.
```php
$imageType = $imageData["type"];
```
Type the following to include a few functions to simplify tedious tasks:
```php
require_once("/path/to/basicCaman.php");
```
######Setting Up basicCaman.php
Go to the beginning of basicCaman.php.  It requires config.php.  Make sure the path to config.php (part of wordpress) is correct.

####Section 2 (cont)

Next, use *ce_find_extension()*: This function turns the mime type given by _$imageData['type']_ to an extension like jpg or png. It will return *(false)* if given an invalid mime type; otherwise, it will return the string "png" or "jpg".

Although we already checked image extension, we can have one additional check in case the mime type doesn't match with the extension:
```php
$image_extension = ce_find_extension($imageType);
if($image_extension === false)
{
  echo "Sorry, we only accept png and jpg images.";
}
else
{
  move_uploaded_file($temporaryLocation, $filename);
}
```
Now that we have basicCaman.php working, we can also rename the file to a random string of characters to avoid naming conflicts, using the function *ce_random_string()* from basicCaman.php
```php
$filename = $file_dir . ce_random_string() . "." . $image_extention;
```
Eventually, it would be nice to see real evidence that this image actually has been uploaded (perhaps this should happen a bit sooner).  Write html, but leave the previous php in the very beginning -- or at least in the head.
```php
<img src="<?php echo $filename; ?>" id="toEdit" />
```
######A Note on Temporary Locations
In the end, we will put the files in the wordpress media directory.  However, we have two intermediate steps:
1. The first temporary location, usually at /tmp/_someFileName_, which is created immediately after the form submission and __never referred to in any context after this.__
2. The second temporary location, in ./tmp&#95;images/_someFileName_, which will used often from now on.  The purpose of this temporary location is a working space to work on the image until it is ready to be put in the wordpress media directory.

######Optional functionality
*Note: this is less relevant now that the first page checks extension using javascript*

Now that we have added html around the php, our message, *"Sorry, we only accept png and jpg images."* probably won't be very useful.  Instead, it might be nice to give the user another opportunity to choose a file.  So, we will go back to the file-choosing page and give the alert there.

First, make sure that the initial block of php in the second file is before the <html> and <!doctype> markings.  Then, replace the "Sorry, we..." line with this, to redirect to the previous page.
```php
header( 'Location: choose_file.php?q=type' );
```
(In this repository,"choose&#95;file.php" is actually begin.php).  Now, looking at choose&#95;file.php, we will add an area to alert the user if there are issues.
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
We should now allow the user to add preset filters to their image.  This will primarily require html and javascript.

Start by creating buttons for the filters you want.  Check out the [Camanjs example page](http://camanjs.com/examples/) and look at the bottom example.  Choose from those filters.  Add the buttons to a table or divs that can be positioned how you want them.  For example,
```html
<table style="width:640px;position:block;margin-left:auto;margin-right:auto;">
  <tr>
  <td style="width:128px">
  <button class="btn btn-default" style="width:120px" id="vintage">Vintage</button>
  </td>
  <td style="width:128px">
  <button class="btn btn-default" style="width:120px" id="lomo">Lomo</button>
  </td>
  <td style="width:128px">
  <button class="btn btn-default" style="width:120px" id="sinCity">Sin City</button>
  </td>
<!--... etc.-->
```
The id's can be anything you want, but it simplifies the process to use camelCase.  These buttons also make use of bootstrap.css, which is why they have their class set to "btn btn-default"

We also need an image to edit.  As mentioned above, we will use php to identify the location of the image.  This image should be placed wherever it is easily visible when using the sliders.
```php
<img src="<?php echo $filename; ?>" id="toEdit" />
```
Now, enable the buttons using javascript and jQuery.  Use this at the beginning of the &lt;script&gt;:
```javascript
  var camanObject = Caman("#toEdit");
```
Where #toEdit is the id of the image.  

Now, create this:
```javascript
$( document ).ready(function() {
}
```
Within this, we can make the buttons respond when clicked on.  Add this code within $( document ).ready, which will make the "vintage" button work.
```javascript
  $(" #vintage ").on("click", function(){
    camanObject.revert(false);
    camanObject["vintage"]();
    camanObject.render();
  });
  // ...
```
The most important part of this code is the middle line, "*camanObject['vintage']();*".  This applies the actual filter, vintage, to the image. However, that code will change the image currently displayed.  What if the user had already applied a different filter?  Then it would effectively apply two filters.  Instead, we need to return back to how the image originally looked.

This line - "*camanObject.revert(false);*" - does that.  By specifying "false", we ask camanjs not to render immediately after reverting, because that would take extra time.

Finally, "*camanObject.render()*" makes changes to the image visible to the user.

Note that if the filter is two words -- like "Cross Product" -- we must use camelCase.  Instead of writing *camanObject["cross product"]*, camanJS will instead react to *camanObject["crossProduct"]*.

__There are two more functions we need__: __revert__ and __submit__.
Add both of these buttons:
```html
<button id="submit">Continue</button>
<button id="back">Revert</button>
```
The back button is easy to make work.
```javascript
  $( "#back" ).on("click", function(){
    camanObject.revert(true);
  });
```
However, the submit button will be a bit more difficult.  Remember, we need to go to the next page to further edit the image.  We will therefore need to send some data about the image.  Specifically, __where the image is stored__, __the type of image__, and __the actual image data__.  We have multiple options:
1. Send an AJAX request
2. Save the image, and then proceed while giving the next page the file name
3. Send all required data through a post form request.
We cannot send an AJAX request because it will not redirect to the new page.  CamanJS also does not allow for saving the image (to my knowledge), so this leaves us with __option 3__.  This is most easily achieved by creating a form.
```php
<form action="third.php" method="post" id="dataForm">
  <input type="hidden" name="tmp_location" id="tmpImageLocation" value="<?php echo ce_escape_string($filename); ?>" />
  <input type="hidden" name="data" id="imageData" value="" /> <!--Will be filled in with javascript-->
  <input type="hidden" name="type" id="imageType" value="<?php echo $image_extension; ?>" />
</form>
```
When this form is submitted, it will send this info to the next page (third.php)
Look at *ce_escape_string($filename)*.  This is a function defined in basicCaman.php.  Feel free to look there; this function just escapes all potentially dangerous characters, like slashes.  These characters can interrupt data transmission through a post request.

Now, we must fill in the imageData input. Since we hope to send an updated image that was just processed by Camanjs, we should work on a javascript function.
```javascript
  $( "#submit" ).on("click", function(){
    var imageData = camanObject.toBase64();
    imageData = ceEscapeString(imageData); // escape this string, too.
    $( "#imageData" ).val(imageData);
    $( "#dataForm" ).submit();
  });
```

CamanJS provides us with a function to export the image data to a base64 encoding.  Now, escape the string to avoid bad characters.  We then input that data into the form (so that it will be sent) and then submit the form. 
However, we missed one important step.  The *toBase64()* function must know an image type.  Unfortunately, it recognizes "jpeg" instead of "jpg" so we can use a php function from basicCaman.php to correct this:
```php
var imageData = camanObject.toBase64("<?php echo ce_caman_image_type($image_extension); ?>");
```
__One more thing:__
You may have noticed that the images are often too big or too small.  We cannot deal with images that are too small, but it is good to limit the image size.  Large images take a long time to load and appear too large.  Immediately afer saving the file to *$filename*, we can use another function from basicCaman.php:
```php
ce_smaller_image($filename);
```
This will use wordpress functions to reduce the image size to __640x640 px__.  You can go to basicCaman.php and find the function to change this default size.

Now, we continue to __Section 3__.

####Section 3
We are now in a new php page (eg. third.php).  Include the basicCaman.php file.
```php
require_once("basicCaman.php");
```
Now, we have three "post" variables to intercept:
```php
//Base64-encoded image
$image_data = ce_unescape_string($_POST['data']);
//png or jpg
$image_type = $_POST['type'];
//Old location: so we can delete it when completed.
$image_tmp_location = ce_unescape_string($_POST['tmp_location']);
```
This introduces a new php function from basicCaman.php: *ce&#95;unescape&#95;string()*.  This function undoes the string-escaping done by *ce&#95;escape&#95;string()* and is required in order to be able to understand image data.
We now want to save the image data.
```php
if($image_data != "")
{
  //Write to "tmp location" (w) as binary (b)
  $filestream = fopen($image_tmp_location, "wb");
  $image_binary = ce_base64_to_image($image_data);
  fwrite($filestream, $image_binary);
  fclose($filestream);
}
```
*ce&#95;base64&#95;to&#95;image()* will convert base64 image data -- create by CamanJS -- to the 1's and 0's that make up a real image.  Make sure to specify the "wb" in "fopen()" because the "b" specifies that this is binary data.

Continuing, it is now important to choose what tools to include to further edit images.  Currently, the following are supported:

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; **brightness, saturation, exposure, gamma, clip, stackBlur, contrast, vibrance, hue, sepia, noise, sharpen**

Not all must be used if some seem useless.  Make note of the range limits:

```
brightness: -100 to 100
saturation: -100 to 100+
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
Also position the image in a reasonable spot, using something similar to the last section:
```php
<img src="<?php echo $tmp_image_location; ?>" id="toEdit" />
```

For each chosen tool, add a range and span (to label).

```html
Brightness (<span id="bright_label">0</span>)<br />
<input type="range" name="brightness" id="bright" min="-100" max="100" /> <br />
```

Additionally, create boxes (&lt;input type="text"&gt; or &lt;textarea&gt;) to identify title, caption, and description.

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

#### Section 3 (cont)
Continuing with javascript, we note that without intervention, ranges will assume the position last chosen by a user, not the value assigned in the html.  We use jquery to automatically reset the ranges once it loads.
```javascript
$( document ).ready(function(){
  ceResetRanges(editingTools); // this is from basicCaman.js
    // If suffix is NOT "_label", then you must also pass the suffix
    //   to the function: ceResetRanges(editingTools, "_alt_suffix");
});
```
**All other javascript from now on must be placed within the .ready(function(){ _here_ });** I have not gotten it to work otherwise

We are now beginning to make the camanjs actually functional.  We want the image to update every time a range is changed ( like [here](http://camanjs.com/examples/) ) so act whenever an &lt;input&gt; changes: (this is within $(document).ready)
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
At this point, range sliders should work to edit the image.

We'll also want to include title, caption, and description areas so that wordpress can have meaningful tags along with the images.  Simply use normal input tags:
```html
<input type="text" id="title" />
<input type="text" id="caption" />
<input type="text" id="descrip" />
```

Like before, we need to add buttons to save, and a button to revert to the previous state of the images.  The revert button should be easy; it will be the same as before.  The save button will also be similar.  This time, however, we don't want to redirect to the page that submits images; instead, we want to redirect back to the photo gallery.  We'll use AJAX to send a form without going to a new page.

```javascript
$("#submit").on("click", function(){
  var imageData = camanObject.toBase64();
  imageData = ceEscapeString(imageData); // escape this string, too.
  // Make an array to submit with AJAX.
          var allData = {data: ceEscapeString(imageData), tmploc: ceEscapeString("<?php echo $image_tmp_location; ?>"), type: "<?php echo $image_type; ?>", title: ceEscapeString($("#title").val()), caption: ceEscapeString($("#caption").val()), description: ceEscapeString($("#descrip").val())};
  var dataArray = {data: ceEscapeString(imageData),
    tmploc: ceEscapeString("<?php echo $image_tmp_location; ?>"),
    type: "<?php echo $image_type; ?>", 
    title: ceEscapeString($("#title").val()),
    caption: ceEscapeString($("caption").val()),
    description: ceEscapeString($("descrip").val())};
  // This simplifies the ajax process.
  //      age to accept request, data,      where to redirect to later on.
  ceAjaxSend("acceptImages.php", dataArray, "photo_gallery_location");
});
```

Now, we're done editing the image.  We only need to create _acceptImages.php_, which will actually add these photos onto our wordpress pages.
######Remember to prevent submission if there's no title.
####Section 4
_acceptImages.php_ will be written completely in PHP.  The user will never actually see this page, so we don't have to write any HTML, CSS, or Javascript to enclose the page.  It will all be enclosed in php tags.

First: We don't want this file to make changes if there is no image data.  Otherwise, we might create null entries in the wordpress database.
```php
if(isset($_POST['data']))
{
  // All our code will go here.
}
```

Then, let's intercept the POST information that was sent to us from the browser AJAX.  Remember the array we used to send this informmation:
```javascript
  var dataArray = {data: ceEscapeString(imageData),
    tmploc: ceEscapeString("<?php echo $image_tmp_location; ?>"),
    type: "<?php echo $image_type; ?>", 
    title: ceEscapeString($("#title").val()),
    caption: ceEscapeString($("caption").val()),
    description: ceEscapeString($("descrip").val())};
```
Therefore, we're looking for these:
```php
$image_data = $_POST['data'];
$old_location = $_POST['tmploc'];
$image_type = $_POST['type'];
$image_title = $_POST['title'];
$image_caption = $_POST['caption'];
$image_description = $_POST['description'];
```
We escaped some of these strings previously, so let's use _ce&#95;unescape&#95;string_ to undo this.
```php
$image_data = ce_unescape_string($_POST['data']);
$old_location = ce_unescape_string($_POST['tmploc']);
$image_type = $_POST['type'];
$image_title = ce_unescape_string($_POST['title']);
$image_caption = ce_unescape_string($_POST['caption']);
$image_description = ce_unescape_string($_POST['description']);
```

The only reason we needed the old location is so we can delete the old image.  We have all our new data in $image&#95;data, so we can now delete the old file.

We use the _unlink()_ function for this:
```php
unlink($old_location);
```
Now, let's write down all the image data to a file.  How should we name it?  We don't know what the image was originally called, but we can use a random string to decrease the likelihood of finding repeats.
```php
require_once("basicCaman.php");
// ...
$filename = ce_random_string() . "." $image_type;
```
If we want this to work with wordpress, however, we want it to go to the correct image directory.  We need to include another file, which comes from wordpress.
```php
require_once("../wp-config.php"); // Remember to point to the base wordpress installation directory
```
This allows us to use 
```php
ABSPATH
 ```
which provides the absolute path to the wordpress home directory.  Now, use a function from basicCaman.php
```php
ce_get_media_directory($a_string_pointing_to_wordpress_home /* "../" */);
```
It will return a string pointing to the directory, and create directories if needed.  A completed file name:
```php
$file_path = ABSPATH . ce_get_media_directory("../") . $filename;
```
Now, write to file:
```php
    $filestream = fopen($file_path, "wb");
    fwrite($filestream, ce_base64_to_image($image_data));
    fclose($filestream);
```
We use _ce&#95;base64&#95;to&#95;image()_ because previously, Camanjs encoded the image in base64 characters.

We now need to create thumbnails.  To avoid having to find the correct sizes, we can use another function from _basicCaman.php_.
```php
    ce_create_thumbnails($file_path);
```
Although we created thumbnails, wordpress still doesn't know about the existence of these images.
```php
    $image_id = ce_add_to_database($file_path, $image_mime_type, $image_title, $image_caption, $image_description);
```
Remember to store the image id.  This allows us to enter it into our gallery.

Finally, make sure we have the wordpress gallery on a page. Find the page id.  Then, use this final function:
```php
    $ce_photo_gallery_ID = 4; \\ Or whatever the page's id is
    // image_id is from the previous function
    ce_add_to_photo_gallery($ce_photo_gallery_ID, $image_id);
```

That should be it!

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
