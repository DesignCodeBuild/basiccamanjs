#basicCaman.php docs

##Table of Contents

* [ce\_add\_to\_database](#ce_add_to_database)
* [ce\_base64\_to\_image](#ce_base64_to_image)
* [ce\_caman\_image\_type](#ce_caman_image_type)
* [ce\_create\_mime\_type](#ce_create_mime_type)
* [ce\_escape\_string](#ce_escape_string)
* [ce\_find\_extension](#ce_find_extension)
* [ce\_get\_database\_list](#ce_get_database_list)
* [ce\_img\_resize](#ce_img_resize)
* [ce\_like\_image](#ce_like_image)
* [ce\_random\_string](#ce_random_string)
* [ce\_unescape\_string](#ce_unescape_string)


##<a name="ce_add_to_database"></a>function ce\_add\_to\_database($data, $databasename, $username, $password, $tablename)

Adds a new image entry to the database

* **data** - array - must contain index "filename" and index "caption"
* **databasename** - string - name of your database
* **username** - string - username for login to the database
* **password** - string - password associated with that user
* **tablename** - string - name of table in the database

**RETURNS:** boolean - true for success

**EXAMPLE:**

```php

$filedata = array();
$filedata['filename'] = "s3yg1638x.png";
$filedata['caption'] = "San Diego Sunset";

ce_add_to_database($filedata, "david_instagram", "david_user", "myPassword", "posts");

```

##<a name="ce_base64_to_image"></a>function ce\_base64\_to\_image($input)

Takes base64 image data sent from the caman javascript, splits it, and returns the binary data for the image

* **input** - string - base64 data

**RETURNS:** - blob - binary data

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

Uses htmlentities() to escape string.  Matched with escaping function in ceEscapeString, javascript function from [here](https://github.com/DesignCodeBuild/basiccamanjs/blob/master/escape.js)

Paired with [ce\_unescape\_string](#ce_unescape_string)

* **input** - string - any string to escape

**RETURNS:** string - escaped string

##<a name="ce_find_extension"></a>function ce\_find\_extension($imagetype)

This takes a **mime type** such as *image/png* and reduces it to a plain file extension, eg *png*

* **imagetype** - string - image mime type, eg 

**RETURNS:** string or boolean - *false* or the image extension.

##<a name="ce_get_database_list"></a>function ce\_get\_database\_list($databasename, $username, $password, $tablename)

Get array of ALL images that have been posted

* **databasename** - string - name of your database
* **username** - string - username for login to the database
* **password** - string - password associated with that user
* **tablename** - string - name of table in the database

**RETURNS:** array - of all data from the database.

**EXAMPLE:**

```php
$data = ce_get_database_list("david_instagram", "david_user", "myPassword", "posts");
foreach($data as $image)
{
  echo "<img src='./images/" . $image['filename'] . "' class='galleryimage' />";
  echo "<span class='caption'>" . $image['caption'] . "</span>";
  echo "<span class='likes'>" . $image['likes'] . "</span>";
}
```


##<a name="ce_img_resize"></a>function ce\_img\_resize($inputfilename, $outputfilename, $type, $width, $height, $crop = true)

This function uses **gd** php functions to resize an image.  

* **inputfilename** - string - input image file
* **outputfilename** - string - output image file
* **type** - string - image type: *jpg, png*, or *gif*
* **width** - int - new image width
* **height** - int - new image height
* **crop** - boolean - whether or not to crop the image when it is resized. Default: true.

**RETURNS:** boolean, true or false depending on success.

##<a name="ce_like_image"></a>function ce\_like\_image($filename, $databasename, $username, $password, $tablename)

Checks to see if someone has liked an image before; if not, then the image is liked.

* **filename** - string - name of the image file
* **databasename** - string - name of your database
* **username** - string - username for login to the database
* **password** - string - password associated with that user
* **tablename** - string - name of table in the database

**RETURNS:** boolean - true for success, false if already liked

**EXAMPLE:**

```php
$fileToLike = "3segceyi3.jpg";
$result = ce_like_image($fileToLike, "david_instagram", "david_user", "myPassword", "posts");

if($result == true)
{
	echo "y";
	// this will be detected by ajax
	// gallery will respond by increasing # of likes by 1.
}
else
{
	echo "n";
	// detected by ajax
}

```

##<a name="ce_random_string"></a>function ce\_random\_string()

Returns a random string (often used for filenames)

*no arguments*

**RETURNS:** string - a string of random characters

##<a name="ce_unescape_string"></a>function ce\_unescape\_string($input)

Unescape string that was encoded with [ce\_escape\_string](#ce_escape_string) or [escape.js code](https://github.com/DesignCodeBuild/basiccamanjs/blob/master/escape.js)

* **input** - string - any input string that has been escaped using one of the mentioned functions

**RETURNS:** string - unescaped string.

