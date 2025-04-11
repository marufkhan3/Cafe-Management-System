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
            echo "<p class='text-danger text-center mt-3'>Invalid password.</p>";
        }
    } else {
        echo "<p class='text-danger text-center mt-3'>Admin not found.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
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

        .login-container {
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

        .form-group {
            margin-bottom: 20px;
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

    <div class="login-container">
        <h2>Admin Login</h2>
        <form action="" method="POST">
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="text" name="email" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <input type="submit" value="Login" class="btn btn-primary btn-block">
        </form>

        <div class="nav-links">
            <a href="../index.php" class="btn btn-outline-secondary btn-sm">← Go Back</a>
        </div>
    </div>

</body>
</html>
