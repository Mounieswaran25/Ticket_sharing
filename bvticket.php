<?php
session_start();
include "config.php";
include "buyerheader.php";

if (!isset($_SESSION['email'])) {
    header("Location: buyerlogin.php");
    exit();
}

$email = $_SESSION['email'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Ticket Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('images/bus6.jpg') no-repeat center center fixed;
            background-size: cover;
            font-family: 'Segoe UI', sans-serif;
        }

        .overlay {
            background: rgba(255, 255, 255, 0.9);
            padding: 30px;
            border-radius: 10px;
            margin-top: 40px;
            box-shadow: 0 0 15px rgba(0,0,0,0.3);
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
            font-weight: 600;
        }

        .table thead th{
            background-color: #3c096c;
            color: white;
            padding: 15px;
        }

        .table tbody td{
            
            
            padding: 15px;
        }

        .status-pending {
            color: orange;
            font-weight: 600;
        }

        .status-confirmed {
            color: green;
            font-weight: 600;
        }

        .download-btn {
            font-size: 14px;
        }

        .not-available,
        .image-missing {
            font-size: 14px;
            font-weight: 500;
        }

        .not-available {
            color: gray;
        }

        .image-missing {
            color: red;
        }

        .table-hover tbody tr:hover {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="overlay">
        <h2>My Ticket</h2>

        <?php
        $query = "
            SELECT o.id, o.purchase_time, o.price_offered, o.status,
                   t.tid, t.from_location, t.to_location, t.tdate, t.stime, t.etime, t.price, t.image
            FROM ticket_orders o
            JOIN tickets t ON o.ticket_id = t.tid
            WHERE o.buyer_email = '$email'
            ORDER BY o.purchase_time DESC
        ";

        $result = mysqli_query($conn, $query);
        ?>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle text-center">
                <thead>
                    <tr>
                        <th>Ticket ID</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Date</th>
                        <th>Start Time</th>
                        <th>End Time</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Download Ticket</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (mysqli_num_rows($result) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <tr>
                                <td><?php echo $row['tid']; ?></td>
                                <td><?php echo htmlspecialchars($row['from_location']); ?></td>
                                <td><?php echo htmlspecialchars($row['to_location']); ?></td>
                                <td><?php echo $row['tdate']; ?></td>
                                <td><?php echo $row['stime']; ?></td>
                                <td><?php echo $row['etime']; ?></td>
                                <td class="text-success fw-bold">Rs. <?php echo number_format($row['price_offered']); ?></td>
                                <td>
                                    <?php 
                                        if ($row['status'] === 'Pending') {
                                            echo "<span class='status-pending'>Pending</span>";
                                        } elseif ($row['status'] === 'Confirmed') {
                                            echo "<span class='status-confirmed'>Confirmed</span>";
                                        } else {
                                            echo htmlspecialchars($row['status']);
                                        }
                                    ?>
                                </td>
                                <td>
                                    <?php
                                        $imagePath = $row['image'];
                                        if ($row['status'] === 'Confirmed') {
                                            if (!empty($imagePath) && file_exists($imagePath)) {
                                                echo '<a href="' . $imagePath . '" download class="btn btn-sm btn-primary download-btn">Download</a>';
                                            } else {
                                                echo "<span class='image-missing'>Ticket not uploaded</span>";
                                            }
                                        } else {
                                            echo "<span class='not-available'>Waiting for Confirmation</span>";
                                        }
                                    ?>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="text-center text-muted">No ticket orders found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>
