<?php
session_start();
include('../db_connect.php');

// Check if the customer is logged in
if (!isset($_SESSION['customer_email'])) {
    header("Location: customer_login.php"); // Redirect to login if not logged in
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>
</head>
<body>
    <h1>Welcome, <?php echo $_SESSION['customer_name']; ?>!</h1>
    <nav>
        <ul>
            <li><a href="menu.php">View Menu</a></li>
            <li><a href="order.php">Place Order</a></li>
            <li><a href="reservation.php">Make a Reservation</a></li>
            <li><a href="order_history.php">Order History</a></li>
            <li><a href="logout.php"><button>Logout</button></a>
</li>
        </ul>
    </nav>
</body>
</html>
