# Filter Buttons

When you have nothing to do, you can practice javascript and jQuery on Codecademy over [here](https://www.codecademy.com/learn/jquery).

## Check out your filter options!

What is **Caman JS**?

Javascript is a programming language that has a lot of basic functions.  It can do calculations, display text on the screen, etc.  
If we want to add filters, we could write them ourselves -- but that would take *forever* because we'd have to define how each filter works.  
Instead, we use **caman.js** -  a lot of javascript code that someone else wrote that predefines what each filter looks like.

Check out the preexisting filters [here](http://camanjs.com/examples/).  Scroll to the bottom to see the filters

#### Write down the filters you want to use

## Make the buttons

Here's an example for the **Vintage** button:

```html
  <button class="btn btn-default" id="vintage">Vintage</button>
```

**Add all the other filters you want to have**

- The id CANNOT have spaces.
- The id should be the same as the name of the filter
  * If the name of the filter has a space (like *Orange Peel*), name it in camelCase (eg. *orangePeel*)
- The displayed name can be any name -- doesn't have to be the one on the example page

For example, if you want to use the Orange Peel filter but call it "Dust", the button would be like this:

```html
  <button class="btn btn-default" id="orangePeel">Dust</button>
```

