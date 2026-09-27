<?php

// Get form values
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$mobile = trim($_POST['mobile'] ?? '');
$dob = trim($_POST['dob'] ?? '');
$gender = trim($_POST['gender'] ?? '');
$card = trim($_POST['card'] ?? '');
$address = trim($_POST['address'] ?? '');
$password = $_POST['password'] ?? '';
$confirm_password = $_POST['confirm_password'] ?? '';
$terms = $_POST['terms'] ?? '';

$errors = [];

/* ---------------- VALIDATION ---------------- */

// Name
if (!preg_match("/^[A-Za-z ]+$/", $name)) {
    $errors[] = "Name should contain only letters and spaces.";
}

// Email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Enter a valid email address.";
}

// Mobile
if (!preg_match("/^[0-9]{10}$/", $mobile)) {
    $errors[] = "Phone number must contain exactly 10 digits.";
}

// Date of Birth
if (empty($dob)) {
    $errors[] = "Date of Birth is required.";
}

// Gender
if (empty($gender)) {
    $errors[] = "Please select your gender.";
}

// Credit Card
if (!preg_match("/^[0-9]{16}$/", $card)) {
    $errors[] = "Credit Card Number must contain exactly 16 digits.";
}

// Address
if (empty($address)) {
    $errors[] = "Address is required.";
}

// Password
if (!preg_match("/^(?=.*[0-9])(?=.*[!@#$%^&*]).{8,}$/", $password)) {
    $errors[] = "Password must contain at least 8 characters, 1 number and 1 special character.";
}

// Confirm Password
if ($password !== $confirm_password) {
    $errors[] = "Passwords do not match.";
}

// Terms
if ($terms !== "accepted") {
    $errors[] = "You must accept the Terms & Conditions.";
}


/* ---------------- DISPLAY RESULT ---------------- */

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>Registration Result</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            background: #eef2ff;
            margin: 0;
            padding: 40px;
        }

        .container {
            width: 600px;
            max-width: 95%;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        }

        h1 {
            color: #1e3a8a;
            text-align: center;
        }

        h2 {
            color: #dc2626;
        }

        .details {
            margin-top: 20px;
        }

        .details p {
            padding: 8px;
            border-bottom: 1px solid #e5e7eb;
        }

        .error {
            color: #dc2626;
            padding: 8px;
            background: #fee2e2;
            margin: 8px 0;
            border-radius: 5px;
        }

        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 18px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 6px;
        }

        a:hover {
            background: #1e40af;
        }

    </style>

</head>

<body>

<div class="container">

<?php

if (empty($errors)) {

    echo "<h1>Registration Successful!</h1>";

    echo "<div class='details'>";

    echo "<p><strong>Name:</strong> "
        . htmlspecialchars($name)
        . "</p>";

    echo "<p><strong>Email:</strong> "
        . htmlspecialchars($email)
        . "</p>";

    echo "<p><strong>Mobile:</strong> "
        . htmlspecialchars($mobile)
        . "</p>";

    echo "<p><strong>Date of Birth:</strong> "
        . htmlspecialchars($dob)
        . "</p>";

    echo "<p><strong>Gender:</strong> "
        . htmlspecialchars($gender)
        . "</p>";

    echo "<p><strong>Credit Card:</strong> "
        . htmlspecialchars($card)
        . "</p>";

    echo "<p><strong>Address:</strong> "
        . htmlspecialchars($address)
        . "</p>";

    echo "</div>";

} else {

    echo "<h2>Please correct the following:</h2>";

    foreach ($errors as $error) {

        echo "<div class='error'>";

        echo "✗ " . htmlspecialchars($error);

        echo "</div>";
    }
}

?>

<a href="registration.html">
    Back to Registration
</a>

</div>

</body>
</html>