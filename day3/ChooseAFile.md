#Choose A File Page

Start off with your standard HTML setup:

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

##Form

A **form** lets you enter information -- like your name... or choose a file to upload!

Inside the **body** type:

```html
  <form action="filters.php" method="post">
    <input type="file" name="image" />
    <input type="submit" value="Submit" />
  </form>
```

Check to see how it looks!  We next need to **accept the file** and **add filters**
