<?php
session_start();
include('../db_connect.php');

if (!isset($_SESSION['customer_id'])) {
    header("Location: customer_login.php");
    exit();
}

$customer_id = $_SESSION['customer_id'];

$order_query = "SELECT orders.*, customers.name AS customer_name 
                FROM orders 
                JOIN customers ON orders.customer_id = customers.id 
                WHERE orders.customer_id='$customer_id' 
                ORDER BY order_date DESC";
$order_result = mysqli_query($connection, $order_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f8f9fa;
            padding: 20px;
            margin: 0;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            margin-top: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 12px 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #e9f5ff;
        }

        p {
            text-align: center;
            font-size: 18px;
            color: #555;
        }

        a {
            display: block;
            width: max-content;
            margin: 30px auto 0;
            text-align: center;
            padding: 10px 20px;
            background-color: #6c757d;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        a:hover {
            background-color: #495057;
        }
    </style>
</head>
<body>

    <h2>Your Order History</h2>

    <?php
    if (mysqli_num_rows($order_result) == 0) {
        echo "<p>You have no orders yet.</p>";
    } else {
        echo "<table>
                <tr>
                    <th>Customer Name</th>
                    <th>Order Date</th>
                    <th>Item Name</th>
                    <th>Total Price</th>
                    <th>Status</th>
                </tr>";
        
        while ($order = mysqli_fetch_assoc($order_result)) {
            echo "<tr>
                    <td>" . $order['customer_name'] . "</td>
                    <td>" . $order['order_date'] . "</td>
                    <td>" . $order['item_name'] . "</td>
                    <td>৳" . $order['total_price'] . "</td>
                    <td>" . $order['status'] . "</td>
                </tr>";
        }
        
        echo "</table>";
    }
    ?>

    <a href="customer_dashboard.php">⬅ Go Back</a>
</body>
</html>
