#(Day 2) Implementing CamanJS Filters and Sliders

##Table of Contents

<a href="#setup">Setup</a>


##<a name="setup"></a>Setup

Setup tasks:

1. Download & setup camanjs library
2. Create a simple HTML page with a sample image to edit
3. Include all the right js files in the HTML file.

Let's get started:

1. Download camanjs from [camanjs.com](http://camanjs.com)
	- Unzip it
	- Copy [camanfolder]/dist/caman.full.js to the base folder.

2. Create a html page

```html
<!DOCTYPE html>
<html>
<head>
<title>Initial Caman JS Tests</title>
</head>
<body>
</body>
</html>
```

- Find a simple image that we can use for testing
- Put it in the directory
- Include the image inside the body.
	* We will include an "id" which allows us to select this image with javascript.

```html
  <img src="[yourfilename]" id="toEdit" />
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

We will be editing the image we included above.

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
Within this "document.ready" section, we can make the buttons respond when clicked on.  Add this code within $( document ).ready, which will make the "vintage" button work.
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

