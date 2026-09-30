<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AttendEase - Online Attendance System</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header class="navbar">
    <div class="logo">AttendEase</div>
    <a href="login.php" class="nav-login">Login</a>
</header>

<section class="hero">
    <div class="hero-content">
        <p class="tagline">SMART ATTENDANCE MANAGEMENT</p>
        <h1>Online Student Attendance Management System</h1>
        <p>A simple and professional web application for students and faculty to manage attendance.</p>
        <a href="login.php" class="btn">Login to System</a>
    </div>
</section>

<section class="features">
    <h2>System Features</h2>
    <div class="feature-container">
        <div class="feature-card">
            <div class="icon">🎓</div>
            <h3>Student Portal</h3>
            <p>Students can login and view profile and attendance details.</p>
        </div>
        <div class="feature-card">
            <div class="icon">👨‍🏫</div>
            <h3>Faculty Portal</h3>
            <p>Faculty can select subjects and manually mark attendance.</p>
        </div>
        <div class="feature-card">
            <div class="icon">📊</div>
            <h3>Attendance Reports</h3>
            <p>View subject-wise total, present, absent and percentage.</p>
        </div>
    </div>
</section>

<footer>
    <p>Online Student Attendance Management System</p>
</footer>
</body>
</html>
