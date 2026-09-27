<?php

include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $customer_name = $_POST['customer_name'] ?? '';
    $email = $_POST['email'] ?? '';
    $product_name = $_POST['product_name'] ?? '';
    $quantity = $_POST['quantity'] ?? 1;
    $price = $_POST['price'] ?? 0;

    $sql = "INSERT INTO orders
            (customer_name, email, product_name, quantity, price)
            VALUES (?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("SQL Error: " . $conn->error);
    }

    // s = string
    // s = string
    // s = string
    // i = integer
    // d = decimal

    $stmt->bind_param(
        "sssid",
        $customer_name,
        $email,
        $product_name,
        $quantity,
        $price
    );

    if ($stmt->execute()) {

        echo "<!DOCTYPE html>";
        echo "<html>";
        echo "<head>";
        echo "<title>Order Successful</title>";

        echo "<style>";
        echo "
        body {
            font-family: Arial;
            background: #f2f2f2;
            text-align: center;
            padding-top: 80px;
        }

        .box {
            background: white;
            width: 450px;
            max-width: 90%;
            margin: auto;
            padding: 35px;
            border-radius: 10px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.15);
        }

        h1 {
            color: #264653;
        }

        p {
            font-size: 17px;
        }

        a {
            display: inline-block;
            background: #e76f51;
            color: white;
            text-decoration: none;
            padding: 12px 22px;
            border-radius: 5px;
            margin: 10px;
        }
        ";
        echo "</style>";

        echo "</head>";

        echo "<body>";

        echo "<div class='box'>";

        echo "<h1>Order Placed Successfully!</h1>";

        echo "<p>Thank you, <strong>" .
             htmlspecialchars($customer_name) .
             "</strong>.</p>";

        echo "<p>Your order has been saved in the database.</p>";

        echo "<a href='index.html'>Back to Home</a>";

        echo "<a href='view_orders.php'>View Orders</a>";

        echo "</div>";

        echo "</body>";
        echo "</html>";

    } else {

        echo "Error saving order: " . $stmt->error;

    }

    $stmt->close();
    $conn->close();

} else {

    echo "Invalid request.";

}

?>