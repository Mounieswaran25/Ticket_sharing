<?php
session_start();
include "carsellerheader.php";
include "config.php";

if (!isset($_SESSION['ssid'])) {
  echo "<script>alert('Please login first'); window.location='carsellerlogin.php';</script>";
  exit();
}

$seller_id = $_SESSION['ssid'];

// Fetch records for this seller only
$sql = "SELECT * FROM car_seat WHERE ssid = '$seller_id'";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add Car Seat</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    body {
      background-image: url('images/vseat.jpg');
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center;
      min-height: 100vh;
    }

    .container {
      background-color: rgba(255, 255, 255, 0.95);
      padding: 30px;
      border-radius: 15px;
      margin-top: 40px;
      box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
    }

    h1 {
      text-align: center;
      font-weight: bold;
      margin-bottom: 20px;
    }

    table {
      margin-top: 20px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Your Uploaded Car Seats</h1>
    <table class="table table-bordered table-striped">
      <thead class="table-dark">
        <tr>
          <th>ID</th>
          <th>Passer Name</th>
          <th>Date</th>
          <th>From</th>
          <th>To</th>
          <th>Price</th>
          <th>Available Seats</th>
          <th>Gender</th>
          <th>Mobile</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php if ($result->num_rows > 0): ?>
          <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
              <td><?= $row['csid'] ?></td>
              <td><?= $row['passer_name'] ?></td>
              <td><?= $row['date'] ?></td>
              <td><?= $row['from_place'] ?></td>
              <td><?= $row['to_place'] ?></td>
              <td>Rs.<?= $row['price'] ?></td>
              <td><?= $row['available_seat'] ?></td>
              <td><?= $row['gender'] ?></td>
              <td><?= $row['mol'] ?></td>
              <td>
                <a href="editseat.php?csid=<?= $row['csid'] ?>" class="btn btn-primary btn-sm">Edit</a>
                <a href="deleteseat.php?csid=<?= $row['csid'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this seat?');">Delete</a>
              </td>
            </tr>
          <?php endwhile; ?>
        <?php else: ?>
          <tr>
            <td colspan="10" class="text-center">No seat records found.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</body>
</html>
