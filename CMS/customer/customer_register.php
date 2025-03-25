<?php
session_start();
include('../db_connect.php');

// Register customer
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];  // No hashing here, storing plain text password

    // Insert customer details into the database
    $register_query = "INSERT INTO customers (name, email, password) VALUES ('$name', '$email', '$password')";

    if (mysqli_query($connection, $register_query)) {
        echo "<p>Customer registered successfully!</p>";
    } else {
        echo "<p>Error: " . mysqli_error($connection) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Register</title>
</head>
<body>
    <h2>Customer Registration</h2>
    <form action="customer_register.php" method="POST">
        <label for="name">Name:</label>
        <input type="text" name="name" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" required><br>

        <input type="submit" value="Register">
    </form>

    <br><br>
    <a href="../index.php">Go Back to Home</a>
</body>
</html>
