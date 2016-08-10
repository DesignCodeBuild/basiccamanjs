#Responsive Design: Adding Custom Styles for Desktop and Mobile Devices

##Media Queries

You may want to create a custom look for your web app to optimize its appearance depending on whether visitors are viewing your site from a desktop or mobile device. This is called **responsive design**, as in, the site styles respond to the screen width or device that it is viewed on. This magic is done in your style.css file. 

Right now, your style.css file should look something like this:

```


```

You can get an idea of how your page will appear on narrower devices by dragging the right edge of your browser window in towards the left. You will notice that content starts to get cut off. 

Fortunately, **media queries** are easy and pretty painless to set up. 

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

And then (~this is very important~) in your **gallery.php** page, and any other page that you would like to make responsive, add this line just inside &lt;head&gt;: 
```
<meta name="viewport" content="width=device-width, initial-scale=1">
```
If this line is not found in your document's &lt;head&gt; tags, responsive design / media queries will not work. 


