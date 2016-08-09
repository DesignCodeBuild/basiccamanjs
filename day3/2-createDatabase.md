## We will need to add information about photos uploaded in the web app to a database

**This makes it possible to save and display the photos, photo captions, and user reactions (i.e. likes) to everyone who visits the site.**

**To do this:**

1. **Go to your cPanel** i.e. http://yourname.designcodebuild.com:2083 and enter your login details. 
2. **Find the MySQL Database link** towards the bottom of the page. 
![Alt text](http://designcodebuild.com/lessons/database/1.jpeg "MySQL Database Link")
3. **Create a name for your database.** "photodatabase" is a good name.
![Alt text](http://designcodebuild.com/lessons/database/2.jpeg "Name and Create Your Database")
4. **Create a user for the database:** This can be just your name.
![Alt text](http://designcodebuild.com/lessons/database/3.jpeg "Create Database User")
5. **Add the new user to the database** Click the *Add* button.
![Alt text](http://designcodebuild.com/lessons/database/4.jpeg "Add User to Database")
6. **Assign privileges to the user** Choose "all privileges".
![Alt text](http://designcodebuild.com/lessons/database/5.jpeg "Assign user privileges")
7. **Return to your cPanel home** and find the **phpMyAdmin** link. 
![Alt text](http://designcodebuild.com/lessons/database/6.jpeg "phpMyAdmin")
8. **Create a table in your new database** Name it "photos" and give it 4 columns. Click **Go**.
![Alt text](http://designcodebuild.com/lessons/database/7.jpeg "phpMyAdmin")
9. **Name the columns as follows.** Pay attention to the TYPE for each and check off the **A_I** box for the PID column. **Save**
![Alt text](http://designcodebuild.com/lessons/database/8.jpeg "phpMyAdmin")

**Write down the database name, username, and passwords in a secure place for reference.**

**Now, return to the cPanel Home, and Log Off**
