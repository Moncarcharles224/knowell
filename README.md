KNOWWELL - SmartStudy

1. Introduction
KNOWWELL - SmartStudy is a web-based quiz application designed to help students learn and test their knowledge of various programming languages. 
The application provides a user-friendly interface for taking quizzes, tracks user progress, and includes an administrative panel for managing course content. 
The project addresses the need for accessible and engaging educational tools in the IT sector within Ghana.

1.2 Project Scope
The application is a full-stack solution built to demonstrate core web development concepts, including user authentication, CRUD operations, database management, and API integration.

2. System Architecture
The application follows a standard client-server architecture.

Client (Front End): HTML5, CSS3, JavaScript
Server (Back End): PHP
Database: MySQL
Licensed by Google
Third-Party API: A public API to fetch random facts, integrated into the homepage.

3. Technology Stack
Front End: HTML5, CSS3, JavaScript
Back End: PHP
Database: MySQL
Local Development Environment: XAMPP (Apache, MySQL, PHP)
Third-Party API: Public API for random facts

4. Database Design
The database, named courses_quiz_db, consists of four tables that are linked by relationships to store and manage the application's data.

users table:
- id (INT, Primary Key, Auto Increment)
- username (VARCHAR(50))
- email (VARCHAR(100), UNIQUE)
- password (VARCHAR(255))
- created_at (TIMESTAMP)

courses table:
- id (INT, Primary Key, Auto Increment)
- course_name (VARCHAR(100))

questions table:
- id (INT, Primary Key, Auto Increment)
- course_id (INT, Foreign Key referencing courses.id)
- question_text (TEXT)
- option_a, option_b, option_c, option_d (VARCHAR(255))
- correct_option (CHAR(1))

user_progress table:
- user_id (INT, Foreign Key referencing users.id)
- course_id (INT, Foreign Key referencing courses.id)
- score (INT)
- PRIMARY KEY (user_id, course_id)


5. Project Links
(KNOWWELL WEBSITE)
Live Site: http://moncarcharles-001-site1.ntempurl.com/login.php
(ADMIN PANEL)
Admin Panel (CRUD): http://moncarcharles-001-site1.ntempurl.com/admin.php
(VIDEO PRESENTATION)
https://drive.google.com/file/d/1p0D_2X7S0Juh2ns7MjsqUkJo8m-BMMtV/view?usp=drive_link 

6. How to Access the Site (Via Local Development)
1. Download XAMPP Control Panel from Google or https://www.apachefriends.org/download.html
2. Extract the knowwell.zip file
3. Copy and paste the extracted file into C:/Xampp/htdocs
4. Launch the XAMPP Control Panel after installation
5. Start Apache and MySQL
6. Open any web browser and type: localhost/phpmyadmin
7. Click on the SQL Tab
8. Check the database folder and paste the SQL code into phpMyAdmin
9. Access the site using: localhost/knowwell
(admin account for CRUD:moncarcharles093@gmail.com pass:12345)
7 Participants
Charles Moncar — 1704979935
