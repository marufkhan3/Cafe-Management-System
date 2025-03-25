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
        echo "<p style='color: red;'>Email is already registered. Please try another.</p>";
    } else {
        // Insert the admin into the database without hashing the password
        $register_query = "INSERT INTO admins (name, email, password) VALUES ('$admin_name', '$admin_email', '$admin_password')";
        
        if (mysqli_query($connection, $register_query)) {
            echo "<p style='color: green;'>Registration successful! You can now <a href='admin_login.php'>login</a>.</p>";
        } else {
            echo "<p style='color: red;'>Error: " . mysqli_error($connection) . "</p>";
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
</head>
<body>
    <h2>Admin Registration</h2>
    <form action="admin_register.php" method="POST">
        <label for="name">Full Name:</label><br>
        <input type="text" name="name" required><br><br>

        <label for="email">Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label for="password">Password:</label><br>
        <input type="password" name="password" required><br><br>

        <input type="submit" value="Register">
    </form>

    <br>
    <a href="admin_login.php">Already have an account? Login here</a>

    <hr>
    <a href="../index.php">
        <button>Go Back</button>
    </a>

</body>
</html>
