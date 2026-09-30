ONLINE STUDENT ATTENDANCE MANAGEMENT SYSTEM
NetBeans 8.2 PHP + MariaDB + XAMPP

REQUIREMENTS
- XAMPP
- Apache
- MariaDB/MySQL
- PHP
- NetBeans 8.2 with PHP support

PROJECT LOCATION
C:\xampp\htdocs\OnlineAttendanceSystem

DATABASE
Database name: attendance_db
Host: localhost
Port: 3306
Username: root
Password: empty by default

SETUP
1. Extract/copy OnlineAttendanceSystem into C:\xampp\htdocs\
2. Start Apache and MySQL/MariaDB from XAMPP.
3. Open http://localhost/phpmyadmin/
4. Import database.sql.
5. Open http://localhost/OnlineAttendanceSystem/

STUDENT LOGIN
Register Number: 24UCS003
Password: 1234

FACULTY LOGIN
Email: kumar@gmail.com
Password: 1234

NETBEANS 8.2
Use File > Open Project and select the OnlineAttendanceSystem folder.
If NetBeans asks for the PHP interpreter, select the PHP installed inside XAMPP:
C:\xampp\php\php.exe

IMPORTANT
This project is for college demonstration. Demo passwords are stored as simple text in the sample database. A production system should use password_hash() and password_verify().
