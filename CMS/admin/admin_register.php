<?php
session_start();
include('../db_connect.php'); // Include the database connection

// Check if admin is already logged in
if (isset($_SESSION['admin_email'])) {
    header("Location: admin_dashboard.php"); // Redirect to dashboard if already logged in
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $admin_name = mysqli_real_escape_string($connection, $_POST['name']);
    $admin_email = mysqli_real_escape_string($connection, $_POST['email']);
    $admin_password = mysqli_real_escape_string($connection, $_POST['password']);
    
    // Check if admin email already exists
    $email_check_query = "SELECT * FROM admins WHERE email='$admin_email'";
    $email_check_result = mysqli_query($connection, $email_check_query);
    
    if (mysqli_num_rows($email_check_result) > 0) {
        echo "<p class='text-danger text-center mt-3'>Email is already registered. Please try another.</p>";
    } else {
        // Insert the admin into the database without hashing the password
        $register_query = "INSERT INTO admins (name, email, password) VALUES ('$admin_name', '$admin_email', '$admin_password')";
        
        if (mysqli_query($connection, $register_query)) {
            echo "<p class='text-success text-center mt-3'>Registration successful! You can now <a href='admin_login.php'>login</a>.</p>";
        } else {
            echo "<p class='text-danger text-center mt-3'>Error: " . mysqli_error($connection) . "</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration</title>
    <link rel="stylesheet" href="../bootstrap-4.4.1/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .register-container {
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 450px;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #343a40;
        }

        .btn-block {
            width: 100%;
        }

        .nav-links {
            text-align: center;
            margin-top: 15px;
        }
    </style>
</head>
<body>

    <div class="register-container">
        <h2>Admin Registration</h2>
        <form action="admin_register.php" method="POST">
            <div class="form-group">
                <label for="name">Full Name:</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <input type="submit" value="Register" class="btn btn-primary btn-block">
        </form>

        <div class="nav-links">
            <a href="admin_login.php">Already have an account? Login here</a><br><br>
            <a href="../index.php" class="btn btn-outline-secondary btn-sm">← Go Back</a>
        </div>
    </div>

</body>
</html>
