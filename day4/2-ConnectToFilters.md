
#Connect the filters.php to the actual filters

We have filters.php which *only* has PHP.  It *doesn't* have filters - the filters are in **filterpage.html**

##First, create the temporary folder for the images to be uploaded to on your server

Using Cyberduck, make a folder called **tmp\_images**

##Next, copy over filterpage.html

Go to **filterpage.html** and copy everything. This includes the HTML, JavaScript, and CSS styles for the filter buttons.

Now, in the **filters.php** page, delete everything after **&lt;!DOCTYPE html&gt;**

Now paste everything from filterpage.html into filters.php

##Replace image URL

Find the code for the image.  The code should look like this:

```html
<img src="[your url]" id="toEdit" />
```

Now, replace [your url] with PHP code to output the filename:

```php
<img src="<?php echo $target_file; ?>" id="toEdit" />
```
