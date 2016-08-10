#Responsive Design: Adding Custom Styles for Desktop and Mobile Devices

##Media Queries

You may want to create a custom look for your web app to optimize its appearance depending on whether visitors are viewing your site from a desktop or mobile device. This is called **responsive design**, as in, the site styles respond to the screen width or device that it is viewed on. This magic is done in your style.css file. 

Right now, your style.css file should look something like this:

```
#contain {
  width:800px;
  display:block;
  margin: 0 auto;
}
img {
  width:250px;
  margin: 5px;
  float:left;
}
h1 {
  text-align:center;
  font-family:'Arial', sans-serif;
  color:#333333;
  font-size: 3em;
}

```

To quickly test how your page looks on phones or other narrower devices as you are coding, try dragging the right edge of your browser window in towards the left as far as it will go. You will notice that your content will start to get cut off. 

Fortunately, we can solve this with **media queries** which are easy and pretty painless to set up. 

##Setting up your Media Queries

Underneath the styles that are already in your style.css, add these lines:

```
/* tablet Portrait */
@media screen and (max-width: 800px) {

}

/* smartPhone Portrait */
@media screen and (max-width: 414px) {

}
```
This sets up a group of styles each for tablets and for phones. Just leave the space between the {  } blank for now. 

And then (~~this is very important~~) in your **gallery.php** page, and any other page that you would like to make responsive, add this line just inside &lt;head&gt;: 
```
<meta name="viewport" content="width=device-width, initial-scale=1">
```
If this line is not found in your document's &lt;head&gt; tags, responsive design / media queries will not work. 

##Adding Custom Styles for Different Screen Widths 

To most clearly illustrate how this works, copy and paste the styles above the media query lines into each set of brackets { }, so you have this: 

```
#contain {
  width:800px;
  display:block;
  margin: 0 auto;
}
img {
  width:250px;
  margin: 5px;
  float:left;
}
h1 {
  text-align:center;
  font-family:'Arial', sans-serif;
  color:#333333;
  font-size: 3em;
}


/* tablet Portrait */
@media screen and (max-width: 800px) {

#contain {
  width:800px;
  display:block;
  margin: 0 auto;
}
img {
  width:250px;
  margin: 5px;
  float:left;
}
h1 {
  text-align:center;
  font-family:'Arial', sans-serif;
  color:#333333;
  font-size: 3em;
}

}

/* smartPhone Portrait */
@media screen and (max-width: 414px) {
	
#contain {
  width:800px;
  display:block;
  margin: 0 auto;
}
img {
  width:250px;
  margin: 5px;
  float:left;
}
h1 {
  text-align:center;
  font-family:'Arial', sans-serif;
  color:#333333;
  font-size: 3em;
}
	
}

```

If you were to save and upload style.css now, and test, your page would look the same as before. That's because all the styles inside the tablet and phone groups are identical. 

##Customizing styles for different screen widths

Now, try changing the tablet values like this:

```
/* tablet Portrait */
@media screen and (max-width: 800px) {

#contain {
  width:100%;
  display:block;
  margin: 0 auto;
}
img {
  display: block;
  width:30%;
  margin: 1%;
  float:left;
}

```

and the phone style values like this:

```
#contain {
  width:100%;
  display:block;
  margin: 0 auto;
}
img {
  display: block;
  width:100%;
  margin: 2px;
  float:left;
}

```

Save and upload the file, then refresh your page and play with the width of the browser by dragging in the right edge. You should see the photos scale, and stack differently at the two widths specified, i.e. at 800px wide, and at 414px wide. 


