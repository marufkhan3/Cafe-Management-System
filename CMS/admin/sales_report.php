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
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }

        h2, h3 {
            color: #333;
        }

        .container {
            max-width: 900px;
            margin: 40px auto;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        form {
            margin-bottom: 30px;
        }

        form input[type="date"],
        form input[type="submit"] {
            padding: 10px;
            margin: 5px 10px 15px 0;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        form input[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }

        form input[type="submit"]:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: center;
        }

        table th {
            background-color: #f0f0f0;
            color: #333;
        }

        p {
            font-size: 18px;
            color: #444;
        }

        a button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        a button:hover {
            background-color: #0056b3;
        }

        hr {
            margin: 30px 0;
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <div class="container">
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
        <table>
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
        <a href="admin_dashboard.php">
            <button>Go Back to Dashboard</button>
        </a>
    </div>
</body>
</html>
