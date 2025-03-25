<?php
session_start();
include('../db_connect.php'); // Include your database connection

// Check if customer is logged in
if (!isset($_SESSION['customer_id'])) {
    header("Location: customer_login.php"); // Redirect to login if not logged in
    exit();
}

$customer_id = $_SESSION['customer_id']; // Get logged-in customer's ID

// Fetch order history for the logged-in customer with their name
$order_query = "SELECT orders.*, customers.name AS customer_name 
                FROM orders 
                JOIN customers ON orders.customer_id = customers.id 
                WHERE orders.customer_id='$customer_id' 
                ORDER BY order_date DESC"; // Get orders by customer_id, sorted by date
$order_result = mysqli_query($connection, $order_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
</head>
<body>
    <h2>Your Order History</h2>

    <?php
    // If there are no orders, show a message
    if (mysqli_num_rows($order_result) == 0) {
        echo "<p>You have no orders yet.</p>";
    } else {
        // Display the orders in a simple table
        echo "<table border='1'>
                <tr>
                    <th>Customer Name</th>
                    <th>Order Date</th>
                    <th>Item Name</th>
                    <th>Total Price</th>
                    <th>Status</th>
                </tr>";
        
        // Loop through all the orders for the customer
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

    <br>
    <a href="customer_dashboard.php">Go Back</a> <!-- Link to go back to the dashboard -->
</body>
</html>
