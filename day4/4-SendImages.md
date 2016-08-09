#Send Images to Database

**filters.php** must send the images to **acceptImages.php** so they can be put in the database.

We will do this with **javascript**

##Create "save" button

Return to your **filter.php** page. Copy the code for one of the filter buttons, but change it to say "save" instead.

For example:

```html
...
  <button class="btn btn-default" style="width:120px" id="vintage">Vintage</button>
  <button class="btn btn-default" style="width:120px" id="save">Save</button>

```

##Include basicCaman.js

In the head, add this JavaScript file:

```html
  <script type="text/javascript" src="basicCaman.js"></script>
```
Of course, now you will need to make sure this JavaScript file, **basicCaman.js**, is on your server as well. You can get it **[here]()** - just copy and paste it into a new code file and save it with the name **basicCaman.js**. Read the comments after the // to get an idea of the functions that this script provides to the application. 

##Add a Caption Field

Let's add a way to include a caption for your image. Also on the filters.php page, add an input like this somewhere on the page. You can enter this code above or below the buttons , or even above the image if you want:

```html
Caption: <input type="text" id="caption" /><br />
```

**Alternatively** you can also add a Title and Description, even Comments. If you're feeling ambitious, after making sure the Captions work, you can try **[this]()**

##Create JS for save function

```javascript
    $( "#save" ).on("click", function(){
      camanObject.render(function(){
        var imageData = camanObject.toBase64("<?php echo ce_caman_image_type($image_extension); ?>");
        var allData = {data: ceEscapeString(imageData), tmploc: ceEscapeString("<?php echo $target_file; ?>"), type: "<?php echo $image_extension; ?>", title: ceEscapeString($("#title").val()), caption: ceEscapeString($("#caption").val()), description: ceEscapeString($("#descrip").val())};
        ceAjaxSend("acceptImages.php", allData, "./gallery.php");
//"../index.php/photo-gallery/", imageData, "<?php echo $random_string; ?>", "<?php echo $image_extension; ?>", "<?php echo $wp_media_dir; ?>", $("#title").val(), $("#caption").val(),$("#descrip").val());
    });
```

##Set the correct gallery location

If your gallery is **not** called **gallery.php** , replace that name in the line that begins with "var allData..."
