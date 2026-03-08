<?php
session_start();
include "config.php";

if (!isset($_SESSION['uid'])) {
    echo "<script>alert('Please login to book a ticket.'); window.location.href='login.php';</script>";
    exit;
}

if (isset($_GET['tid'])) {
    $tid = $_GET['tid'];
    $buyer_id = $_SESSION['uid'];

    // Check if already booked
    $check = mysqli_query($conn, "SELECT * FROM booking WHERE tid='$tid' AND buyer_id='$buyer_id'");
    if (mysqli_num_rows($check) > 0) {
        echo "<script>alert('You have already booked this ticket.'); window.location.href='vticket.php';</script>";
    } else {
        mysqli_query($conn, "INSERT INTO booking (tid, buyer_id, status) VALUES ('$tid', '$buyer_id', 'Pending')");
        echo "<script>alert('Ticket booking request sent (Pending).'); window.location.href='vticket.php';</script>";
    }
}
?>
