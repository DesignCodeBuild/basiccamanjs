# Functional Filters

We have buttons -- but they don't actually do anything!

Let's add *Javascript* code that will make the buttons work!

## Script tags

Javascript must go in &lt;script&gt; &lt;/script&gt; tags which go **in the head**:

```html
<head>
...
<script>

  // all my javascript code will go in here

</script>
</head>
```

## Include Caman JS

In fact, we can include a whole bunch of scripts and styles:

This goes **in the head**

```html
<link rel="stylesheet" href="http://mxcd.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
<script type="text/javascript" src="basicCaman.js"></script>
<script type="text/javascript" src="caman.full.js"></script>
<script type="text/javascript" src="http://code.jquery.com/jquery-2.1.4.min.js"></script>


We also have to **download** some files: [caman.full.js](https://raw.githubusercontent.com/meltingice/CamanJS/23c4ecd6a76debac81621929e620468d286cb1b6/dist/caman.full.js) and [basicCaman.js](https://raw.githubusercontent.com/DesignCodeBuild/basiccamanjs/master/basicCaman.js)
```

Save them in your folder.

## Select the image

Now, enable the buttons using javascript and jQuery.  Use this at the beginning of the &lt;script&gt;:
```javascript
  var camanObject = Caman("#toEdit");
```

## Document.ready

This will allow code to run as soon as the page loads.

Create this:
```javascript
$( document ).ready(function() {
}
```
**Inside** this "document.ready" section, we can make the buttons respond when clicked on.  Add this code within $( document ).ready, which will make the "vintage" button work.
```javascript
  $(" #vintage ").on("click", function(){
    camanObject.revert(false);
    camanObject["vintage"]();
    camanObject.render();
  });
  // ...
```

Continue & copy this code for **each button** 

The most important part of this code is the middle line, "*camanObject['vintage']();*".  This applies the actual filter, vintage, to the image. However, that code will change the image currently displayed.  What if the user had already applied a different filter?  Then it would effectively apply two filters.  Instead, we need to return back to how the image originally looked.

This line - "*camanObject.revert(false);*" - does that.  By specifying "false", we ask camanjs not to render immediately after reverting, because that would take extra time.

Finally, "*camanObject.render()*" makes changes to the image visible to the user.

##Revert Button

What if you try filters but **decide you want no filters at all?**

We need a *revert* button that will go back to original image.

```html
<button class="btn btn-default" id="back">Revert</button>
```

The back button is easy to make work.
```javascript
  $( "#back" ).on("click", function(){
    camanObject.revert(true);
  });
```
