# News posting website

My main goal was to build a website, where authorized users can post news.  
Unauthorized users can only view the website and can not post anything.

There are 3 types of users: Admin, Moderator, User. 
- Admin - can edit and view everything from everyone
- Moderator - can post news and comments, can edit his own news and comments
- User - can post comments on other user's news, can edit his comment but can't post news

### Data validation and attacks
The data that a user can post is validated. Checks if password is complex enough, if all the required fields are entered, etc.  
All the data is sanitized to prevent Cross-site Scripting (XSS) attacks.  
SQL queries are used with prepared statements to prevent SQL injections.  
Passwords are stored with their hash value and not just in plain text.  

## Technologies
I didn't use any libraries, because I wanted to learn these technologies.  
Backend: PHP  
Frontend: HTML, CSS and JavaScript.  
Database: MySQL  

## Database
![image](https://user-images.githubusercontent.com/75981790/171613803-9309f87a-e124-4dc9-b92f-d17d364a8823.png)

# TODO
- Change that only Moderators and Admins can post news (at the moment any registered user can post news)
- Add admin panel, where admin can change user's information (It would be mostly used to change the user' role)
- Change the way images are stored (store the image on server, and in DB just save a link to it)
- Add Edit, Delete options for user's comments

