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
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Manage Orders</h1>
            <p>Total Orders Placed: <span class="total-orders"><?php echo $total_orders; ?></span></p>
        </header>

        <hr>

        <section class="orders-section">
            <h3>Order List</h3>
            <table class="orders-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer Name</th>
                        <th>Order Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($order_result)) { ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['customer_name']; ?></td> <!-- Display customer name -->
                            <td><?php echo $row['order_date']; ?></td>
                            <td><?php echo $row['status']; ?></td>
                            <td>
                                <a href="?delete_id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this order?')" class="delete-btn">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </section>

        <hr>

        <footer>
            <a href="admin_dashboard.php" class="go-back-btn">Go Back</a>
        </footer>
    </div>
</body>
</html>

<!-- Add a CSS file for better styling -->

<style>
    body {
        font-family: 'Arial', sans-serif;
        background-color: #f4f7fc;
        margin: 0;
        padding: 0;
    }

    .container {
        width: 80%;
        margin: 0 auto;
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    header {
        text-align: center;
        margin-bottom: 20px;
    }

    header h1 {
        font-size: 2rem;
        color: #333;
    }

    .total-orders {
        font-weight: bold;
        color: #007bff;
    }

    hr {
        margin: 20px 0;
        border: 1px solid #ccc;
    }

    .orders-section h3 {
        font-size: 1.5rem;
        margin-bottom: 10px;
    }

    .orders-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }

    .orders-table th, .orders-table td {
        padding: 10px;
        text-align: left;
        border: 1px solid #ddd;
    }

    .orders-table th {
        background-color: #f1f1f1;
    }

    .delete-btn {
        color: #dc3545;
        text-decoration: none;
        font-weight: bold;
    }

    .delete-btn:hover {
        color: #c82333;
    }

    .go-back-btn {
        display: inline-block;
        padding: 10px 20px;
        background-color: #007bff;
        color: white;
        text-decoration: none;
        border-radius: 4px;
        font-weight: bold;
    }

    .go-back-btn:hover {
        background-color: #0056b3;
    }

    footer {
        text-align: center;
        margin-top: 30px;
    }

    @media (max-width: 768px) {
        .container {
            width: 90%;
        }

        .orders-table th, .orders-table td {
            font-size: 14px;
            padding: 8px;
        }

        header h1 {
            font-size: 1.5rem;
        }
    }
</style>
