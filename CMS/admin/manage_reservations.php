<?php
session_start();
include('../db_connect.php');

// Check if admin is logged in
if (!isset($_SESSION['admin_email'])) {
    header("Location: admin_login.php");
    exit();
}

// Fetch all reservations
$reservation_query = "SELECT * FROM reservations";
$reservation_result = mysqli_query($connection, $reservation_query);

// Add new reservation
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_reservation'])) {
    $customer_id = $_POST['customer_id'];
    $reservation_date = $_POST['reservation_date'];
    $status = $_POST['status'];

    $insert_query = "INSERT INTO reservations (customer_id, reservation_date, status) VALUES ('$customer_id', '$reservation_date', '$status')";
    mysqli_query($connection, $insert_query);
    header("Location: manage_reservations.php"); // Refresh the page
    exit();
}

// Delete reservation
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_query = "DELETE FROM reservations WHERE id = $delete_id";
    mysqli_query($connection, $delete_query);
    header("Location: manage_reservations.php"); // Refresh the page
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Reservations</title>
</head>
<body>
    <h2>Manage Reservations</h2>

    <hr>

    <!-- Form to Add New Reservation -->
    <h3>Add New Reservation</h3>
    <form action="" method="POST">
        Customer ID: <input type="number" name="customer_id" required><br><br>
        Reservation Date: <input type="datetime-local" name="reservation_date" required><br><br>
        Status:
        <select name="status">
            <option value="Pending">Pending</option>
            <option value="Confirmed">Confirmed</option>
            <option value="Cancelled">Cancelled</option>
        </select><br><br>
        <input type="submit" name="add_reservation" value="Add Reservation">
    </form>

    <hr>

    <h3>Reservation List</h3>
    <table border="1">
        <tr>
            <th>Reservation ID</th>
            <th>Customer ID</th>
            <th>Reservation Date</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($reservation_result)) { ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo $row['customer_id']; ?></td>
                <td><?php echo $row['reservation_date']; ?></td>
                <td><?php echo $row['status']; ?></td>
                <td>
                    <a href="?delete_id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this reservation?')">Delete</a>
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
