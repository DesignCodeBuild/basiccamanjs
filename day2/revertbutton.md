#Revert Button

What if you are testing filters but halfway through, you decide that you want no filters at all?

We need a **remove filters** button.  You can name it whatever you want.  Put this button at the end of all the other buttons (or wherever you want, actually, in the *body*.

```html
  <button class="btn btn-danger" id="remove">Remove Filters</button>
```

Now, paste this in the javascript code.

```javascript

    $(" #remove ").on("click", function(){
      camanObject.revert(true);
    });

```

It makes sense: we *revert* the changes
