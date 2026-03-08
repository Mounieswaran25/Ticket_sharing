<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Car Seat</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Segoe UI', sans-serif;
        }

        body {
            background: url('images/home.jpg') no-repeat center center fixed;
            background-size: cover;
        }

        .navbar {
            background-color: rgba(0, 0, 0, 0.7);
        }

        .navbar-brand, .nav-link, .logout-btn {
            color: white !important;
            font-weight: 500;
        }

        .hero {
            height: calc(100vh - 56px); /* Subtract navbar height */
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: white;
            text-shadow: 2px 2px 4px #000;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .hero h1 {
            font-size: 4rem;
            margin-bottom: 40px;
            font-weight: 700;
        }

        .btn-custom {
            width: 150px;
            font-size: 1.2rem;
            margin: 10px;
            padding: 10px 20px;
            border-radius: 30px;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="#">Car Seat Sharing</a>
        <div class="ms-auto">
            <a class="btn logout-btn" href="index.php">Logout</a>
        </div>
    </div>
</nav>

<!-- Hero Section -->
<div class="hero text-center">
    <h1>CAR SEAT SHARING</h1>
    <div>
        <a href="carsellerlogin.php" class="btn btn-warning btn-custom">Seller</a>
        <a href="carbuyerlogin.php" class="btn btn-success btn-custom">Buyer</a>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
