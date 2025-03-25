<?php
session_start();
include('../db_connect.php'); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    if (!$connection) {
        die("Database connection failed: " . mysqli_connect_error());
    }

    // Fetch customer from database
    $query = "SELECT * FROM customers WHERE email='$email'";
    $result = mysqli_query($connection, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        if ($password === $row['password']) {  // Assuming passwords are stored in plain text
            $_SESSION['customer_id'] = $row['id'];  // ✅ Store customer ID in session
            $_SESSION['customer_email'] = $email;
            $_SESSION['customer_name'] = $row['name'];

            header("Location: customer_dashboard.php");
            exit();
        } else {
            echo "<p style='color: red;'>Invalid password.</p>";
        }
    } else {
        echo "<p style='color: red;'>User not found.</p>";
    }
}
?>

<!-- HTML form for Customer Login -->
<h2>Customer Login</h2>
<form action="" method="post">
    Email: <input type="text" name="email" required><br><br>
    Password: <input type="password" name="password" required><br><br>
    <input type="submit" value="Login">
</form>
<!-- Go back to index page -->
<a href="../index.php"><button>Go Back</button></a>
