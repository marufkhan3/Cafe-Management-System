<?php
session_start();
include('../db_connect.php');

// Check if admin is logged in
if (!isset($_SESSION['admin_email'])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch staff data
$query = "SELECT * FROM staff";
$result = mysqli_query($connection, $query);

// Add new staff (Recruitment)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_staff'])) {
    $name = mysqli_real_escape_string($connection, $_POST['name']);
    $role = mysqli_real_escape_string($connection, $_POST['role']);

    if (!empty($name) && !empty($role)) {
        $insert_query = "INSERT INTO staff (name, role) VALUES ('$name', '$role')";
        if (mysqli_query($connection, $insert_query)) {
            header("Location: manage_staff.php"); // Refresh page after adding
            exit();
        } else {
            echo "Error: " . mysqli_error($connection);
        }
    } else {
        echo "Please fill in all fields.";
    }
}

// Remove staff
if (isset($_GET['remove_staff'])) {
    $staff_id = $_GET['remove_staff'];
    $query = "DELETE FROM staff WHERE id='$staff_id'";
    if (mysqli_query($connection, $query)) {
        header("Location: manage_staff.php"); // Refresh page after deletion
        exit();
    } else {
        echo "Error: " . mysqli_error($connection);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Staff</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 900px;
            margin: 40px auto;
            background-color: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        h1, h3 {
            color: #333;
        }

        form input[type="text"],
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

        a button, a[href] {
            text-decoration: none;
        }

        a button,
        a[href^="?remove_staff"] {
            background-color: #007bff;
            color: white !important;
            padding: 8px 14px;
            font-size: 14px;
            border: none;
            border-radius: 5px;
            display: inline-block;
            cursor: pointer;
        }

        a button:hover,
        a[href^="?remove_staff"]:hover {
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
        <h1>Manage Staff</h1>

        <!-- Add New Staff -->
        <h3>Recruit New Staff</h3>
        <form action="" method="POST">
            Name: <input type="text" name="name" required><br><br>
            Role: <input type="text" name="role" required><br><br>
            <input type="submit" name="add_staff" value="Add Staff">
        </form>

        <hr>

        <!-- Staff List -->
        <h3>Staff List</h3>
        <table>
            <tr>
                <th>Staff ID</th>
                <th>Name</th>
                <th>Role</th>
                <th>Action</th>
            </tr>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['name']; ?></td>
                    <td><?php echo $row['role']; ?></td>
                    <td>
                        <a href="?remove_staff=<?php echo $row['id']; ?>" 
                           onclick="return confirm('Are you sure you want to remove this staff member?')">
                            Remove
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </table>

        <hr>
        <a href="admin_dashboard.php">
            <button>Go Back</button>
        </a>
    </div>
</body>
</html>
