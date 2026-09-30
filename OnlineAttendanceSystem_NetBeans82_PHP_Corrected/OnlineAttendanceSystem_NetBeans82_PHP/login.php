<?php
session_start();
require_once "db.php";

if (isset($_SESSION["role"])) {
    if ($_SESSION["role"] === "student") {
        header("Location: student_dashboard.php");
        exit();
    }
    if ($_SESSION["role"] === "faculty") {
        header("Location: faculty_dashboard.php");
        exit();
    }
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $role = isset($_POST["role"]) ? $_POST["role"] : "";
    $username = trim(isset($_POST["username"]) ? $_POST["username"] : "");
    $password = isset($_POST["password"]) ? $_POST["password"] : "";

    if ($role === "student") {
        $sql = "SELECT student_id, name, register_no FROM students WHERE register_no = ? AND password = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $student = $result->fetch_assoc();
            $_SESSION["role"] = "student";
            $_SESSION["student_id"] = $student["student_id"];
            $_SESSION["name"] = $student["name"];
            $_SESSION["register_no"] = $student["register_no"];
            header("Location: student_dashboard.php");
            exit();
        }
        $error = "Invalid student register number or password.";
        $stmt->close();

    } elseif ($role === "faculty") {
        $sql = "SELECT faculty_id, name, email FROM faculty WHERE email = ? AND password = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $faculty = $result->fetch_assoc();
            $_SESSION["role"] = "faculty";
            $_SESSION["faculty_id"] = $faculty["faculty_id"];
            $_SESSION["name"] = $faculty["name"];
            $_SESSION["email"] = $faculty["email"];
            header("Location: faculty_dashboard.php");
            exit();
        }
        $error = "Invalid faculty email or password.";
        $stmt->close();
    } else {
        $error = "Please select a valid login role.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - AttendEase</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="login-page">
<div class="login-container">
    <div class="login-box">
        <div class="login-logo">AttendEase</div>
        <h1>Welcome Back</h1>
        <p class="login-subtitle">Login to access your attendance portal</p>

        <?php if ($error !== ""): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="post" action="login.php" onsubmit="return validateLogin();">
            <label for="role">Login As</label>
            <select name="role" id="role" onchange="changeUsernameLabel()" required>
                <option value="student">Student</option>
                <option value="faculty">Faculty</option>
            </select>

            <label for="username" id="usernameLabel">Register Number</label>
            <input type="text" name="username" id="username" placeholder="Enter register number" required>

            <label for="password">Password</label>
            <input type="password" name="password" id="password" placeholder="Enter password" required>

            <button type="submit" class="btn login-btn">Login</button>
        </form>

        <a href="index.php" class="back-link">← Back to Home</a>
    </div>
</div>
<script src="js/script.js"></script>
</body>
</html>
