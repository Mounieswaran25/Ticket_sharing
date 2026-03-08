<?php
session_start();
include "cardemoheader.php";
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $pswd = $_POST['pswd'];
    $res = mysqli_query($conn, "SELECT * FROM seat_seller WHERE email='$email' AND pswd='$pswd'");
    if (mysqli_num_rows($res) == 1) {
        $row = mysqli_fetch_assoc($res);
        $_SESSION['ssid'] = $row['ssid'];
        $_SESSION['uname'] = $row['uname'];
        header("Location: addseat.php");
        exit();
    } else {
        echo "<script>alert('Invalid login');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Car Seat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('images/admin_home1.jpg');
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
        <h2>Seller Login</h2>
        <form method="POST">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
            </div>
            <div class="mb-3">
                <label for="pswd" class="form-label">Password</label>
                <input type="password" name="pswd" class="form-control" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="btn btn-login">Login</button>
            <p class="register-text">Don't have an account? <a href="regcarseller.php" class="register-link">Register</a></p>

        </form>
    </div>
</div>

</body>
</html>
