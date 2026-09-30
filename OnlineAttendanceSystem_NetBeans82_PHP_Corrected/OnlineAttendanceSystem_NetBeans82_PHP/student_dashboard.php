<?php
session_start();
require_once "db.php";

if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "student") {
    header("Location: login.php");
    exit();
}

$student_id = (int)$_SESSION["student_id"];
$total = 0;
$present = 0;
$percentage = 0;

$sql = "SELECT COUNT(*) AS total,
               COALESCE(SUM(CASE WHEN status = 'Present' THEN 1 ELSE 0 END), 0) AS present
        FROM attendance
        WHERE student_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$data = $stmt->get_result()->fetch_assoc();
$total = (int)$data["total"];
$present = (int)$data["present"];
if ($total > 0) {
    $percentage = ($present / $total) * 100;
}
$stmt->close();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<header class="dashboard-nav">
    <div class="logo">AttendEase</div>
    <div class="nav-right">
        <span><?php echo htmlspecialchars($_SESSION["name"]); ?></span>
        <a href="logout.php" onclick="return confirmLogout();">Logout</a>
    </div>
</header>

<main class="dashboard">
    <div class="welcome">
        <p class="tagline">STUDENT PORTAL</p>
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION["name"]); ?></h1>
        <p>View your academic attendance and profile.</p>
    </div>

    <div class="stats-container">
        <div class="stat-card">
            <span class="stat-icon">📚</span>
            <h3>Total Classes</h3>
            <strong><?php echo $total; ?></strong>
        </div>
        <div class="stat-card">
            <span class="stat-icon">✅</span>
            <h3>Present</h3>
            <strong><?php echo $present; ?></strong>
        </div>
        <div class="stat-card">
            <span class="stat-icon">📊</span>
            <h3>Overall Attendance</h3>
            <strong><?php echo number_format($percentage, 2); ?>%</strong>
        </div>
    </div>

    <div class="quick-section">
        <h2>Student Services</h2>
        <div class="quick-grid">
            <a href="student_attendance.php" class="quick-card">
                <span>📊</span>
                <h3>My Attendance</h3>
                <p>View subject-wise attendance details.</p>
            </a>
            <a href="student_profile.php" class="quick-card">
                <span>👤</span>
                <h3>My Profile</h3>
                <p>View your student profile.</p>
            </a>
        </div>
    </div>
</main>
</body>
</html>
