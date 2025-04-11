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
    <link rel="stylesheet" href="../bootstrap-4.4.1/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', sans-serif;
        }

        .navbar {
            background-color: #007bff;
        }

        .navbar-brand, .navbar-nav .nav-link {
            color: white !important;
        }

        .navbar-nav .nav-link:hover {
            color: #d1e7ff !important;
        }

        .dashboard-container {
            max-width: 900px;
            margin: 40px auto;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #343a40;
        }

        h3 {
            margin-bottom: 20px;
            color: #007bff;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .btn-primary {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border-radius: 5px;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        table th, table td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #007bff;
            color: white;
        }

        table tr:hover {
            background-color: #f1f1f1;
        }

        .card-footer {
            background-color: #f1f1f1;
            text-align: right;
        }

        .btn-logout {
            padding: 10px 20px;
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 5px;
            text-align: center;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-logout:hover {
            background-color: #c82333;
        }

        .nav-links {
            text-align: center;
            margin-top: 15px;
        }

        .nav-links button {
            width: 100%;
            padding: 12px;
            background-color: #dc3545;
            color: white;
            border-radius: 5px;
        }

        .nav-links button:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg">
        <a class="navbar-brand" href="admin_dashboard.php">Cafe Management System</a>
    </nav>

    <div class="dashboard-container">

        <h2>Manage Menu</h2>

        <!-- Form to Add New Item -->
        <h3>Add New Item</h3>
        <form action="" method="POST">
            <div class="form-group">
                <label for="item_name">Item Name:</label>
                <input type="text" name="item_name" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="price">Price:</label>
                <input type="text" name="price" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="category">Category:</label>
                <select name="category" class="form-control" required>
                    <option value="Coffee">Coffee</option>
                    <option value="Tea">Tea</option>
                    <option value="Pastry">Pastry</option>
                    <option value="Dessert">Dessert</option>
                    <option value="Juice">Juice</option>
                    <option value="Snack">Snack</option>
                </select>
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea name="description" class="form-control" required></textarea>
            </div>

            <input type="submit" name="add_item" value="Add Item" class="btn btn-primary">
        </form>

        <hr>

        <!-- Form to Edit Existing Item -->
        <?php if (isset($edit_row)) { ?>
        <h3>Edit Item</h3>
        <form action="" method="POST">
            <div class="form-group">
                <label for="item_name">Item Name:</label>
                <input type="text" name="item_name" class="form-control" value="<?php echo $edit_row['item_name']; ?>" required>
            </div>

            <div class="form-group">
                <label for="price">Price:</label>
                <input type="text" name="price" class="form-control" value="<?php echo $edit_row['price']; ?>" required>
            </div>

            <div class="form-group">
                <label for="category">Category:</label>
                <select name="category" class="form-control" required>
                    <option value="Coffee" <?php if ($edit_row['category'] == 'Coffee') echo 'selected'; ?>>Coffee</option>
                    <option value="Tea" <?php if ($edit_row['category'] == 'Tea') echo 'selected'; ?>>Tea</option>
                    <option value="Pastry" <?php if ($edit_row['category'] == 'Pastry') echo 'selected'; ?>>Pastry</option>
                    <option value="Dessert" <?php if ($edit_row['category'] == 'Dessert') echo 'selected'; ?>>Dessert</option>
                    <option value="Juice" <?php if ($edit_row['category'] == 'Juice') echo 'selected'; ?>>Juice</option>
                    <option value="Snack" <?php if ($edit_row['category'] == 'Snack') echo 'selected'; ?>>Snack</option>
                </select>
            </div>

            <div class="form-group">
                <label for="description">Description:</label>
                <textarea name="description" class="form-control" required><?php echo $edit_row['description']; ?></textarea>
            </div>

            <input type="hidden" name="item_id" value="<?php echo $edit_row['id']; ?>">
            <input type="submit" name="update_item" value="Update Item" class="btn btn-primary">
        </form>
        <?php } ?>

        <hr>

        <!-- Display Menu Items -->
        <h3>Menu Items</h3>
        <table>
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
        <div class="nav-links">
            <a href="admin_dashboard.php"><button class="btn btn-outline-secondary btn-sm">← Go Back</button></a>
        </div>

    </div>

</body>
</html>
