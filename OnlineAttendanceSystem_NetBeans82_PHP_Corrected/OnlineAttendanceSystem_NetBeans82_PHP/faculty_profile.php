<?php
session_start();
require_once "db.php";

if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "faculty") {
    header("Location: login.php");
    exit();
}

$faculty_id = (int)$_SESSION["faculty_id"];

$stmt = $conn->prepare("SELECT name, email, department, designation FROM faculty WHERE faculty_id = ?");
$stmt->bind_param("i", $faculty_id);
$stmt->execute();
$faculty = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$faculty) {
    header("Location: logout.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Profile</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header class="dashboard-nav">
    <div class="logo">AttendEase</div>
    <div class="nav-right">
        <a href="faculty_dashboard.php">Dashboard</a>
        <a href="logout.php">Logout</a>
    </div>
</header>

<main class="dashboard">
    <div class="page-heading">
        <p class="tagline">FACULTY PROFILE</p>
        <h1>My Profile</h1>
    </div>

    <div class="profile-card">
        <div class="profile-avatar">
            <?php echo strtoupper(substr($faculty["name"], 0, 1)); ?>
        </div>
        <div class="profile-details">
            <h2><?php echo htmlspecialchars($faculty["name"]); ?></h2>
            <div class="profile-row"><span>Email</span><strong><?php echo htmlspecialchars($faculty["email"]); ?></strong></div>
            <div class="profile-row"><span>Department</span><strong><?php echo htmlspecialchars($faculty["department"]); ?></strong></div>
            <div class="profile-row"><span>Designation</span><strong><?php echo htmlspecialchars($faculty["designation"]); ?></strong></div>
        </div>
    </div>
</main>
</body>
</html>
