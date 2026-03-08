<?php
session_start();
include "config.php";

$uid = $_SESSION['uid'];
$result = mysqli_query($conn, "SELECT b.*, t.name AS ticket_name, t.from_location, t.to_location, b.status 
                               FROM booking b 
                               JOIN tickets t ON b.tid = t.tid 
                               WHERE b.buyer_id = '$uid'");
?>
<!DOCTYPE html>
<html>
<head>
    <title>My Bookings</title>
    <style>
        table { width: 80%; margin: 30px auto; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
        th { background: #eee; }
    </style>
</head>
<body>
    <h2 style="text-align:center;">My Booking Requests</h2>
    <table>
        <tr>
            <th>Ticket</th><th>From</th><th>To</th><th>Status</th><th>Time</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?= htmlspecialchars($row['ticket_name']) ?></td>
                <td><?= htmlspecialchars($row['from_location']) ?></td>
                <td><?= htmlspecialchars($row['to_location']) ?></td>
                <td><?= htmlspecialchars($row['status']) ?></td>
                <td><?= htmlspecialchars($row['booking_time']) ?></td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
