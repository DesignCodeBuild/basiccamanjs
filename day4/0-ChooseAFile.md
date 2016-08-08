#Choose A File Page (Page 1, index.html file)

Create a new HTML file in your code editor, and name it **index.html**. Inside this file, start off with your standard HTML setup:

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

##Form

A **form** lets you enter information -- like your name... or choose a file to upload!

Inside the **body** type:

```html
  <form action="filters.php" method="post" enctype="multipart/form-data">
    <input type="file" name="image" />
    <input type="submit" value="Submit" />
  </form>
```

See where it says **filters.php**? This helps the **form** you are creating to send the user's uploaded **image** to the **filters.php** page. 

Check to see how it looks!  We next need to actually create the **filters.php** page, so we can **accept the file** onto it to display the image and **add filters** to this image. 
