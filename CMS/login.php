<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="bootstrap-4.4.1/css/bootstrap.min.css">
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
            text-align: center;
            width: 100%;
            max-width: 500px;
        }

        h1 {
            font-size: 36px;
            color: #343a40;
            margin-bottom: 20px;
        }

        p {
            font-size: 18px;
            color: #495057;
            margin-bottom: 30px;
        }

        .btn-block {
            width: 100%;
            padding: 15px;
            font-size: 16px;
        }

        .btn-outline-secondary {
            width: 100%;
            padding: 10px;
        }

        hr {
            margin: 30px 0;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <h1>Welcome to the Cafe Management System</h1>
        <p>Please choose your login type:</p>

        <a href="admin/admin_login.php" class="btn btn-primary btn-block">Admin Login</a>
        <a href="customer/customer_login.php" class="btn btn-success btn-block">Customer Login</a>

        <hr>

        <a href="index.php" class="btn btn-outline-secondary btn-block">Go Back</a>
    </div>

</body>
</html>
