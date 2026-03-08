<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "cardemoheader.php";
include "config.php";

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $email = $_POST['email'];
    $pswd  = $_POST['pswd'];

    $stmt = $conn->prepare("SELECT csbid, uname, email, pswd FROM seat_buyer WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($row = $res->fetch_assoc()) {
        // For hashed passwords: use password_verify($pswd, $row['pswd'])
        if ($pswd === $row['pswd']) {
            $_SESSION['csbid'] = $row['csbid'];
            $_SESSION['uname'] = $row['uname'];
            $_SESSION['email'] = $row['email'];
            echo "<script>alert('Login successful'); window.location='buyseat.php';</script>";
            exit();
        } else {
            echo "<script>alert('Invalid password'); window.location='carbuyerlogin.php';</script>";
            exit();
        }
    } else {
        echo "<script>alert('Email not found'); window.location='carbuyerlogin.php';</script>";
        exit();
    }
}
?>

<!-- HTML and styling omitted for brevity; same as your current page -->



<!DOCTYPE html>
<html>
<head>
    <title>Seat Buyer Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('images/vseat.jpg');
            background-size: cover;
            background-position: center;
            height: 90vh;
            margin: 0;
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
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.3);
            width: 100%;
            max-width: 400px;
        }

        .login-box h2 {
            margin-bottom: 25px;
            text-align: center;
            font-weight: bold;
            color: #333;
        }

        .form-label {
            font-weight: 600;
        }

        .btn-login {
            width: 100%;
            background-color: #28a745;
            color: white;
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
    </style>
</head>
<body>
<div class="overlay">
    <div class="login-box">
        <h2>Seat Buyer Login</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required placeholder="Enter your email">
            </div>
            <div class="mb-3">
                <label for="pswd" class="form-label">Password</label>
                <input type="password" name="pswd" class="form-control" required placeholder="Enter your password">
            </div>
            <button type="submit" class="btn btn-login">Login</button>
            <p class="register-text">Don't have an account? <a href="regcarbuyer.php" class="register-link">Register</a></p>
        </form>
    </div>
</div>
</body>
</html>
