<?php
session_start();
include('../db_connect.php');

// Fetch menu items
$menu_query = "SELECT * FROM menu";
$menu_result = mysqli_query($connection, $menu_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
</head>
<body>
    <h2>Menu</h2>
    <?php if (mysqli_num_rows($menu_result) > 0) { ?>
        <table border="1">
            <tr>
                <th>Item ID</th>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Description</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($menu_result)) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo isset($row['item_name']) ? $row['item_name'] : 'N/A'; ?></td>
                    <td><?php echo isset($row['category']) ? $row['category'] : 'N/A'; ?></td>
                    <td>৳<?php echo isset($row['price']) ? number_format($row['price'], 2) : '0.00'; ?></td>
                    <td><?php echo isset($row['description']) ? $row['description'] : 'No description'; ?></td>
                </tr>
            <?php } ?>
        </table>
    <?php } else { ?>
        <p>No menu items available.</p>
    <?php } ?>

    <hr>
    <a href="customer_dashboard.php">
        <button>Go Back</button>
    </a>
</body>
</html>
