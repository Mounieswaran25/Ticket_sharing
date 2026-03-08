<?php

include "busdemoheader.php";
include "config.php";



if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['uname'];
    $email = $_POST['email'];
    $mobile = $_POST['mol'];
    $password = $_POST['pswd'];
    $address = $_POST['ads'];

    $sql = "INSERT INTO seller_user(uname, email, mol, pswd, ads) 
            VALUES ('$name', '$email', '$mobile', '$password', '$address')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Registered Successfully!'); window.location.href='sellerlogin.php';</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }

    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Car Seat</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            padding: 0;
            background: url('images/bus2.jpg') no-repeat center center fixed;
            background-size: cover;
            height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .form-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 90vh;
        }

        .form-box {
            background-color: rgba(0, 0, 0, 0.75);
            padding: 40px;
            border-radius: 15px;
            color: white;
            width: 100%;
            max-width: 700px;
            box-shadow: 0 0 15px rgba(0,0,0,0.6);
        }

        .form-box h2 {
            text-align: center;
            margin-bottom: 30px;
            font-weight: bold;
        }

        .form-control {
            background-color: rgba(255, 255, 255, 0.95);
        }

        .form-control:focus {
            box-shadow: 0 0 5px #28a745;
            border-color: #28a745;
        }

        .btn-custom {
            background-color: #219ebc;
            color: #fff;
            border: none;
            padding: 10px 15px;
            font-size: 16px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .btn-custom:hover {
            background-color: #218838;
        }

        .register-text {
    text-align: center;
    margin-top: 15px;
    font-size: 17px;
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

<div class="form-container">
    <div class="form-box">
        <h2>Register</h2>
        <form action="" method="POST">
            <div class="row g-3">
                <div class="col-md-6">
                    <label for="uname" class="form-label">Full Name</label>
                    <input type="text" name="uname" id="uname" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label for="mol" class="form-label">Mobile</label>
                    <input type="text" name="mol" id="mobile" class="form-control" required pattern="[0-9]{10}" title="Enter 10-digit number">
                </div>
                <div class="col-md-6">
                <label for="pswd" class="form-label">Password</label>
                    <input type="password" name="pswd" id="pswd" class="form-control" required>
                </div>
                <div class="col-md-12">
                    
                    <label for="ads" class="form-label">Address</label>
                    <input type="text" name="ads" id="address" class="form-control" required>
                </div>
                <div class="col-12 d-grid mt-3">
                    <button type="submit" class="btn btn-custom">Register</button>
                </div>

                <div class="register-link">
              
                <p class="register-text text-white">Already have an account? <a href="sellerlogin.php" class="register-link">Login</a></p>

            </div>
            </div>
        </form>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
