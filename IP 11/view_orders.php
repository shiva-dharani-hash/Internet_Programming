<?php

include "db.php";

$sql = "SELECT * FROM orders ORDER BY order_id DESC";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>

<head>

    <title>Order Details</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            padding: 30px;
        }

        .container {
            width: 95%;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.15);
        }

        h2 {
            text-align: center;
            color: #1e3a8a;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }

        th {
            background: #2563eb;
            color: white;
            padding: 12px;
        }

        td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
        }

        tr:nth-child(even) {
            background: #f8fafc;
        }

        .back {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 15px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

    </style>

</head>

<body>

<div class="container">

    <h2>Stored Order Details</h2>

    <table>

        <tr>
            <th>Order ID</th>
            <th>Customer Name</th>
            <th>Email</th>
            <th>Product</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Order Date</th>
        </tr>

        <?php

        if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {

        ?>

        <tr>

            <td>
                <?php echo htmlspecialchars($row['order_id']); ?>
            </td>

            <td>
                <?php echo htmlspecialchars($row['customer_name']); ?>
            </td>

            <td>
                <?php echo htmlspecialchars($row['email']); ?>
            </td>

            <td>
                <?php echo htmlspecialchars($row['product_name']); ?>
            </td>

            <td>
                <?php echo htmlspecialchars($row['quantity']); ?>
            </td>

            <td>
                ₹<?php echo htmlspecialchars($row['price']); ?>
            </td>

            <td>
                <?php echo htmlspecialchars($row['order_date']); ?>
            </td>

        </tr>

        <?php

            }

        } else {

            echo "<tr>";
            echo "<td colspan='7'>No orders found</td>";
            echo "</tr>";

        }

        ?>

    </table>

    <a class="back" href="index.html">
        Place New Order
    </a>

</div>

</body>

</html>

<?php

$conn->close();

?>