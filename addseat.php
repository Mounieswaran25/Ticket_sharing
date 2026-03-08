<?php
session_start();
include "carsellerheader.php";
include "config.php";

if (!isset($_SESSION['ssid'])) {
  echo "<script>alert('Please login first'); window.location='carsellerlogin.php';</script>";
  exit();
}

if (!isset($_SESSION['ssid'])) {
  header("Location: casellerlogin.php");
  exit();
}

$seller_id = $_SESSION['ssid'];
$seller_name = $_SESSION['uname'];
?>

<!DOCTYPE html>
<html>
<head>
  <title>Add Car Seat</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background-image: url('images/home.jpg');
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center;
      min-height: 100vh;
    }

    .form-container {
      background-color: rgba(255, 255, 255, 0.95);
      padding: 30px;
      border-radius: 15px;
      margin-top: 20px;
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
    }

    .form-title {
      text-align: center;
      font-size: 24px;
      font-weight: bold;
      margin-bottom: 20px;
    }

    .seller-name {
      text-align: center;
      background-color: white;
      font-size: 25px;
      color: #555;
      margin-top: 20px;
      padding: 10px;
      font-weight: 700;
      border-radius: 15px;
    }
  </style>
</head>
<body>
<div class="container seller-name">Welcome - <?php echo htmlspecialchars($seller_name); ?></div>

  <div class="container">
    <div class="form-container">
      <div class="form-title">Add Car Seat</div>
      
      <?php
      if ($_SERVER["REQUEST_METHOD"] == "POST") {
          $passer_name = $_POST['passer_name'];
          $date = $_POST['date'];
          $from_place = $_POST['from_place'];
          $to_place = $_POST['to_place'];
          $price = $_POST['price'];
          $available_seat = $_POST['available_seat'];
          $gender = $_POST['gender'];
          $mobile = $_POST['mol'];

          $sql = "INSERT INTO car_seat (csid, passer_name, date, from_place, to_place, price, available_seat, gender, mol, ssid)
                  VALUES ('$seller_id', '$passer_name', '$date', '$from_place', '$to_place', '$price', '$available_seat', '$gender', '$mobile', '$seller_id')";

          if ($conn->query($sql) === TRUE) {
              echo "<div class='alert alert-success'>Seat details added successfully!</div>";
          } else {
              echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
          }
      }
      ?>

      <form method="POST">
        <div class="row mb-3">
          <div class="col-md-6">
            <label>Passer Name</label>
            <input type="text" name="passer_name" class="form-control" required />
          </div>
          <div class="col-md-6">
            <label>Date</label>
            <input type="date" name="date" class="form-control" required />
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <label>From</label>
            <input type="text" name="from_place" class="form-control" required />
          </div>
          <div class="col-md-6">
            <label>To</label>
            <input type="text" name="to_place" class="form-control" required />
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <label>Price</label>
            <input type="text" name="price" class="form-control" required />
          </div>
          <div class="col-md-6">
            <label>Available Seats</label>
            <input type="number" name="available_seat" class="form-control" required />
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-6">
            <label class="d-block">Passer Gender</label>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="gender" value="Male" required />
              <label class="form-check-label">Male</label>
            </div>
            <div class="form-check form-check-inline">
              <input class="form-check-input" type="radio" name="gender" value="Female" required />
              <label class="form-check-label">Female</label>
            </div>
          </div>
          <div class="col-md-6">
            <label>Contact</label>
            <input type="text" name="mol" class="form-control" required />
          </div>
        </div>

        <button type="submit" class="btn btn-primary w-100">Submit</button>
      </form>

    </div>
  </div>
</body>
</html>
