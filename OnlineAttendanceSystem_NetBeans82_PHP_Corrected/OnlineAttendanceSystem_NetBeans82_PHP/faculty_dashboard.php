<?php
session_start();
require_once "db.php";

if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "faculty") {
    header("Location: login.php");
    exit();
}

$faculty_id = (int)$_SESSION["faculty_id"];

$stmt = $conn->prepare("SELECT COUNT(*) AS total FROM subjects WHERE faculty_id = ?");
$stmt->bind_param("i", $faculty_id);
$stmt->execute();
$subject_count = (int)$stmt->get_result()->fetch_assoc()["total"];
$stmt->close();

$result = $conn->query("SELECT COUNT(*) AS total FROM students");
$student_count = (int)$result->fetch_assoc()["total"];

$sql = "SELECT COUNT(*) AS total
        FROM attendance a
        INNER JOIN subjects s ON a.subject_id = s.subject_id
        WHERE s.faculty_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $faculty_id);
$stmt->execute();
$attendance_count = (int)$stmt->get_result()->fetch_assoc()["total"];
$stmt->close();

$stmt = $conn->prepare("SELECT subject_code, subject_name FROM subjects WHERE faculty_id = ? ORDER BY subject_code");
$stmt->bind_param("i", $faculty_id);
$stmt->execute();
$subjects = $stmt->get_result();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Dashboard</title>
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
        <p class="tagline">FACULTY PORTAL</p>
        <h1>Welcome, <?php echo htmlspecialchars($_SESSION["name"]); ?></h1>
        <p>Manage student attendance for your assigned subjects.</p>
    </div>

    <div class="stats-container">
        <div class="stat-card"><span class="stat-icon">📚</span><h3>Assigned Subjects</h3><strong><?php echo $subject_count; ?></strong></div>
        <div class="stat-card"><span class="stat-icon">🎓</span><h3>Students</h3><strong><?php echo $student_count; ?></strong></div>
        <div class="stat-card"><span class="stat-icon">📝</span><h3>Attendance Records</h3><strong><?php echo $attendance_count; ?></strong></div>
    </div>

    <div class="quick-section">
        <h2>Quick Actions</h2>
        <div class="quick-grid">
            <a href="mark_attendance.php" class="quick-card">
                <span>📝</span>
                <h3>Mark Attendance</h3>
                <p>Select subject and manually mark Present or Absent.</p>
            </a>
            <a href="faculty_profile.php" class="quick-card">
                <span>👤</span>
                <h3>Faculty Profile</h3>
                <p>View your faculty information.</p>
            </a>
        </div>
    </div>

    <div class="subject-section">
        <h2>My Assigned Subjects</h2>
        <div class="table-container">
            <table>
                <thead><tr><th>Subject Code</th><th>Subject Name</th></tr></thead>
                <tbody>
                <?php while ($subject = $subjects->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($subject["subject_code"]); ?></td>
                        <td><?php echo htmlspecialchars($subject["subject_name"]); ?></td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>
<script src="js/script.js"></script>
</body>
</html>
<?php $stmt->close(); ?>
