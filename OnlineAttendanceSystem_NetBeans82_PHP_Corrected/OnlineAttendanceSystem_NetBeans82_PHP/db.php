<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "attendance_db";
$port = 3306;

$conn = new mysqli($host, $user, $password, $database, $port);

if ($conn->connect_error) {
    die("Database connection failed. Please check XAMPP MariaDB and database settings.");
}

$conn->set_charset("utf8mb4");
?>
