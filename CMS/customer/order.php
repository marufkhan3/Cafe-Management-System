<?php
session_start();
include('../db_connect.php');

// Check if customer is logged in
if (!isset($_SESSION['customer_id'])) {
    header("Location: customer_login.php");
    exit();
}

$customer_id = $_SESSION['customer_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['item_id'])) {
    $item_id = $_POST['item_id'];
    $quantity = $_POST['quantity'];

    $item_query = "SELECT item_name, price FROM menu WHERE id='$item_id'";
    $item_result = mysqli_query($connection, $item_query);
    $item_row = mysqli_fetch_assoc($item_result);
    $item_name = $item_row['item_name'];
    $item_price = $item_row['price'];
    $total_price = $item_price * $quantity;

    $order_query = "INSERT INTO orders (customer_id, item_id, item_name, quantity, total_price, order_date, status) 
                    VALUES ('$customer_id', '$item_id', '$item_name', '$quantity', '$total_price', NOW(), 'Pending')";

    if (mysqli_query($connection, $order_query)) {
        echo "<p style='color: green; text-align:center;'>Order placed successfully!</p>";
    } else {
        echo "<p style='color: red; text-align:center;'>Error: " . mysqli_error($connection) . "</p>";
    }
}

if (isset($_GET['cancel_order_id'])) {
    $order_id = $_GET['cancel_order_id'];
    $cancel_query = "UPDATE orders SET status='Cancelled' WHERE id='$order_id' AND customer_id='$customer_id'";
    if (mysqli_query($connection, $cancel_query)) {
        echo "<p style='color: green; text-align:center;'>Order cancelled successfully!</p>";
    } else {
        echo "<p style='color: red; text-align:center;'>Error: " . mysqli_error($connection) . "</p>";
    }
}

if (isset($_GET['complete_order_id'])) {
    $order_id = $_GET['complete_order_id'];
    $complete_query = "UPDATE orders SET status='Completed' WHERE id='$order_id' AND customer_id='$customer_id'";
    if (mysqli_query($connection, $complete_query)) {
        echo "<p style='color: green; text-align:center;'>Order marked as completed!</p>";
    } else {
        echo "<p style='color: red; text-align:center;'>Error: " . mysqli_error($connection) . "</p>";
    }
}

$menu_query = "SELECT * FROM menu";
$menu_result = mysqli_query($connection, $menu_query);

$order_query = "SELECT orders.*, customers.name AS customer_name FROM orders 
                JOIN customers ON orders.customer_id = customers.id 
                WHERE orders.customer_id='$customer_id'";
$order_result = mysqli_query($connection, $order_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Place Order</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 20px;
        }

        h2, h3 {
            text-align: center;
            color: #333;
        }

        form {
            background: white;
            max-width: 500px;
            margin: 0 auto 30px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        label {
            display: block;
            margin-bottom: 6px;
            font-weight: bold;
        }

        select, input[type="number"], input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        a {
            text-decoration: none;
        }

        a.button {
            display: inline-block;
            background-color: #555;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-align: center;
            margin: 30px auto 0;
            display: block;
            width: max-content;
        }

        a.button:hover {
            background-color: #333;
        }

        .action-links a {
            margin: 0 5px;
            color: #007bff;
        }

        .action-links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <h2>Place an Order</h2>

    <form action="order.php" method="POST">
        <label for="item_id">Select Item:</label>
        <select name="item_id" required>
            <?php while ($row = mysqli_fetch_assoc($menu_result)) { ?>
                <option value="<?php echo $row['id']; ?>">
                    <?php echo $row['item_name'] . " - ৳" . $row['price']; ?>
                </option>
            <?php } ?>
        </select>

        <label for="quantity">Quantity:</label>
        <input type="number" name="quantity" min="1" required>

        <input type="submit" value="Place Order">
    </form>

    <h3>Your Orders</h3>
    <?php
    if (mysqli_num_rows($order_result) > 0) {
        echo "<table>
                <tr>
                    <th>Customer Name</th>
                    <th>Item Name</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>";
        while ($order = mysqli_fetch_assoc($order_result)) {
            echo "<tr>";
            echo "<td>" . $order['customer_name'] . "</td>";
            echo "<td>" . $order['item_name'] . "</td>";
            echo "<td>" . $order['quantity'] . "</td>";
            echo "<td>৳" . $order['total_price'] . "</td>";
            echo "<td>" . $order['status'] . "</td>";

            if ($order['status'] == 'Pending') {
                echo "<td class='action-links'>
                        <a href='order.php?cancel_order_id=" . $order['id'] . "'>Cancel</a> | 
                        <a href='order.php?complete_order_id=" . $order['id'] . "'>Complete</a>
                    </td>";
            } else {
                echo "<td>Order " . $order['status'] . "</td>";
            }

            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p style='text-align:center;'>No orders found.</p>";
    }
    ?>

    <a href="customer_dashboard.php" class="button">⬅ Go Back to Dashboard</a>
</body>
</html>
