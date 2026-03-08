<?php
include "carbuyerheader.php";
include "config.php";

session_start();
if (!isset($_SESSION['csbid'])) {
    echo "<script>alert('Please login first'); window.location='carbuyerlogin.php';</script>";
    exit();
}

$buyer_id = $_SESSION['csbid'];
$uname = $_SESSION['uname']; // Get logged-in buyer name

// Fetch bookings only for this buyer
$sql = "SELECT * FROM seat_booking WHERE buyer_name = '$uname' ORDER BY booking_id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Bookings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('images/bbook.jpg') no-repeat center center fixed;
            background-size: cover;
        }
        .container {
            margin-top: 50px;
            background-color: white;
            padding: 40px;
        }
        .table {
            background-color: white;
            border-radius: 10px;
            overflow: hidden;
        }
        h2 {
            text-align: center;
            margin-bottom: 30px;
        }
        th, td {
            text-align: center;
            vertical-align: middle !important;
        }
        .fw-bold{
            font-size: 20px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
<p class="text-center fw-bold">Welcome, <?php echo htmlspecialchars($uname); ?>!</p>
<div class="container">
    <h2>Your Seat Bookings</h2>
    <?php if ($result && $result->num_rows > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Booking ID</th>
                        <th>Passer Name</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Date</th>
                        <th>Passer Gender</th>
                        <th>Your Name</th>
                        <th>Your Gender</th>
                        <th>Mobile</th>
                        <th>Seat Count</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['booking_id'] ?></td>
                            <td><?= htmlspecialchars($row['passer_name']) ?></td>
                            <td><?= htmlspecialchars($row['from_place']) ?></td>
                            <td><?= htmlspecialchars($row['to_place']) ?></td>
                            <td><?= htmlspecialchars($row['journey_date']) ?></td>
                            <td><?= htmlspecialchars($row['passer_gender']) ?></td>
                            <td><?= htmlspecialchars($row['buyer_name']) ?></td>
                            <td><?= htmlspecialchars($row['buyer_gender']) ?></td>
                            <td><?= htmlspecialchars($row['buyer_mobile']) ?></td>
                            <td><?= $row['seat_count'] ?></td>
                            <td>
                                <?php
                                    $status = htmlspecialchars($row['status']);
                                    if ($status == "Confirmed") {
                                        echo "<span class='badge bg-success'>$status</span>";
                                    } elseif ($status == "Pending") {
                                        echo "<span class='badge bg-warning text-dark'>$status</span>";
                                    } else {
                                        echo "<span class='badge bg-secondary'>$status</span>";
                                    }
                                ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center">
            No bookings found.
        </div>
    <?php endif; ?>
</div>

</body>
</html>
