<?php
session_start();
include('../db_connect.php');

// Check if admin is logged in
if (!isset($_SESSION['admin_email'])) {
    header("Location: admin_login.php");
    exit();
}

// Default dates (can be changed based on the selected period)
$start_date = date('Y-m-01');  // First day of the current month
$end_date = date('Y-m-d');      // Today's date

// If a date range is selected
if (isset($_POST['start_date']) && isset($_POST['end_date'])) {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
}

// Fetch total sales
$sales_query = "SELECT SUM(orders.total_price) AS total_sales
                FROM orders 
                WHERE order_date BETWEEN '$start_date' AND '$end_date'";

$sales_result = mysqli_query($connection, $sales_query);
$sales_data = mysqli_fetch_assoc($sales_result);
$total_sales = $sales_data['total_sales'];

// Fetch total orders
$order_count_query = "SELECT COUNT(*) AS total_orders 
                      FROM orders 
                      WHERE order_date BETWEEN '$start_date' AND '$end_date'";

$order_count_result = mysqli_query($connection, $order_count_query);
$order_count_row = mysqli_fetch_assoc($order_count_result);
$total_orders = $order_count_row['total_orders'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Report</title>
</head>
<body>
    <h2>Sales Report</h2>

    <!-- Date Filter Form -->
    <form action="sales_report.php" method="POST">
        Start Date: <input type="date" name="start_date" value="<?php echo $start_date; ?>" required>
        End Date: <input type="date" name="end_date" value="<?php echo $end_date; ?>" required>
        <input type="submit" value="Generate Report">
    </form>

    <hr>

    <!-- Display Report -->
    <h3>Total Sales from <?php echo $start_date; ?> to <?php echo $end_date; ?>:</h3>
    <p>Total Orders: <?php echo $total_orders; ?></p>
    <p>Total Sales: ৳<?php echo number_format($total_sales, 2); ?></p>

    <hr>

    <!-- Sales Details (optional) -->
    <h3>Sales Details</h3>
    <table border="1">
        <tr>
            <th>Order ID</th>
            <th>Customer ID</th>
            <th>Order Date</th>
            <th>Total Price</th>
        </tr>
        <?php
        // Fetch sales details for the selected period
        $sales_details_query = "SELECT * FROM orders 
                                WHERE order_date BETWEEN '$start_date' AND '$end_date'";

        $sales_details_result = mysqli_query($connection, $sales_details_query);
        while ($row = mysqli_fetch_assoc($sales_details_result)) {
            echo "<tr>
                    <td>{$row['id']}</td>
                    <td>{$row['customer_id']}</td>
                    <td>{$row['order_date']}</td>
                    <td>৳{$row['total_price']}</td>
                </tr>";
        }
        ?>
    </table>

    <!-- Go Back Button -->
    <hr>
    <a href="admin_dashboard.php">
        <button>Go Back to Dashboard</button>
    </a>
</body>
</html>
