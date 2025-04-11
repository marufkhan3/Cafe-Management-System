<!-- admin_dashboard.php -->
<?php
session_start();

// Make sure the admin is logged in, otherwise redirect to login page
if (!isset($_SESSION['admin_email'])) {
    header("Location: admin_login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../bootstrap-4.4.1/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', sans-serif;
        }

        .navbar {
            background-color: #007bff;
        }

        .navbar-brand, .navbar-nav .nav-link {
            color: white !important;
        }

        .navbar-nav .nav-link:hover {
            color: #d1e7ff !important;
        }

        .dashboard-container {
            max-width: 900px;
            margin: 40px auto;
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #343a40;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        ul li {
            margin-bottom: 15px;
        }

        ul li a {
            text-decoration: none;
            font-size: 18px;
            color: #007bff;
            transition: color 0.3s;
        }

        ul li a:hover {
            color: #0056b3;
        }

        .btn-logout {
            width: 100%;
            padding: 10px;
            background-color: #dc3545;
            color: white;
            border: none;
            border-radius: 5px;
            text-align: center;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-logout:hover {
            background-color: #c82333;
        }

        .nav-links {
            text-align: center;
            margin-top: 15px;
        }

        .card {
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .card-body {
            padding: 25px;
        }

        .card-header {
            background-color: #007bff;
            color: white;
            font-size: 20px;
        }

        .card-footer {
            background-color: #f1f1f1;
            text-align: right;
            border-radius: 0 0 10px 10px;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg">
        <a class="navbar-brand" href="admin_dashboard.php">Cafe Management System</a>
    </nav>

    <div class="dashboard-container">
        <h2>Welcome, Admin <?php echo $_SESSION['admin_name']; ?>!</h2>

        <div class="card">
            <div class="card-header">Admin Actions</div>
            <div class="card-body">
                <ul>
                    <li><a href="manage_menu.php">Manage Menu</a></li>
                    <li><a href="manage_orders.php">Manage Orders</a></li>
                    <li><a href="manage_reservations.php">Manage Reservations</a></li>
                    <li><a href="sales_report.php">View Sales Report</a></li>
                    <li><a href="manage_staff.php">Manage Staff</a></li>
                </ul>
            </div>
            <div class="card-footer">
                <button class="btn-logout" onclick="window.location.href='logout.php'">Logout</button>
            </div>
        </div>

    </div>

</body>
</html>
