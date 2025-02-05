How to Set Up and Run the Application 
1. Install WampServer: 
• Download and install WampServer on your local machine to set up a local 
server environment. 
2. Copy Project Files: 
• Place my created New Web folder in the www directory of your WampServer 
installation. 
3. How to search the web in web browsers: 
http://localhost/New%20Web/home.html 
copy this URL and paste it into your browser or, type in the search bar as, 
localhost/New Web/home.html 
then you will move to the home tab of my web and from there you can use the entire 
web application using the navigation bar and tabs included there 
4. Database Configuration: 
• Open phpMyAdmin in your browser by navigating to 
http://localhost/phpmyadmin 
• Inside the phpMyAdmin, create a database name as research_db and make a 
table name as researchers inside this database you created. (username - root) 
http://localhost/phpmyadmin/index.php?route=/sql&pos=0&db=research_db&ta
 ble=researchers 
pg. 1 
 pg. 2 
This is the URL displayed on the search bar when you are inside the 
research_db database’s researchers table. 
• For ease, I will give here the code, which you must copy and paste inside the 
research_db database after making the research_db database. 
 
 
• After creating the research_db database and the researchers table inside it when the 
user fills out the registration form, those details will be stored inside this table.  
 
• Also, after the user filled all these details and they are stored in researchers table, 
inside the database, there will automatically generate a QR code using these details 
and the QR code will be sent to the email of that user mentioned here. 
 
 
• Also, when the user tries to log into the web application again, the system will check 
his/her information from this research db’s researchers table. Then if the details are 
correct, if that user is an admin, he/she will be sent to the admin dashboard, if he/she is 
a participant, he/she will move to the schedule tab and then can access any tab of the 
web application. 
CREATE TABLE researchers ( 
id INT AUTO_INCREMENT PRIMARY KEY, 
name VARCHAR(255) NOT NULL, 
category VARCHAR(50) NOT NULL, 
email VARCHAR(191) NOT NULL UNIQUE, -- Reduced length for indexing 
nic VARCHAR(50) NOT NULL UNIQUE, 
phone VARCHAR(15) NOT NULL, 
country VARCHAR(100) NOT NULL, 
track VARCHAR(255), 
slip_code VARCHAR(50) NOT NULL, 
password_hash VARCHAR(255) NOT NULL, 
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP 
); 
 
