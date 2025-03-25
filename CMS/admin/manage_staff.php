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
</head>
<body>
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
    <table border="1">
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
</body>
</html>
