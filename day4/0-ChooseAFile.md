# Create the first page of the web app - where users upload a photo (Page 1, index.html file)

Create a new HTML file in your code editor, and name it **index.html**. Inside this file, start off with your standard HTML setup and type:

```html
<!DOCTYPE html>
<html>
<head>
  <title>My Title</title>
</head>
<body>
</body>
</html>
```
Next, add the following code inside the **body** container to create an **upload** button:

## Form

A **form** lets you enter information -- like your name... or choose a file to upload!

Inside the **body** type:

```html
  <form action="filters.php" method="post" enctype="multipart/form-data">
    <input type="file" name="fileToUpload" id="fileToUpload" /> <br />
    <input type="submit" value="Upload Image" name="submit" />
  </form>
```

See where it says **filters.php**? This helps the **form** you are creating to send the user's uploaded **image** to the **filters.php** page. 

See where it says **enctype="multipart/form-data"**? This is very important for a file upload script. It will help the image data be read correctly by the server so it displays properly on the next page. 

Check to see how it looks!  We next need to actually create the **filters.php** page, so we can **accept the file** onto it to display the image and **add filters** to this image. To do this, ([proceed to the next step](https://github.com/DesignCodeBuild/basiccamanjs/blob/master/day4/1-AcceptAFile.md))

## OPTIONAL - if you want it to upload automatically without clicking a second "Upload" button

If you want it to upload automatically without having to click "Upload", we'll have to add some javascript.

First include jquery from [code.jquery.com](http://code.jquery.com/).  This should go into the `head` section.

Then we need to have a script section right after including jquery, with `<script></script>` tags.  Then add this:

```javascript
$(document).ready(function() {
  $("#fileToUpload").on("change", function() {
    $(this).parent().submit();
  });
});
```

