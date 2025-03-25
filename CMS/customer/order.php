<?php
session_start();
include('../db_connect.php'); // Include your database connection

// Check if customer is logged in
if (!isset($_SESSION['customer_id'])) {
    header("Location: customer_login.php"); // Redirect to login if not logged in
    exit();
}

$customer_id = $_SESSION['customer_id']; // Get logged-in customer's ID

// Handle order submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['item_id'])) {
    $item_id = $_POST['item_id']; // Get item ID
    $quantity = $_POST['quantity'];

    // Get item details (price and name) from the menu
    $item_query = "SELECT item_name, price FROM menu WHERE id='$item_id'";
    $item_result = mysqli_query($connection, $item_query);
    $item_row = mysqli_fetch_assoc($item_result);
    $item_name = $item_row['item_name'];
    $item_price = $item_row['price'];

    // Calculate total price
    $total_price = $item_price * $quantity;

    // Insert order into database
    $order_query = "INSERT INTO orders (customer_id, item_id, item_name, quantity, total_price, order_date, status) 
                    VALUES ('$customer_id', '$item_id', '$item_name', '$quantity', '$total_price', NOW(), 'Pending')";

    if (mysqli_query($connection, $order_query)) {
        echo "<p style='color: green;'>Order placed successfully!</p>";
    } else {
        echo "<p style='color: red;'>Error: " . mysqli_error($connection) . "</p>";
    }
}

// Cancel order logic
if (isset($_GET['cancel_order_id'])) {
    $order_id = $_GET['cancel_order_id'];

    // Update the order status to 'Cancelled'
    $cancel_query = "UPDATE orders SET status='Cancelled' WHERE id='$order_id' AND customer_id='$customer_id'";

    if (mysqli_query($connection, $cancel_query)) {
        echo "<p style='color: green;'>Order cancelled successfully!</p>";
    } else {
        echo "<p style='color: red;'>Error: " . mysqli_error($connection) . "</p>";
    }
}

// Complete order logic (only for orders that are pending)
if (isset($_GET['complete_order_id'])) {
    $order_id = $_GET['complete_order_id'];

    // Update the order status to 'Completed'
    $complete_query = "UPDATE orders SET status='Completed' WHERE id='$order_id' AND customer_id='$customer_id'";

    if (mysqli_query($connection, $complete_query)) {
        echo "<p style='color: green;'>Order marked as completed!</p>";
    } else {
        echo "<p style='color: red;'>Error: " . mysqli_error($connection) . "</p>";
    }
}

// Fetch menu items
$menu_query = "SELECT * FROM menu";
$menu_result = mysqli_query($connection, $menu_query);

// Fetch existing orders for the customer, along with the customer name
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

    <br>
    <h3>Your Orders</h3>
    <?php
    if (mysqli_num_rows($order_result) > 0) {
        echo "<table border='1'>
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
            echo "<td>" . $order['customer_name'] . "</td>"; // Display customer name
            echo "<td>" . $order['item_name'] . "</td>";
            echo "<td>" . $order['quantity'] . "</td>";
            echo "<td>৳" . $order['total_price'] . "</td>";
            echo "<td>" . $order['status'] . "</td>";

            // Show cancel button only for pending orders
            if ($order['status'] == 'Pending') {
                echo "<td>
                        <a href='order.php?cancel_order_id=" . $order['id'] . "'>Cancel Order</a> | 
                        <a href='order.php?complete_order_id=" . $order['id'] . "'>Complete Order</a>
                    </td>";
            } else {
                echo "<td>Order " . $order['status'] . "</td>";
            }

            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No orders found.</p>";
    }
    ?>

    <br>
    <a href="customer_dashboard.php">Go Back</a>
</body>
</html>
