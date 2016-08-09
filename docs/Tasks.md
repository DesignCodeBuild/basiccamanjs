#What We're Building

Let's say someone hired you to create a website where visitors could upload images, add filters to them, and share them to a gallery. You know how to build a simple web page with HTML, but how would you add more advanced functionality like image upload and manipulation? After a bit of online research you might discover that there was a promising jQuery repository called camanjs that when implemented on a web page, allowed visitors the ability to add photo filters and make image adjustments such as brightness, contrast, blur and sharpening, etc. However, it did not provide a method for uploading images and sharing them to a gallery or on social media. 

The point of this tutorial is to show how you can extend a web page by pulling in jQuery and custom library includes such as those from the Caman repository - and how to add a bit of PHP and database programming to turn the caman functionality into a rich, full-featured site. 


#Instagram tasks


- Create 4 pages:
	* Choose a file
		+ HTML Form to submit ([like this](http://www.w3schools.com/html/html_forms.asp))
		+ Upload button ([Check here](http://www.w3schools.com/php/php_file_upload.asp))
		+ Submit button
	* Add filters
		+ PHP File
		+ Accept image ([Check here again](http://www.w3schools.com/php/php_file_upload.asp))
		+ Save image to temporary image folder
		+ Resize image (640x640 is often good) if it is too large [ce_img_resize](https://github.com/DesignCodeBuild/basiccamanjs/blob/master/Docs.md#ce_image_resize)
		+ Include [JQuery](https://code.jquery.com/) and [CamanJS](https://github.com/meltingice/CamanJS/tree/36697e053d0b8f3b5cc58fba274b5cd65cb219c2/dist) (download caman.full.js for use)
		+ Check out filters you want from [this CamanJS Example](http://camanjs.com/examples/) (at the bottom)
		+ Code Snippet hint for implementing the JS [here](http://www.jsfiddle.net/6pusyskL/)
		+ Implement a new "().click()" for each button/filter
		+ Add a "remove filters" button
		+ Caption textarea/text input
		+ AJAX to send to *backend save* page to do the saving using [jquery ajax](http://www.w3schools.com/js/js_window_location.asp) and use *POST* not GET for the **method**
			* Escape problematic characters using ceEscapeString in base64 data using [this code](https://github.com/DesignCodeBuild/basiccamanjs/blob/master/escape.js)
		+ Redirect to Gallery [with javascript](http://www.w3schools.com/js/js_window_location.asp)
	* Backend Save - a less-obvious page to save & put in the database
		+ PHP file
		+ Collect POST data [php](http://php.net/manual/en/reserved.variables.post.php) and [form](http://www.w3schools.com/php/php_forms.asp) descriptions
		+ [un-escape image data](https://github.com/DesignCodeBuild/basiccamanjs/blob/master/Docs.md#ce_unescape_string)
		+ Save image data (also look at [ce\_base64\_to\_image](https://github.com/DesignCodeBuild/basiccamanjs/blob/master/Docs.md#ce_base64_to_image))
		+ Create thumbnail ([ce_img_resize](https://github.com/DesignCodeBuild/basiccamanjs/blob/master/Docs.md#ce_image_resize))
		+ Use [ce\_add\_to\_database](https://github.com/DesignCodeBuild/basiccamanjs/blob/master/Docs.md#ce_unescape_string)
	* Gallery
		+ Design a grid prototype (check out [CSS Floating](http://www.w3schools.com/css/css_float.asp))
		+ Grab your array data from the database using [ce\_get\_database\_list](https://github.com/DesignCodeBuild/basiccamanjs/blob/master/Docs.md#ce_get_database_list)
		+ **Like functions (requires a new PHP file**
			* AJAX again to send a like
			* From basicCaman.php, [ce_like_image](https://github.com/DesignCodeBuild/basiccamanjs/blob/master/Docs.md#ce_like_image)
