#Functional Filters

We have buttons -- but they don't actually do anything!

Let's add *Javascript* code that will make the buttons work!

##Script tags

Javascript must go in &lt;script&gt; &lt;/script&gt; tags which go **in the head**:

```html
<head>
...
<script>

  // all my javascript code will go in here

</script>
</head>
```

##Include Caman JS

In fact, we can include a whole bunch of scripts and styles:

This goes **in the head**

```html
<link rel="stylesheet" href="http://mxcd.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
<script type="text/javascript" src="basicCaman.js"></script>
<script type="text/javascript" src="caman.full.js"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery-2.1.4.min.js"></script>


We also have to **download** some files: [caman.full.js](https://raw.githubusercontent.com/meltingice/CamanJS/23c4ecd6a76debac81621929e620468d286cb1b6/dist/caman.full.js) and [basicCaman.js](https://raw.githubusercontent.com/DesignCodeBuild/basiccamanjs/master/basicCaman.js)
```

Save them in your folder.

##Select the image

Now, enable the buttons using javascript and jQuery.  Use this at the beginning of the &lt;script&gt;:
```javascript
  var camanObject = Caman("#toEdit");
```

##Document.ready

This will allow code to run as soon as the page loads.

Create this:
```javascript
$( document ).ready(function() {
}
```
**Inside** this "document.ready" section, we can make the buttons respond when clicked on.  Add this code within $( document ).ready, which will make the "vintage" button work.
```javascript
  $(" #vintage ").on("click", function(){
    camanObject.revert(false);
    camanObject["vintage"]();
    camanObject.render();
  });
  // ...
```

Continue & copy this code for **each button** 

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

