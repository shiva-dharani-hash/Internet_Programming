<?php
session_start();
require_once "db.php";

if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "student") {
    header("Location: login.php");
    exit();
}

$student_id = (int)$_SESSION["student_id"];

$sql = "SELECT name, register_no, email, department, year, section
        FROM students WHERE student_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();
$stmt->close();

if (!$student) {
    header("Location: logout.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Profile</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header class="dashboard-nav">
    <div class="logo">AttendEase</div>
    <div class="nav-right">
        <a href="student_dashboard.php">Dashboard</a>
        <a href="logout.php">Logout</a>
    </div>
</header>

<main class="dashboard">
    <div class="page-heading">
        <p class="tagline">STUDENT PROFILE</p>
        <h1>My Profile</h1>
    </div>

    <div class="profile-card">
        <div class="profile-avatar">
            <?php echo strtoupper(substr($student["name"], 0, 1)); ?>
        </div>
        <div class="profile-details">
            <h2><?php echo htmlspecialchars($student["name"]); ?></h2>

            <div class="profile-row"><span>Register Number</span><strong><?php echo htmlspecialchars($student["register_no"]); ?></strong></div>
            <div class="profile-row"><span>Email</span><strong><?php echo htmlspecialchars($student["email"]); ?></strong></div>
            <div class="profile-row"><span>Department</span><strong><?php echo htmlspecialchars($student["department"]); ?></strong></div>
            <div class="profile-row"><span>Year</span><strong><?php echo htmlspecialchars($student["year"]); ?></strong></div>
            <div class="profile-row"><span>Section</span><strong><?php echo htmlspecialchars($student["section"]); ?></strong></div>
        </div>
    </div>
</main>
</body>
</html>
