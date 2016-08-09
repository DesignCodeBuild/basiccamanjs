# Array

Let's get some practice to get used to PHP. In this example, we will create code that lists the days of the week.

Start of with a simple **variable**.

Remember in javascript we always start by declaring our variable like this: *var variable*?  PHP is different:

**All variables start with $** 

This code should create a variable, and display the contents.  Type the code into a PHP code section.

```php
  $name = "John";  
  echo $name;  
```

**Task**: change the name to your name.

**Next, an array**

An array is a single variable that contains lots of data.  For example, the list of days in a week.  

Here's our goal: make an array called "days" that contains a list of all the days in a week.

There's actually multiple ways to do this: 

**Method 1:**

```php
  $days = array(); // Let the computer know this is going to be an array, not a normal variable
  $days[0] = "Sunday"; // arrays always start at 0
  $days[1] = "Monday";
  $days[2] = "Tuesday";
  $days[3] = "Wednesday";
  $days[4] = "Thursday";
  $days[5] = "Friday";
  $days[6] = "Saturday";
```

**Method 2:** a bit of a shortcut with [].

```php
  $days = array(); // Let the computer know this is going to be an array, not a normal variable
  $days[] = "Sunday"; // the [] means "add to the next available spot"
  $days[] = "Monday";
  $days[] = "Tuesday";
  $days[] = "Wednesday";
  $days[] = "Thursday";
  $days[] = "Friday";
  $days[] = "Saturday";
```

**Method 3:** Shortcut

```php
  $days = array("Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday");
```

All of these do the same thing.  

**Next:** Display these days.

Again, there's multiple ways.  Type this **after** you define the array.

**Method 1:** Calling explicit elements of the array

The period actually means **add** -- it adds two words or characters together.

```php
  echo $days[0] . "<br />"; // Sunday  
  echo $days[1] . "<br />"; // Monday   
  echo $days[2] . "<br />"; // Tuesday   
  echo $days[3] . "<br />"; // Wednesday   
  echo $days[4] . "<br />"; // Thursday   
  echo $days[5] . "<br />"; // Friday   
  echo $days[6] . "<br />"; // Saturday   
```

**Method 2:** For loop

A for loop lets you repeat an action over and over again for a set number of times.  Let's start by looking at a simple for loop:

  for($i=0;$i<5;++$i)
  {
    echo $i . "<br />";
  }

That first line is confusing.  It has 3 parts:

1. *$i=0*: start at $i = 0
2. *$i<5*: Keep repeating this loop as long as $i < 5. If $i is ever NOT < 5, then exit.
3. *++$i*: After you get through the loop once, increase $i by 1.

Here's what's happening in the computer:

> $i = 0.  
> echo 0.  
> $i = 1.  
>   
> [back to beginning of the loop]  
> is $i &lt; 5? 1&lt;5, so yes -- let's do the loop!  
> echo 1.  
> $i = 2;  
>   
> [back to beginning of the loop]  
> is $i &lt; 5? 2&lt;5, so yes -- let's do the loop!  
> echo 2.  
> $i = 3;  
>   
> [back to beginning of the loop]  
> is $i &lt; 5? 3&lt;5, so yes -- let's do the loop!  
> echo 3.  
> $i = 4;  
>   
> [back to beginning of the loop]  
> is $i &lt; 5? 4&lt;5, so yes -- let's do the loop!  
> echo 4.  
> $i = 5;  
>   
> [back to beginning of the loop]  
> is $i &lt; 5? 5 IS NOT less than 5, so EXIT.  

Okay **let's do it for the array**.

The 3 parts of the for loop:

1. Start a 0 (the first element of the array is 0): $i=0
2. Go up to the largest element in the array.  The largest element is 6, so $i&lt;7,  Or, more generally, $i&lt;count($days)
	- count($days) tells you how many elements are in the array "$days".  $days has 7 elements, so that is what we want.
3. As usual, add 1 at the end of the loop.

```php
  for($i=0;$i<count($days);++$i)
  {

  }
```

So what is the code to go inside the loop?  We want to display all the days, so let's use $i=0 as an example:

```php
echo $days[$i] . "<br />;";
```

Now we just put that inside the loop

```php
  for($i=0;$i<count($days);++$i)
  {
    echo $days[$i] . "<br />";
  }
``

Upload it and check!
