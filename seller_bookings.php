<?php
session_start();
include "config.php";

$seller_id = $_SESSION['sid'];

$query = "
SELECT b.bid, b.status, b.booking_time, t.name AS ticket_name, t.from_location, t.to_location,
       u.username AS buyer_name
FROM booking b
JOIN tickets t ON b.tid = t.tid
JOIN uregistration u ON b.buyer_id = u.uid
WHERE t.sid = '$seller_id'
ORDER BY b.booking_time DESC
";

$result = mysqli_query($conn, $query);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Car Seat</title>
    <style>
        table { width: 90%; margin: 30px auto; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 10px; text-align: center; }
        th { background: #eee; }
        .accept-btn {
            padding: 5px 10px;
            background: green;
            color: white;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Incoming Booking Requests</h2>
    <table>
        <tr>
            <th>Ticket</th><th>From</th><th>To</th><th>Buyer</th><th>Status</th><th>Time</th><th>Action</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?= htmlspecialchars($row['ticket_name']) ?></td>
                <td><?= htmlspecialchars($row['from_location']) ?></td>
                <td><?= htmlspecialchars($row['to_location']) ?></td>
                <td><?= htmlspecialchars($row['buyer_name']) ?></td>
                <td><?= htmlspecialchars($row['status']) ?></td>
                <td><?= htmlspecialchars($row['booking_time']) ?></td>
                <td>
                    <?php if ($row['status'] == 'Pending') { ?>
                        <form method="post" action="accept_booking.php">
                            <input type="hidden" name="bid" value="<?= $row['bid'] ?>">
                            <button type="submit" class="accept-btn">Accept</button>
                        </form>
                    <?php } else {
                        echo "Accepted";
                    } ?>
                </td>
            </tr>
        <?php } ?>
    </table>
</body>
</html>
