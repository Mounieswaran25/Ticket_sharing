<?php
session_start();
include "config.php";

if (!isset($_SESSION['sid'])) {
    echo "<script>alert('Please login first.'); window.location.href='login.php';</script>";
    exit();
}

$sid = $_SESSION['sid'];

if (!isset($_GET['id'])) {
    echo "<script>alert('Invalid Ticket ID'); window.location.href='vticket.php';</script>";
    exit();
}

$tid = intval($_GET['id']);
$res = mysqli_query($conn, "SELECT * FROM tickets WHERE tid=$tid AND sid=$sid");

if (!$res || mysqli_num_rows($res) == 0) {
    echo "<script>alert('Ticket not found'); window.location.href='vticket.php';</script>";
    exit();
}

$row = mysqli_fetch_assoc($res);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $from = $_POST['from_location'];
    $to = $_POST['to_location'];
    $date = $_POST['tdate'];
    $stime = $_POST['stime'];
    $etime = $_POST['etime'];
    $contact = $_POST['contact'];

    $update = "UPDATE tickets SET name='$name', price='$price', from_location='$from', to_location='$to', tdate='$date', stime='$stime', etime='$etime', contact='$contact' WHERE tid=$tid AND sid=$sid";

    if (mysqli_query($conn, $update)) {
        echo "<script>alert('Ticket updated successfully'); window.location.href='vticket.php';</script>";
        exit();
    } else {
        echo "<script>alert('Failed to update ticket');</script>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Ticket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('images/bus3.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Segoe UI', sans-serif;
        }
        .container {
            background-color: rgba(0, 0, 0, 0.8);
            padding: 30px;
            border-radius: 15px;
            margin-top: 60px;
            color: white;
        }
        label {
            font-weight: 500;
        }
        h3 {
            color: #ffc107;
        }
    </style>
</head>
<body>
<div class="container">
    <h3 class="text-center mb-4">Edit Ticket</h3>
    <form method="POST">
        <div class="row mb-3">
            <div class="col">
                <label>Name</label>
                <input type="text" name="name" value="<?= $row['name'] ?>" class="form-control" required>
            </div>
            <div class="col">
                <label>Price</label>
                <input type="number" name="price" value="<?= $row['price'] ?>" class="form-control" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <label>From</label>
                <input type="text" name="from_location" value="<?= $row['from_location'] ?>" class="form-control" required>
            </div>
            <div class="col">
                <label>To</label>
                <input type="text" name="to_location" value="<?= $row['to_location'] ?>" class="form-control" required>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <label>Date</label>
                <input type="date" name="tdate" value="<?= $row['tdate'] ?>" class="form-control" required>
            </div>
            <div class="col">
                <label>Arrival</label>
                <input type="time" name="stime" value="<?= $row['stime'] ?>" class="form-control" required>
            </div>
            <div class="col">
                <label>Departure</label>
                <input type="time" name="etime" value="<?= $row['etime'] ?>" class="form-control" required>
            </div>
        </div>
        <div class="mb-3">
            <label>Contact</label>
            <input type="text" name="contact" value="<?= $row['contact'] ?>" class="form-control" required>
        </div>
        <div class="text-center">
            <button type="submit" class="btn btn-success">Update Ticket</button>
            <a href="vticket.php" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
</body>
</html>
