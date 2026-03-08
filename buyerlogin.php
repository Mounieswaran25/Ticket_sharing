<?php
session_start();
include "busdemoheader.php";
include "config.php";

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $query = "SELECT * FROM buyer_user WHERE email = '$email'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) === 1) {
        $buyer = mysqli_fetch_assoc($result);

        if ($buyer['pswd'] === $password) {
            $_SESSION['email'] = $email;
            $_SESSION['buyer_name'] = $buyer['bname'];
            $_SESSION['buyer_id'] = $buyer['bid'];
            header("Location: buyticket.php");
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "Buyer not found.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Buyer Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('images/bus2.jpg') no-repeat center center fixed;
            background-size: cover;
            height: 91vh;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .overlay {
            background-color: rgba(0, 0, 0, 0.6);
            height: 91vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-box {
            background-color: white;
            padding: 35px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
            width: 100%;
            max-width: 400px;
        }

        .login-box h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
            font-weight: bold;
        }

        .form-label {
            font-weight: 600;
        }

        .btn-login {
            width: 100%;
            background-color: #28a745;
            color: white;
            font-weight: bold;
        }

        .btn-login:hover {
            background-color: #218838;
        }

        .register-text {
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
        }

        .register-link {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
        }

        .register-link:hover {
            text-decoration: underline;
            color: #0056b3;
        }

        .error {
            color: red;
            text-align: center;
            margin-top: 10px;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="overlay">
    <div class="login-box">
        <h2>Buyer Login</h2>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="text" name="email" class="form-control" placeholder="Enter email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" placeholder="Enter password" required>
            </div>
            <button type="submit" class="btn btn-login">Login</button>
            <p class="register-text">Don't have an account? <a href="regbuyer.php" class="register-link">Register</a></p>
        </form>

        <?php if ($error): ?>
            <div class="error"><?= $error ?></div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>
