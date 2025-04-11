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
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Manage Reservations</h1>
        </header>

        <hr>

        <!-- Form to Add New Reservation -->
        <section class="add-reservation">
            <h3>Add New Reservation</h3>
            <form action="" method="POST">
                <label for="customer_id">Customer ID:</label>
                <input type="number" name="customer_id" id="customer_id" required><br><br>

                <label for="reservation_date">Reservation Date:</label>
                <input type="datetime-local" name="reservation_date" id="reservation_date" required><br><br>

                <label for="status">Status:</label>
                <select name="status" id="status">
                    <option value="Pending">Pending</option>
                    <option value="Confirmed">Confirmed</option>
                    <option value="Cancelled">Cancelled</option>
                </select><br><br>

                <input type="submit" name="add_reservation" value="Add Reservation" class="btn add-btn">
            </form>
        </section>

        <hr>

        <!-- Reservation List -->
        <section class="reservation-list">
            <h3>Reservation List</h3>
            <table class="reservation-table">
                <thead>
                    <tr>
                        <th>Reservation ID</th>
                        <th>Customer ID</th>
                        <th>Reservation Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($reservation_result)) { ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['customer_id']; ?></td>
                            <td><?php echo $row['reservation_date']; ?></td>
                            <td><?php echo $row['status']; ?></td>
                            <td>
                                <a href="?delete_id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this reservation?')" class="btn delete-btn">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </section>

        <hr>

        <!-- Go Back Button -->
        <footer>
            <a href="admin_dashboard.php" class="btn go-back-btn">Go Back</a>
        </footer>
    </div>

    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 80%;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        header {
            text-align: center;
            margin-bottom: 20px;
        }

        header h1 {
            font-size: 2rem;
            color: #333;
        }

        hr {
            margin: 20px 0;
            border: 1px solid #ccc;
        }

        section h3 {
            font-size: 1.5rem;
            margin-bottom: 10px;
        }

        .add-reservation label {
            font-weight: bold;
        }

        .add-reservation input, .add-reservation select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
        }

        .reservation-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .reservation-table th, .reservation-table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }

        .reservation-table th {
            background-color: #f1f1f1;
        }

        .btn {
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 4px;
            font-weight: bold;
            text-align: center;
            display: inline-block;
        }

        .add-btn {
            background-color: #007bff;
            color: white;
        }

        .add-btn:hover {
            background-color: #0056b3;
        }

        .delete-btn {
            color: #dc3545;
        }

        .delete-btn:hover {
            color: #c82333;
        }

        .go-back-btn {
            background-color: #007bff;
            color: white;
        }

        .go-back-btn:hover {
            background-color: #0056b3;
        }

        footer {
            text-align: center;
            margin-top: 30px;
        }

        @media (max-width: 768px) {
            .container {
                width: 90%;
            }

            .reservation-table th, .reservation-table td {
                font-size: 14px;
                padding: 8px;
            }

            header h1 {
                font-size: 1.5rem;
            }
        }
    </style>
</body>
</html>
