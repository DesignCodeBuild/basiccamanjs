#Add An Image

We want to add an image that is:

- fairly big
- *centered*

##Download Image

First let's find an image that we want to use as an example for our instagram filters

Find the image and **download it** to your computer.  Remember the name of the image file.

##HTML image code

You may remember this from the codecademy.  If you can, **write it yourself** without copying from this page.  Otherwise, look here to refresh your memory.

```html
<img src="MY FILENAME" />
```

Of course **replace** *MY FILENAME* with the actual name of your image file.

##Image ID

We will later need an image id so the computer can find the image.

Update your image code to have the id tag:

```html
<img src="MY FILENAME" id="toEdit" />
```

##Size & Centering

Now, right below the **&lt;/title&gt;** tag, add a **style** tag and **/style** tag:

```html
<style>


</style>
```

Now, **in between the tags**, we type **CSS code**

```html
<style>
#toEdit {
  width:600px;
  margin: 0 auto;
}
</style>
```

* The hashtag indicates that "toEdit" is an ID.
* Width defines how big the image is.  **experiment** to get other widths!
* *margin: 0 auto;* is code that **centers** the image.

This is the same as using *style="..."* but it allows for easy-to-read code

##Add Other Stylistic things:

Here's some ideas:

- Title (use &lt;h1&gt;)
- Background (*background-color:orange*)
- Color of the words`*color:brown*
- Bootstrap (download from [here](http://getbootstrap.com/getting-started/) and ask us)


##Final

```html
<!DOCTYPE html>
<html>
<head>
  <title>
    My Title
  </title>
  <style>
    #toEdit
    {
      width:600px;
      margin: 0 auto;
    }
  </style>
</head>
<body>
  <img src="MY FILENAME" id="toEdit" />
</body>
</html>
```
