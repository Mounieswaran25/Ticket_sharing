<?php
session_start();
include "config.php";
include "sellerheader.php";

if (!isset($_SESSION['sid'])) {
    echo "<script>alert('Please login first.'); window.location.href='sellerlogin.php';</script>";
    exit();
}

$sid = $_SESSION['sid'];

// Delete logic
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);

    // Delete image file
    $img_res = mysqli_query($conn, "SELECT image FROM tickets WHERE tid = $delete_id AND sid = $sid");
    if ($img_res && mysqli_num_rows($img_res) == 1) {
        $img_row = mysqli_fetch_assoc($img_res);
        $image_path = $img_row['image'];
        if (file_exists($image_path)) {
            unlink($image_path);
        }
    }

    // Delete from DB
    $del_sql = "DELETE FROM tickets WHERE tid = $delete_id AND sid = $sid";
    if (mysqli_query($conn, $del_sql)) {
        echo "<script>alert('Ticket deleted successfully'); window.location.href='vticket.php';</script>";
        exit();
    } else {
        echo "<script>alert('Failed to delete ticket');</script>";
    }
}

$sql = "SELECT * FROM tickets WHERE sid = $sid";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Tickets</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('images/bus3.jpg') no-repeat center center fixed;
            background-size: cover;
            color: white;
            font-family: 'Segoe UI', sans-serif;
        }
        .container {
            background-color: rgba(0, 0, 0, 0.75);
            padding: 30px;
            border-radius: 15px;
            margin-top: 50px;
        }
        img.ticket-image {
            width: 100px;
            height: auto;
            border-radius: 5px;
        }
        .btn {
            margin: 0 2px;
        }
        h2 {
            color: #ffc107;
        }
    </style>
</head>
<body>
<div class="container">
    <h2 class="text-center mb-4">My Ticket Details</h2>
    <table class="table table-bordered table-dark table-hover text-center align-middle">
        <thead class="table-light text-dark">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>From</th>
                <th>To</th>
                <th>Date</th>
                <th>Arrival</th>
                <th>Departure</th>
                <th>Contact</th>
                <th>Image</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?= $row['tid'] ?></td>
                    <td><?= $row['name'] ?></td>
                    <td><?= $row['price'] ?></td>
                    <td><?= $row['from_location'] ?></td>
                    <td><?= $row['to_location'] ?></td>
                    <td><?= $row['tdate'] ?></td>
                    <td><?= $row['stime'] ?></td>
                    <td><?= $row['etime'] ?></td>
                    <td><?= $row['contact'] ?></td>
                    <td><img src="<?= $row['image'] ?>" class="ticket-image"></td>
                    <td>
                        <a href="editticket.php?id=<?= $row['tid'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="vticket.php?delete_id=<?= $row['tid'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?');">Delete</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>
