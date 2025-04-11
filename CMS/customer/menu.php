<?php
session_start();
include('../db_connect.php');

// Handle search
$search = "";
if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($connection, $_GET['search']);
    $menu_query = "SELECT * FROM menu WHERE item_name LIKE '%$search%' OR category LIKE '%$search%'";
} else {
    $menu_query = "SELECT * FROM menu";
}

$menu_result = mysqli_query($connection, $menu_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        form {
            text-align: center;
            margin-bottom: 20px;
        }

        input[type="text"] {
            padding: 10px;
            width: 300px;
            border: 1px solid #aaa;
            border-radius: 4px;
        }

        input[type="submit"] {
            padding: 10px 20px;
            background-color: #0066cc;
            border: none;
            color: white;
            cursor: pointer;
            border-radius: 4px;
        }

        input[type="submit"]:hover {
            background-color: #004999;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background-color: #0077cc;
            color: white;
        }

        a button {
            padding: 10px 20px;
            margin-top: 30px;
            display: block;
            margin-left: auto;
            margin-right: auto;
            background-color: #555;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        a button:hover {
            background-color: #333;
        }

        .no-items {
            text-align: center;
            color: #999;
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <h2>🍽️ Cafe Menu</h2>

    <!-- Search Form -->
    <form method="GET" action="">
        <input type="text" name="search" placeholder="Search by item or category..." value="<?php echo htmlspecialchars($search); ?>">
        <input type="submit" value="Search">
    </form>

    <?php if (mysqli_num_rows($menu_result) > 0) { ?>
        <table>
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
                    <td><?php echo $row['item_name'] ?? 'N/A'; ?></td>
                    <td><?php echo $row['category'] ?? 'N/A'; ?></td>
                    <td>৳<?php echo number_format($row['price'] ?? 0, 2); ?></td>
                    <td><?php echo $row['description'] ?? 'No description'; ?></td>
                </tr>
            <?php } ?>
        </table>
    <?php } else { ?>
        <p class="no-items">No menu items found for "<strong><?php echo htmlspecialchars($search); ?></strong>".</p>
    <?php } ?>

    <a href="customer_dashboard.php">
        <button>⬅ Go Back to Dashboard</button>
    </a>
</body>
</html>
