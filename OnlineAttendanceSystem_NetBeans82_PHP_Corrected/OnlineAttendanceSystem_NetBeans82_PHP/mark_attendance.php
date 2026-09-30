<?php
session_start();
require_once "db.php";

if (!isset($_SESSION["role"]) || $_SESSION["role"] !== "faculty") {
    header("Location: login.php");
    exit();
}

$faculty_id = (int)$_SESSION["faculty_id"];
$message = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $subject_id = isset($_POST["subject_id"]) ? (int)$_POST["subject_id"] : 0;
    $attendance_date = isset($_POST["attendance_date"]) ? $_POST["attendance_date"] : "";

    if ($subject_id <= 0 || $attendance_date === "") {
        $error = "Please select a subject and date.";
    } else {
        $verify = $conn->prepare("SELECT subject_id FROM subjects WHERE subject_id = ? AND faculty_id = ?");
        $verify->bind_param("ii", $subject_id, $faculty_id);
        $verify->execute();
        $verify_result = $verify->get_result();

        if ($verify_result->num_rows !== 1) {
            $error = "Invalid subject selected.";
            $verify->close();
        } else {
            $verify->close();

            $students = $conn->query("SELECT student_id FROM students ORDER BY register_no");
            $insert = $conn->prepare(
                "INSERT INTO attendance (student_id, subject_id, attendance_date, status)
                 VALUES (?, ?, ?, ?)
                 ON DUPLICATE KEY UPDATE status = VALUES(status)"
            );

            while ($student = $students->fetch_assoc()) {
                $student_id = (int)$student["student_id"];
                $field = "status_" . $student_id;
                $status = isset($_POST[$field]) ? $_POST[$field] : "Absent";

                if ($status !== "Present" && $status !== "Absent") {
                    $status = "Absent";
                }

                $insert->bind_param("iiss", $student_id, $subject_id, $attendance_date, $status);
                $insert->execute();
            }

            $insert->close();
            $message = "Attendance saved successfully.";
        }
    }
}

$stmt = $conn->prepare("SELECT subject_id, subject_code, subject_name FROM subjects WHERE faculty_id = ? ORDER BY subject_code");
$stmt->bind_param("i", $faculty_id);
$stmt->execute();
$subjects = $stmt->get_result();
$stmt->close();

$students = $conn->query("SELECT student_id, name, register_no FROM students ORDER BY register_no");
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mark Attendance</title>
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
        <p class="tagline">FACULTY ATTENDANCE</p>
        <h1>Mark Attendance</h1>
        <p>Select subject and date, then mark Present or Absent.</p>
    </div>

    <?php if ($message !== ""): ?>
        <div class="success-message"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>

    <?php if ($error !== ""): ?>
        <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <div class="attendance-form-card">
        <form method="post" action="mark_attendance.php">
            <div class="form-row">
                <div class="form-group">
                    <label for="subject_id">Select Subject</label>
                    <select name="subject_id" id="subject_id" required>
                        <option value="">-- Select Subject --</option>
                        <?php while ($subject = $subjects->fetch_assoc()): ?>
                            <option value="<?php echo (int)$subject["subject_id"]; ?>">
                                <?php echo htmlspecialchars($subject["subject_code"] . " - " . $subject["subject_name"]); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="attendance_date">Attendance Date</label>
                    <input type="date" name="attendance_date" id="attendance_date" value="<?php echo date("Y-m-d"); ?>" required>
                </div>
            </div>

            <h2>Student Attendance</h2>

            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Student</th>
                            <th>Register Number</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php while ($student = $students->fetch_assoc()): ?>
                        <?php $id = (int)$student["student_id"]; ?>
                        <tr>
                            <td><?php echo htmlspecialchars($student["name"]); ?></td>
                            <td><?php echo htmlspecialchars($student["register_no"]); ?></td>
                            <td>
                                <div class="attendance-options">
                                    <label>
                                        <input type="radio" name="status_<?php echo $id; ?>" value="Present" checked>
                                        Present
                                    </label>
                                    <label>
                                        <input type="radio" name="status_<?php echo $id; ?>" value="Absent">
                                        Absent
                                    </label>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                    </tbody>
                </table>
            </div>

            <button type="submit" class="btn save-btn">Save Attendance</button>
        </form>
    </div>
</main>
</body>
</html>
