<?php

$xml = simplexml_load_file("books.xml");

if ($xml === false) {
    die("Error: Cannot load XML file.");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book Library</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: linen;
            margin: 0;
            padding: 40px;
        }

        .container {
            width: 90%;
            margin: auto;
            background-color: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        h1 {
            text-align: center;
            color: #800020;
            margin-bottom: 25px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #fffaf5;
        }

        th {
            background-color: #800020;
            color: white;
            padding: 14px;
            font-size: 17px;
        }

        td {
            padding: 12px;
            text-align: center;
            border: 1px solid #d8b8b8;
            color: #4a1f1f;
        }

        tr:nth-child(even) {
            background-color: #f8e9e9;
        }

        tr:hover {
            background-color: #ead1d1;
        }

        .price {
            font-weight: bold;
            color: #800020;
        }

        .footer {
            text-align: center;
            margin-top: 20px;
            color: #800020;
            font-size: 14px;
        }
    </style>
</head>

<body>

<div class="container">

    <h1>📚 Book Library</h1>

    <table>

        <tr>
            <th>Title</th>
            <th>Author</th>
            <th>Year</th>
            <th>Price</th>
        </tr>

        <?php
        foreach ($xml->book as $book) {
        ?>

        <tr>
            <td>
                <?php echo htmlspecialchars($book->title); ?>
            </td>

            <td>
                <?php echo htmlspecialchars($book->author); ?>
            </td>

            <td>
                <?php echo htmlspecialchars($book->year); ?>
            </td>

            <td class="price">
                ₹<?php echo htmlspecialchars($book->price); ?>
            </td>
        </tr>

        <?php
        }
        ?>

    </table>

    <div class="footer">
        Read and Display XML File using PHP
    </div>

</div>

</body>
</html>