<?php
session_start();
include('../db_connect.php');

// Check if customer is logged in
if (!isset($_SESSION['customer_id'])) {
    header("Location: customer_login.php");
    exit();
}

$customer_id = $_SESSION['customer_id']; // Get logged-in customer ID

// Handle reservation submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reservation_date'])) {
    $reservation_date = $_POST['reservation_date'];

    // Insert reservation into the database
    $reservation_query = "INSERT INTO reservations (customer_id, reservation_date, status) 
                          VALUES ('$customer_id', '$reservation_date', 'Pending')";

    if (mysqli_query($connection, $reservation_query)) {
        echo "<p style='color: green;'>Reservation made successfully!</p>";
    } else {
        echo "<p style='color: red;'>Error: " . mysqli_error($connection) . "</p>";
    }
}

// Fetch customer's reservations
$reservation_query = "SELECT * FROM reservations WHERE customer_id='$customer_id'";
$reservation_result = mysqli_query($connection, $reservation_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserve a Table</title>
</head>
<body>
    <h2>Make a Reservation</h2>

    <form action="reservation.php" method="POST">
        <label for="reservation_date">Select Reservation Date and Time:</label>
        <input type="datetime-local" name="reservation_date" required>

        <input type="submit" value="Book Reservation">
    </form>

    <br>
    <h3>Your Reservations</h3>
    <?php
    if (mysqli_num_rows($reservation_result) > 0) {
        echo "<table border='1'>";
        echo "<tr><th>Reservation Date</th><th>Status</th><th>Action</th></tr>";

        while ($reservation = mysqli_fetch_assoc($reservation_result)) {
            echo "<tr>";
            echo "<td>" . $reservation['reservation_date'] . "</td>";
            echo "<td>" . $reservation['status'] . "</td>";
            echo "<td>";

            // Display cancel button if the reservation is 'Pending'
            if ($reservation['status'] == 'Pending') {
                echo "<a href='cancel_reservation.php?id=" . $reservation['id'] . "'>Cancel</a>";
            }

            echo "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<p>No reservations found.</p>";
    }
    ?>

    <br>
    <a href="customer_dashboard.php">Go Back</a>
</body>
</html>
