#basicCaman.php docs

##Table of Contents
* <a href="#ce_image_resize">ce\_image\_resize</a>

##<a name="ce_caman_image_type"></a>function ce\_caman\_image\_type($extension)

Returns the *file extension* given a *file extension OR mime type*

It is essentially a combination of [ce\_create\_mime\_type](#ce_create_mime_type) and [ce\_find\_extension](#ce_find_extension)

* **extension** - string - file extension name OR file mime type

**RETURNS:** string - file extension

##<a name="ce_create_mime_type"></a>function ce\_create\_mime\_type($extension)

Returns the mime type for given file extension

For example: takes *png* and returns *image/png*

* **extension** - string - file extension name

**RETURNS:** string or boolean - mime type or "false"

##<a name="ce_escape_string"></a>function ce\_escape\_string($input)

Uses htmlentities() to escape string.  Matched with escaping function in ceEscapeString, javascript function

##<a name="ce_find_extension"></a>function ce\_find\_extension($imagetype)

This takes a **mime type** such as *image/png* and reduces it to a plain file extension, eg *png*

* **imagetype** - string - image mime type, eg 

**RETURNS:** string or boolean - *false* or the image extension.

##<a name="ce_image_resize"></a>function ce\_image\_resize($inputfilename, $outputfilename, $type, $width, $height, $crop = true)

This function uses **gd** php functions to resize an image.  

* **inputfilename** - string - input image file
* **outputfilename** - string - output image file
* **type** - string - image type: *jpg, png*, or *gif*
* **width** - int - new image width
* **height** - int - new image height
* **crop** - boolean - whether or not to crop the image when it is resized. Default: true.

**RETURNS:** boolean, true or false depending on success.

##<a name="ce_random_string"></a>function ce\_random\_string()

Returns a random string (often used for filenames)

*no arguments*

**RETURNS:** string - a string of random characters
