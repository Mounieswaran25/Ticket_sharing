<?php
include "config.php";
include "carsellerheader.php";

session_start();

if (!isset($_SESSION['ssid'])) {
    echo "<script>alert('Please login first'); window.location='carsellerlogin.php';</script>";
    exit();
}

$seller_id = $_SESSION['ssid'];

// Accept booking
if (isset($_GET['accept'])) {
    $booking_id = (int)$_GET['accept'];

    // Verify this booking belongs to the logged-in seller
    $check = $conn->query("
        SELECT sb.booking_id 
        FROM seat_booking sb
        JOIN car_seat cs ON sb.car_seat_id = cs.csid
        WHERE sb.booking_id = $booking_id AND cs.ssid = $seller_id AND sb.status = 'Pending'
    ");

    if ($check && $check->num_rows > 0) {
        $conn->query("UPDATE seat_booking SET status = 'Confirmed' WHERE booking_id = $booking_id");
    }

    header("Location: seat_accept.php");
    exit();
}

// Fetch all pending bookings where car_seat.ssid = logged-in seller
$sql = "
    SELECT sb.* 
    FROM seat_booking sb
    JOIN car_seat cs ON sb.car_seat_id = cs.csid
    WHERE sb.status = 'Pending' AND cs.ssid = $seller_id
    ORDER BY sb.booking_id DESC
";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Car Seat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { 
            background: url('images/sbook.jpg') no-repeat center center fixed;
            background-size: cover;
         }
        .container {
            background-color: white; 
            padding: 40px; 
            margin-top: 40px;
        }
        h2 { text-align: center; margin-bottom: 20px; }
    </style>
</head>
<body>
<div class="container">
    <h2>Seat Booking Requests</h2>

    <?php if ($result && $result->num_rows > 0): ?>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Booking ID</th>
                    <th>Passer Name</th>
                    <th>Buyer Name</th>
                    <th>Journey Date</th>
                    <th>Seat Count</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['booking_id']) ?></td>
                        <td><?= htmlspecialchars($row['passer_name']) ?></td>
                        <td><?= htmlspecialchars($row['buyer_name']) ?></td>
                        <td><?= htmlspecialchars($row['journey_date']) ?></td>
                        <td><?= htmlspecialchars($row['seat_count']) ?></td>
                        <td>
                            <a href="seat_accept.php?accept=<?= $row['booking_id'] ?>" class="btn btn-success btn-sm">
                                Accept
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="alert alert-info text-center">No pending seat booking requests for you.</div>
    <?php endif; ?>
</div>
</body>
</html>
