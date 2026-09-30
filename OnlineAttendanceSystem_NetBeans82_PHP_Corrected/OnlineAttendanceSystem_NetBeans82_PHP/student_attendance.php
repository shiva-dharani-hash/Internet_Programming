<?php
session_start();
require_once "db.php";

if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "student") {
    header("Location: login.php");
    exit();
}

$student_id = (int)$_SESSION["student_id"];

$sql = "SELECT s.subject_code, s.subject_name,
               COUNT(a.attendance_id) AS total,
               COALESCE(SUM(CASE WHEN a.status = 'Present' THEN 1 ELSE 0 END), 0) AS present
        FROM subjects s
        LEFT JOIN attendance a
          ON s.subject_id = a.subject_id
         AND a.student_id = ?
        GROUP BY s.subject_id, s.subject_code, s.subject_name
        ORDER BY s.subject_code";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();

$overall_total = 0;
$overall_present = 0;
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Attendance</title>
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
        <p class="tagline">ATTENDANCE REPORT</p>
        <h1>My Attendance</h1>
        <p>Subject-wise attendance details.</p>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Subject Code</th>
                    <th>Subject</th>
                    <th>Total</th>
                    <th>Present</th>
                    <th>Absent</th>
                    <th>Percentage</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <?php
                $total = (int)$row["total"];
                $present = (int)$row["present"];
                $absent = $total - $present;
                $percentage = $total > 0 ? ($present / $total) * 100 : 0;
                $overall_total += $total;
                $overall_present += $present;
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($row["subject_code"]); ?></td>
                    <td><?php echo htmlspecialchars($row["subject_name"]); ?></td>
                    <td><?php echo $total; ?></td>
                    <td class="present"><?php echo $present; ?></td>
                    <td class="absent"><?php echo $absent; ?></td>
                    <td><strong><?php echo number_format($percentage, 2); ?>%</strong></td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <?php $overall_percentage = $overall_total > 0 ? ($overall_present / $overall_total) * 100 : 0; ?>

    <div class="overall-card">
        <span>Overall Attendance</span>
        <strong><?php echo number_format($overall_percentage, 2); ?>%</strong>
    </div>
</main>
</body>
</html>
<?php $stmt->close(); ?>
