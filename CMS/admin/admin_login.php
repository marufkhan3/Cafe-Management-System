<?php
session_start();
include('../db_connect.php');  

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!$connection) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    // Query to check if the admin exists
    $query = "SELECT * FROM admins WHERE email='$email'";
    $result = mysqli_query($connection, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        // Direct comparison (if passwords are stored in plaintext)
        if ($password == $row['password']) {
            $_SESSION['admin_email'] = $email;
            $_SESSION['admin_name'] = $row['name'];
            header("Location: admin_dashboard.php");
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "Admin not found.";
    }
}
?>

<!-- Admin Login Form -->
<h2>Admin Login</h2>
<form action="" method="post">
    Email: <input type="text" name="email" required><br><br>
    Password: <input type="password" name="password" required><br><br>
    <input type="submit" value="Login">
</form>

<!-- Go Back Button -->
<br>
<a href="../login.php">
    <button>Go Back</button>
</a>
