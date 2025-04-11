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
        echo "<p class='text-success text-center mt-3'>Customer registered successfully!</p>";
    } else {
        echo "<p class='text-danger text-center mt-3'>Error: " . mysqli_error($connection) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Register</title>
    <link rel="stylesheet" href="../bootstrap-4.4.1/css/bootstrap.min.css">
    <style>
        body {
            background: #f1f4f6;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: 'Segoe UI', sans-serif;
        }
        .register-box {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #343a40;
        }
        .btn-register {
            width: 100%;
        }
        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="register-box">
        <h2>Customer Registration</h2>
        <form action="customer_register.php" method="POST">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" name="name" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" name="email" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" name="password" required>
            </div>

            <input type="submit" value="Register" class="btn btn-success btn-register">
        </form>

        <a class="back-link" href="../index.php">← Go Back to Home</a>
    </div>
</body>
</html>
