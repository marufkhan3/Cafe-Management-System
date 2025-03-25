<?php
session_start();
include('../db_connect.php');

// Check if admin is logged in
if (!isset($_SESSION['admin_email'])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch the total number of orders placed
$order_count_query = "SELECT COUNT(*) AS total_orders FROM orders";
$order_count_result = mysqli_query($connection, $order_count_query);
$order_count_row = mysqli_fetch_assoc($order_count_result);
$total_orders = $order_count_row['total_orders'];

// Fetch all orders with customer name
$order_query = "SELECT orders.*, customers.name AS customer_name
                FROM orders
                JOIN customers ON orders.customer_id = customers.id";
$order_result = mysqli_query($connection, $order_query);

// Delete order functionality
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_query = "DELETE FROM orders WHERE id = $delete_id";
    mysqli_query($connection, $delete_query);
    header("Location: manage_orders.php"); // Refresh the page after deletion
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manage Orders</title>
</head>
<body>
    <h2>Admin - Manage Orders</h2>

    <h3>Total Orders Placed: <?php echo $total_orders; ?></h3>

    <hr>

    <h3>Order List</h3>
    <table border="1">
        <tr>
            <th>Order ID</th>
            <th>Customer Name</th>
            <th>Order Date</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($order_result)) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['customer_name']; ?></td> <!-- Display customer name -->
                <td><?php echo $row['order_date']; ?></td>
                <td><?php echo $row['status']; ?></td>
                <td>
                    <a href="?delete_id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this order?')">Delete</a>
                </td>
            </tr>
        <?php } ?>
    </table>

    <hr>
    <a href="admin_dashboard.php">
        <button>Go Back</button>
    </a>

</body>
</html>
