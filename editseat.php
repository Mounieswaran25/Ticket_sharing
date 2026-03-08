<?php
include "carsellerheader.php";
include "Config.php";

// Check if ID is set
if (!isset($_GET['csid'])) {
    echo "<script>alert('Invalid request.'); window.location.href='vseat.php';</script>";
    exit;
}

$csid = $_GET['csid'];
$sql = "SELECT * FROM car_seat WHERE csid = $csid";
$result = $conn->query($sql);

// If not found
if ($result->num_rows != 1) {
    echo "<script>alert('Seat not found.'); window.location.href='vseat.php';</script>";
    exit;
}

$row = $result->fetch_assoc();

// Handle update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $passer_name = $_POST['passer_name'];
    $date = $_POST['date'];
    $from_place = $_POST['from_place'];
    $to_place = $_POST['to_place'];
    $price = $_POST['price'];
    $available_seat = $_POST['available_seat'];
    $gender = $_POST['gender'];
    $mol = $_POST['mol'];

    $update_sql = "UPDATE car_seat SET
        passer_name='$passer_name',
        date='$date',
        from_place='$from_place',
        to_place='$to_place',
        price='$price',
        available_seat='$available_seat',
        gender='$gender',
        mol='$mol'
        WHERE csid=$csid";

    if ($conn->query($update_sql) === TRUE) {
        echo "<script>alert('Seat updated successfully'); window.location.href='vseat.php';</script>";
    } else {
        echo "<script>alert('Error updating seat');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Car Seat</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background-image: url('images/home.jpg');
      background-size: cover;
      background-position: center;
      background-repeat: no-repeat;
      min-height: 100vh;
    }

    .container {
      background: rgba(255,255,255,0.95);
      padding: 30px;
      border-radius: 15px;
      margin-top: 40px;
    }

    h2 {
      text-align: center;
      font-weight: bold;
    }
  </style>
</head>
<body>
<div class="container">
  <h2>Edit Car Seat</h2>
  <form method="POST">
    <div class="row mb-3">
      <div class="col-md-6">
        <label>Passer Name</label>
        <input type="text" name="passer_name" class="form-control" value="<?= $row['passer_name'] ?>" required>
      </div>
      <div class="col-md-6">
        <label>Date</label>
        <input type="date" name="date" class="form-control" value="<?= $row['date'] ?>" required>
      </div>
    </div>

    <div class="row mb-3">
      <div class="col-md-6">
        <label>From</label>
        <input type="text" name="from_place" class="form-control" value="<?= $row['from_place'] ?>" required>
      </div>
      <div class="col-md-6">
        <label>To</label>
        <input type="text" name="to_place" class="form-control" value="<?= $row['to_place'] ?>" required>
      </div>
    </div>

    <div class="row mb-3">
      <div class="col-md-6">
        <label>Price</label>
        <input type="text" name="price" class="form-control" value="<?= $row['price'] ?>" required>
      </div>
      <div class="col-md-6">
        <label>Available Seats</label>
        <input type="number" name="available_seat" class="form-control" value="<?= $row['available_seat'] ?>" required>
      </div>
    </div>

    <div class="row mb-3">
      <div class="col-md-6">
        <label>Gender</label><br>
        <input type="radio" name="gender" value="Male" <?= $row['gender'] == 'Male' ? 'checked' : '' ?>> Male
        <input type="radio" name="gender" value="Female" <?= $row['gender'] == 'Female' ? 'checked' : '' ?>> Female
      </div>
      <div class="col-md-6">
        <label>Mobile</label>
        <input type="text" name="mol" class="form-control" value="<?= $row['mol'] ?>" required>
      </div>
    </div>

    <button type="submit" class="btn btn-success w-100">Update Seat</button>
  </form>
</div>
</body>
</html>
