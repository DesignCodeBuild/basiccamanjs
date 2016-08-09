## We will need to add information about photos uploaded in the web app to a database

**This makes it possible to save and display the photos, photo captions, and user reactions (i.e. likes) to everyone who visits the site.**

**To do this:**

1) Go to your cPanel, i.e. http://yourname.designcodebuild.com:2083 and enter your login details. 
2) Find the MySQL Database link, towards the bottom of the page. 
![Alt text](http://designcodebuild.com/lessons/database/1.jpeg "MySQL Database Link")

3) Create a name for your database. You will see a text field appear after a prefix like **yourname_**. Enter the word **photos** here. This turns your database name into **yourname_photos** which will help make it clear to you what the database is for. 
4) Add a user to the database: 

Then, 

##Database
- PID (auto_increment)
- filename 
- caption
- reactions
