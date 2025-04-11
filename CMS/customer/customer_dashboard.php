<?php
session_start();
include('../db_connect.php');

// Check if the customer is logged in
if (!isset($_SESSION['customer_email'])) {
    header("Location: customer_login.php"); // Redirect to login if not logged in
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background: linear-gradient(to right, #f5f7fa, #c3cfe2);
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #007bff;
            color: white;
            padding: 20px 0;
            text-align: center;
            font-size: 24px;
        }

        h1 {
            text-align: center;
            margin-top: 40px;
            color: #333;
        }

        nav {
            display: flex;
            justify-content: center;
            margin-top: 40px;
        }

        nav ul {
            list-style-type: none;
            padding: 0;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 20px;
            max-width: 600px;
            margin: 0 auto;
        }

        nav li {
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.2s ease;
            text-align: center;
        }

        nav li:hover {
            transform: translateY(-5px);
        }

        nav a {
            display: block;
            text-decoration: none;
            color: #007bff;
            padding: 20px;
            font-weight: bold;
            font-size: 16px;
        }

        nav button {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 10px 20px;
            font-weight: bold;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            margin: 10px auto;
        }

        nav button:hover {
            background-color: #c82333;
        }
    </style>
</head>
<body>

    <header>
        Cafe Management System
    </header>

    <h1>Welcome, <?php echo $_SESSION['customer_name']; ?>!</h1>

    <nav>
        <ul>
            <li><a href="menu.php">🍽 View Menu</a></li>
            <li><a href="order.php">🛒 Place Order</a></li>
            <li><a href="reservation.php">📅 Make a Reservation</a></li>
            <li><a href="order_history.php">📜 Order History</a></li>
            <li><a href="logout.php"><button>🚪 Logout</button></a></li>
        </ul>
    </nav>

</body>
</html>
