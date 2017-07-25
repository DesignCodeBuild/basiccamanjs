# Send Images to Database

**filters.php** must send the images to **acceptImages.php** so they can be put in the database.

We will do this with **javascript**

## Create "save" button

Return to your **filter.php** page. Copy the code for one of the filter buttons, but change it to say "save" instead.

For example:

```html
...
  <button class="btn btn-default" style="width:120px" id="vintage">Vintage</button>
  <button class="btn btn-default" style="width:120px" id="save">Save</button>

```

## Include basicCaman.js

In the **&lt;head&gt;** tag of **filters.php**, include this JavaScript file by adding this line of code:

```html
  <script type="text/javascript" src="basicCaman.js"></script>
```
Of course, now you will need to make sure this JavaScript file, **basicCaman.js**, exists on your server as well. You can get it **[here]()** - just copy and paste it into a new code file and save it with the name **basicCaman.js** - then, upload it via FTP (i.e. CyberDuck) to your server. Read the comments after the // to get an idea of the functions that this script provides to the application. 

## Add a Caption Field

Let's add a way to include a caption for your image. Also on the filters.php page, add an input like this somewhere on the page. You can enter this code above or below the buttons , or even above the image if you want:

```html
Caption: <input type="text" id="caption" /><br />
```

**Alternatively** you can also add a Title and Description, even Comments. If you're feeling ambitious, after making sure the Captions work, you can try **[this]()**

## Create JS for the SAVE function

Your SAVE button won't work until you add the JavaScript to render the image with the filter, check the file validity, and send it to the database (ceAjaxSend(**"acceptImages.php**)) and the gallery page (**"./gallery.php"**).

```javascript
    $( "#save" ).on("click", function(){
      camanObject.render(function(){
        var imageData = camanObject.toBase64("<?php echo ce_caman_image_type($image_extension); ?>");
        var allData = {data: ceEscapeString(imageData), tmploc: ceEscapeString("<?php echo $target_file; ?>"), type: "<?php echo $image_extension; ?>", caption: ceEscapeString($("#caption").val())};
        ceAjaxSend("acceptImages.php", allData, "./gallery.php");
    });
```
This code should go below the JS code for the last button, and before the closing **});** tag before **&lt;/script&gt;**

## Create your Gallery Page

This won't work until you have a **Gallery** page for the script to send the image to. Note that your **filters.php** JavaScript for the SAVE button refers to a file called **gallery.php**. **[Let's make this now](https://github.com/DesignCodeBuild/basiccamanjs/blob/master/day4/5-Gallery.md)**. You can actually name the file anything you want - but you will just have to make sure this name matches what you call it here on your **filters.php** file JavaScript, on the line that begins with "var allData..."
