<?php
session_start();
include "config.php";
include "sellerheader.php";

// Ensure the seller is logged in
if (!isset($_SESSION['sid'])) {
    header("Location: sellerlogin.php");
    exit();
}

$seller_id = $_SESSION['sid'];

// Accept button logic
if (isset($_GET['accept_id'])) {
    $orderId = (int)$_GET['accept_id'];

    // Optional: Check if the order exists before updating
    $check = mysqli_query($conn, "SELECT * FROM ticket_orders WHERE id = $orderId AND status = 'Pending'");
    if (mysqli_num_rows($check) > 0) {
        $update = "UPDATE ticket_orders SET status = 'Confirmed' WHERE id = $orderId";
        if (mysqli_query($conn, $update)) {
            echo "<script>alert('Ticket confirmed successfully.'); window.location='seller_accept.php';</script>";
        } else {
            echo "<script>alert('Failed to confirm ticket.');</script>";
        }
    } else {
        echo "<script>alert('Invalid or already confirmed order ID.');</script>";
    }
}

// Query to get pending ticket orders for the logged-in seller
$query = "
    SELECT o.id, o.buyer_name, o.ticket_id, o.price_offered, o.status, o.purchase_time,
           t.from_location, t.to_location, t.stime, t.etime, t.price
    FROM ticket_orders o
    JOIN tickets t ON o.ticket_id = t.tid
    WHERE t.sid = '$seller_id' AND o.status = 'Pending'
    ORDER BY o.purchase_time DESC
";

$result = mysqli_query($conn, $query);

if (!$result) {
    die("Query failed: " . mysqli_error($conn)); // You can remove this in production
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Seller - Accept Tickets</title>
    <style>
        body {
            background-image: url('images/bus4.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            height: 100vh;
        }
        h1 {
            text-align: center;
            margin-top: 30px;
        }
        table {
            width: 90%;
            margin: 30px auto;
            border-collapse: collapse;
            background: #fff;
            box-shadow: 0 0 10px #ccc;
        }
        th, td {
            padding: 12px;
            text-align: center;
            border: 1px solid #ddd;
        }
        th {
            background-color: #222;
            color: #fff;
        }
        a.button {
            padding: 6px 12px;
            background-color: green;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        a.button:hover {
            background-color: darkgreen;
        }
    </style>
</head>
<body>

<h1>Welcome <?php echo htmlspecialchars($_SESSION['uname']); ?> - Your Ticket Orders</h1>

<table>
    <tr>
        <th>Order ID</th>
        <th>Buyer Name</th>
        <th>From</th>
        <th>To</th>
        <th>Start Time</th>
        <th>End Time</th>
        <th>Price</th>
           
        <th>Action</th>
    </tr>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['buyer_name']); ?></td>
                <td><?php echo htmlspecialchars($row['from_location']); ?></td>
                <td><?php echo htmlspecialchars($row['to_location']); ?></td>
                <td><?php echo htmlspecialchars($row['stime']); ?></td>
                <td><?php echo htmlspecialchars($row['etime']); ?></td>
                <td><?php echo number_format($row['price']); ?></td>
               
               
                <td>
                    <a href="seller_accept.php?accept_id=<?php echo $row['id']; ?>" class="button">Accept</a>
                </td>
            </tr>
        <?php endwhile; ?>
    <?php else: ?>
        <tr><td colspan="10">No pending ticket orders for you.</td></tr>
    <?php endif; ?>
</table>

</body>
</html>
