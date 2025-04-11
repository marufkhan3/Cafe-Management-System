<?php
session_start();
include('../db_connect.php');

// Check if customer is logged in
if (!isset($_SESSION['customer_id'])) {
    header("Location: customer_login.php");
    exit();
}

$customer_id = $_SESSION['customer_id']; // Get logged-in customer ID

// Check if reservation ID is passed and cancel the reservation
if (isset($_GET['id'])) {
    $reservation_id = $_GET['id'];

    // Cancel the reservation (only if it's in 'Pending' status)
    $cancel_query = "UPDATE reservations SET status='Cancelled' WHERE id='$reservation_id' AND customer_id='$customer_id' AND status='Pending'";

    if (mysqli_query($connection, $cancel_query)) {
        echo "<p style='color: green;'>Reservation cancelled successfully!</p>";
    } else {
        echo "<p style='color: red;'>Error: " . mysqli_error($connection) . "</p>";
    }
}

echo "<a href='reservation.php'>Back to Reservations</a>";
?>
