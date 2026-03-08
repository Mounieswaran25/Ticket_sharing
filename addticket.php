<?php
session_start();

include "config.php";
include "sellerheader.php";

if (!isset($_SESSION['sid'])) {
    header("Location: sellerlogin.php");
    exit();
}

$seller_id = $_SESSION['sid'];
$seller_name = $_SESSION['uname'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $from = $_POST['from_location'];
    $to = $_POST['to_location'];
    $tdate = $_POST['tdate'];
    $stime = $_POST['stime'];
    $etime = $_POST['etime'];
    $contact = $_POST['contact'];

    // Image upload
    $target_dir = "ticket_images/";
    $image_name = basename($_FILES["ticket_image"]["name"]);
    $target_file = $target_dir . time() . "_" . $image_name;

    // Create directory if it doesn't exist
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    if (move_uploaded_file($_FILES["ticket_image"]["tmp_name"], $target_file)) {
        $image_path = $target_file;

        $sql = "INSERT INTO tickets (name, price, from_location, to_location, tdate, stime, etime, contact, sid, image)
                VALUES ('$name', '$price', '$from', '$to', '$tdate', '$stime', '$etime', '$contact', '$seller_id', '$image_path')";

        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Ticket added successfully'); window.location='vticket.php';</script>";
        } else {
            echo "<div class='alert alert-danger'>Database error: " . mysqli_error($conn) . "</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Error uploading image.</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Ticket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background-image: url('images/bus5.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
        }

        .form-wrapper {
            background-color: rgba(255, 255, 255, 0.95);
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 0 15px rgba(0,0,0,0.3);
            max-width: 1140px;
            margin: 20px auto;
        }

        .seller-name {
            text-align: center;
            background-color: rgba(255, 255, 255, 0.85);
            font-size: 24px;
            font-weight: bold;
            padding: 12px;
            margin-top: 30px;
            border-radius: 10px;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        label {
            font-weight: 700;
        }
    </style>
</head>
<body>
    <div class="container seller-name">Welcome - <?php echo htmlspecialchars($seller_name); ?></div>

    <div class="container form-wrapper">
        <h2>Add New Ticket</h2>
        <form method="POST" enctype="multipart/form-data">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Passenger Name</label>
                    <input type="text" name="name" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Price</label>
                    <input type="number" name="price" step="0.01" class="form-control" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">From Location</label>
                    <input type="text" name="from_location" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">To Location</label>
                    <input type="text" name="to_location" class="form-control" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Travel Date</label>
                    <input type="date" name="tdate" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">Contact</label>
                    <input type="text" name="contact" class="form-control" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Start Time</label>
                    <input type="time" name="stime" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label">End Time</label>
                    <input type="time" name="etime" class="form-control" required>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label">Ticket Image</label>
                <input type="file" name="ticket_image" class="form-control" accept="image/*" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Add Ticket</button>
        </form>
    </div>
</body>
</html>
