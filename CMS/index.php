<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cafe Management System</title>
    <link rel="stylesheet" type="text/css" href="bootstrap-4.4.1/css/bootstrap.min.css">
    <script type="text/javascript" src="bootstrap-4.4.1/js/juqery_latest.js"></script>
    <script type="text/javascript" src="bootstrap-4.4.1/js/bootstrap.min.js"></script>

    <style>
        body {
            background: linear-gradient(to right, #f9f9f9, #f1f4f6);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', sans-serif;
        }

        .container {
            background-color: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            text-align: center;
        }

        h1 {
            color: #343a40;
            margin-bottom: 30px;
        }

        a {
            display: inline-block;
            margin: 10px;
            font-size: 16px;
        }

        .btn-custom {
            padding: 10px 25px;
            font-weight: bold;
            border-radius: 5px;
        }

        .btn-login {
            background-color: #007bff;
            color: white;
        }

        .btn-login:hover {
            background-color: #0056b3;
        }

        .btn-register-customer {
            background-color: #28a745;
            color: white;
        }

        .btn-register-customer:hover {
            background-color: #218838;
        }

        .btn-register-admin {
            background-color: #17a2b8;
            color: white;
        }

        .btn-register-admin:hover {
            background-color: #117a8b;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Welcome to the Cafe Management System</h1>
        <div>
            <a href="login.php" class="btn btn-custom btn-login">Login</a>
            <a href="customer/customer_register.php" class="btn btn-custom btn-register-customer">Register as Customer</a>
            <a href="admin/admin_register.php" class="btn btn-custom btn-register-admin">Register as Admin</a>
        </div>
    </div>
</body>
</html>
