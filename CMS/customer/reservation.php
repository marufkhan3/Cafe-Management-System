<?php
session_start();
include('../db_connect.php');

if (!isset($_SESSION['customer_id'])) {
    header("Location: customer_login.php");
    exit();
}

$customer_id = $_SESSION['customer_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['reservation_date'])) {
    $reservation_date = $_POST['reservation_date'];

    $reservation_query = "INSERT INTO reservations (customer_id, reservation_date, status) 
                          VALUES ('$customer_id', '$reservation_date', 'Pending')";

    if (mysqli_query($connection, $reservation_query)) {
        echo "<p style='color: green; text-align:center;'>Reservation made successfully!</p>";
    } else {
        echo "<p style='color: red; text-align:center;'>Error: " . mysqli_error($connection) . "</p>";
    }
}

// Confirm reservation
if (isset($_GET['confirm_id'])) {
    $confirm_id = $_GET['confirm_id'];
    $confirm_query = "UPDATE reservations SET status='Confirmed' 
                      WHERE id='$confirm_id' AND customer_id='$customer_id' AND status='Pending'";
    mysqli_query($connection, $confirm_query);
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
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h2, h3 {
            text-align: center;
            color: #333;
        }

        form {
            background: #fff;
            max-width: 500px;
            margin: 0 auto 30px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input[type="datetime-local"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            margin: 0 auto;
            box-shadow: 0 0 8px rgba(0,0,0,0.1);
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: center;
        }

        th {
            background-color: #007bff;
            color: white;
        }

        a.button-link {
            text-decoration: none;
            padding: 6px 12px;
            background-color: #28a745;
            color: white;
            border-radius: 4px;
            margin-right: 5px;
        }

        a.button-link:hover {
            background-color: #218838;
        }

        a.cancel-link {
            background-color: #dc3545;
        }

        a.cancel-link:hover {
            background-color: #c82333;
        }

        a.back-button {
            display: block;
            text-align: center;
            background-color: #555;
            color: white;
            width: max-content;
            padding: 10px 20px;
            margin: 30px auto 0;
            border-radius: 5px;
            text-decoration: none;
        }

        a.back-button:hover {
            background-color: #333;
        }
    </style>
</head>
<body>

    <h2>Make a Reservation</h2>

    <form action="reservation.php" method="POST">
        <label for="reservation_date">Select Reservation Date and Time:</label>
        <input type="datetime-local" name="reservation_date" required>
        <input type="submit" value="Book Reservation">
    </form>

    <h3>Your Reservations</h3>
    <?php
    if (mysqli_num_rows($reservation_result) > 0) {
        echo "<table>";
        echo "<tr><th>Reservation Date</th><th>Status</th><th>Action</th></tr>";

        while ($reservation = mysqli_fetch_assoc($reservation_result)) {
            echo "<tr>";
            echo "<td>" . $reservation['reservation_date'] . "</td>";
            echo "<td>" . $reservation['status'] . "</td>";
            echo "<td>";

            if ($reservation['status'] == 'Pending') {
                echo "<a href='reservation.php?confirm_id=" . $reservation['id'] . "' class='button-link'>Confirm</a>";
                echo "<a href='cancel_reservation.php?id=" . $reservation['id'] . "' class='button-link cancel-link'>Cancel</a>";
            } else {
                echo "No actions available";
            }

            echo "</td>";
            echo "</tr>";
        }

        echo "</table>";
    } else {
        echo "<p style='text-align:center;'>No reservations found.</p>";
    }
    ?>

    <a href="customer_dashboard.php" class="back-button">⬅ Go Back</a>
</body>
</html>
