#Send Images to Database

**filters.php** must send the images to **acceptImages.php** so they can be put in the database.

We will do this with **javascript**

##Create "save" button

Copy another button and change it to say "save" instead.

For example:

```html
...
  <button class="btn btn-default" style="width:120px" id="vintage">Vintage</button>
  <button class="btn btn-default" style="width:120px" id="save">Save</button>

```

##Include basicCaman.js

In the head, this:

```html
  <script type="text/javascript" src="basicCaman.js"></script>
```

##Title, Caption, Description

Add inputs for title caption, description:

```html
Title: <input type="text" id="title" /><br />
Caption: <input type="text" id="caption" /><br />
Description: <input type="text" id="descrip" /><br />
```

**Alternatively** if you don't want this, ask one of us.

##Create JS for save function

```javascript
    $( "#save" ).on("click", function(){
      camanObject.render(function(){
        var imageData = camanObject.toBase64("<?php echo ce_caman_image_type($image_type); ?>");
        var allData = {data: ceEscapeString(imageData), tmploc: ceEscapeString("<?php echo $image_tmp_location; ?>"), type: "<?php echo $image_type; ?>", title: ceEscapeString($("#title").val()), caption: ceEscapeString($("#caption").val()), description: ceEscapeString($("#descrip").val())};
        ceAjaxSend("acceptImages.php", allData, "./gallery.php");
//"../index.php/photo-gallery/", imageData, "<?php echo $random_string; ?>", "<?php echo $image_extension; ?>", "<?php echo $wp_media_dir; ?>", $("#title").val(), $("#caption").val(),$("#descrip").val());
    });
```

##Set the correct gallery location

If your gallery is **not** called **gallery.php** , replace that name in the line that begins with "var allData..."
