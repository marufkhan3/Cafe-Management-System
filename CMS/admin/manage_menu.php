<?php
session_start();
include('../db_connect.php');

// Check if admin is logged in
if (!isset($_SESSION['admin_email'])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch menu items from database
$menu_query = "SELECT * FROM menu";
$menu_result = mysqli_query($connection, $menu_query);

// Add new menu item
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_item'])) {
    $item_name = $_POST['item_name'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $description = $_POST['description'];

    $insert_query = "INSERT INTO menu (item_name, price, category, description) VALUES ('$item_name', '$price', '$category', '$description')";
    mysqli_query($connection, $insert_query);
    header("Location: manage_menu.php"); // Refresh the page to see new item
}

// Delete menu item
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_query = "DELETE FROM menu WHERE id = $delete_id";
    mysqli_query($connection, $delete_query);
    header("Location: manage_menu.php"); // Refresh the page to reflect the deletion
}

// Edit menu item
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
    $edit_query = "SELECT * FROM menu WHERE id = $edit_id";
    $edit_result = mysqli_query($connection, $edit_query);
    $edit_row = mysqli_fetch_assoc($edit_result);
}

// Update menu item
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_item'])) {
    $item_id = $_POST['item_id'];
    $item_name = $_POST['item_name'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $description = $_POST['description'];

    $update_query = "UPDATE menu SET item_name = '$item_name', price = '$price', category = '$category', description = '$description' WHERE id = $item_id";
    mysqli_query($connection, $update_query);
    header("Location: manage_menu.php"); // Refresh the page to see the update
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Menu</title>
</head>
<body>
    <h2>Manage Menu</h2>

    <!-- Form to Add New Item -->
    <h3>Add New Item</h3>
    <form action="" method="POST">
        Item Name: <input type="text" name="item_name" required><br><br>
        Price: <input type="text" name="price" required><br><br>
        Category: 
        <select name="category">
            <option value="Coffee">Coffee</option>
            <option value="Tea">Tea</option>
            <option value="Pastry">Pastry</option>
            <option value="Dessert">Dessert</option>
            <option value="Juice">Juice</option>
            <option value="Snack">Snack</option>
        </select><br><br>
        Description: <textarea name="description" required></textarea><br><br>
        <input type="submit" name="add_item" value="Add Item">
    </form>

    <hr>

    <!-- Form to Edit Existing Item -->
    <?php if (isset($edit_row)) { ?>
    <h3>Edit Item</h3>
    <form action="" method="POST">
        Item Name: <input type="text" name="item_name" value="<?php echo $edit_row['item_name']; ?>" required><br><br>
        Price: <input type="text" name="price" value="<?php echo $edit_row['price']; ?>" required><br><br>
        Category: 
        <select name="category">
            <option value="Coffee" <?php if ($edit_row['category'] == 'Coffee') echo 'selected'; ?>>Coffee</option>
            <option value="Tea" <?php if ($edit_row['category'] == 'Tea') echo 'selected'; ?>>Tea</option>
            <option value="Pastry" <?php if ($edit_row['category'] == 'Pastry') echo 'selected'; ?>>Pastry</option>
            <option value="Dessert" <?php if ($edit_row['category'] == 'Dessert') echo 'selected'; ?>>Dessert</option>
            <option value="Juice" <?php if ($edit_row['category'] == 'Juice') echo 'selected'; ?>>Juice</option>
            <option value="Snack" <?php if ($edit_row['category'] == 'Snack') echo 'selected'; ?>>Snack</option>
        </select><br><br>
        Description: <textarea name="description" required><?php echo $edit_row['description']; ?></textarea><br><br>
        <input type="hidden" name="item_id" value="<?php echo $edit_row['id']; ?>">
        <input type="submit" name="update_item" value="Update Item">
    </form>
    <?php } ?>

    <hr>

    <!-- Display Menu Items -->
    <h3>Menu Items</h3>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Item Name</th>
            <th>Price</th>
            <th>Category</th>
            <th>Description</th>
            <th>Action</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($menu_result)) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['item_name']; ?></td>
                <td>৳<?php echo $row['price']; ?></td>
                <td><?php echo $row['category']; ?></td>
                <td><?php echo $row['description']; ?></td>
                <td>
                    <a href="?edit_id=<?php echo $row['id']; ?>">Edit</a> |
                    <a href="?delete_id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this item?')">Delete</a>
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
