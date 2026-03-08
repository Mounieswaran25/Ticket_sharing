<?php
include "header.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Sharing</title>

    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #f0f8ff, #e0e7ff);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .hero-section {
            padding: 80px 20px;
        }

        .hero-heading {
            font-size: 2.4rem;
            font-weight: 700;
            color: #0d47a1;
        }

        .hero-text {
            font-size: 1rem;
            color: #333;
            margin-top: 15px;
        }

        .cta-btn {
            margin-top: 30px;
        }

        .carousel-inner img {
            width: 100%;
            height: 400px;
            object-fit: cover;
            border-radius: 15px;
        }

        .carousel {
            box-shadow: 0 6px 30px rgba(0, 0, 0, 0.2);
            border-radius: 15px;
        }

        .btn-primary {
            background-color: #0d47a1;
            border: none;
        }

        .btn-primary:hover {
            background-color: #08306b;
        }

        @media (max-width: 768px) {
            .hero-heading {
                font-size: 2rem;
            }

            .carousel-inner img {
                height: 250px;
            }
        }
    </style>
</head>
<body>

<div class="container hero-section">
    <div class="row align-items-center">
        <!-- Left Column -->
        <div class="col-md-6 mb-4 mb-md-0">
            <h1 class="hero-heading">WEBSITE FOR TRANSPORT TICKET SHARING SYSTEM </h1>
            <p class="hero-text">Easily book, share, and manage your bus and car journeys through our unified platform. Save money, time, and travel together.</p>
            <a href="bushome.php" class="btn btn-primary btn-lg cta-btn">Bus Ticket</a>
            <a href="carhome.php" class="btn btn-primary btn-lg cta-btn">Car Sharing</a>
        </div>

        <!-- Right Column - Carousel -->
        <div class="col-md-6">
            <div id="vehicleCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="images/bus.jpg" class="d-block w-100" alt="Bus Image">
                    </div>
                    <div class="carousel-item">
                        <img src="images/car.jpg" class="d-block w-100" alt="Car Image">
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#vehicleCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#vehicleCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap 5 JS CDN -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
