
# Connect the filters.php to the actual filters

We have filters.php which *only* has PHP.  It *doesn't* have filters - the filters are in **filterpage.html**

## Next, copy over filterpage.html

Go to **filterpage.html** and copy everything. This includes the HTML, JavaScript, and CSS styles for the filter buttons.

Now, in the **filters.php** page, delete everything after **&lt;!DOCTYPE html&gt;**

Now paste everything from filterpage.html into filters.php

## Replace image URL

Find the code for the image.  The code should look like this:

```html
<img src="[your url]" id="toEdit" />
```

Now, replace [your url] with PHP code to output the filename:

```php
<img src="<?php echo $target_file; ?>" id="toEdit" />
```

Upload and test... you will see buttons and your image, but the buttons won't work. The page is missing something! 

Look in the HEAD tag... you will see the line

```
 <script src="caman.full.js"></script>
 ```
Which means it needs to have the file **caman.full.js** uploaded to the directory also. Find this in the caman folder in this github repository, save it and upload it, and run again. The filters should work. If they don't, doublecheck that you have called caman.full.js properly, i.e. your link matches the name / filepath on the server. 

Remember, **caman** is the open-source repository we are using for the image editing features. Read more about Caman **([here](http://camanjs.com))**.

If your filters work, you can have a bit of fun renaming the filters (only the name that is between the <button></button> brackets. Don't change the IDs, for now. 

Or, ([continue to the next step](https://github.com/DesignCodeBuild/basiccamanjs/blob/master/day4/3-AcceptImages.md)) where we add the code for a button to send the image to the database and save the effect onto the image. 
