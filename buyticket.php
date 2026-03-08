<?php
session_start();
include "config.php";
include "buyerheader.php";

if (!isset($_SESSION['email'])) {
    header("Location: buyerlogin.php");
    exit();
}

$email = $_SESSION['email'];
$bname = $_SESSION['buyer_name'];

// Handle Buy Now
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['buy'])) {
    $ticket_id = mysqli_real_escape_string($conn, $_POST['ticket_id']);
    $result = mysqli_query($conn, "SELECT * FROM tickets WHERE tid = '$ticket_id'");
    if ($row = mysqli_fetch_assoc($result)) {
        $price = $row['price'];
        $tdate = $row['tdate'];
        $stime = $row['stime'];
        $etime = $row['etime'];

        $insert = mysqli_query($conn, "
            INSERT INTO ticket_orders (buyer_name, buyer_email, ticket_id, price_offered, tdate, stime, etime, status)
            VALUES ('$bname', '$email', '$ticket_id', '$price', '$tdate', '$stime', '$etime', 'Pending')
        ");

        if ($insert) {
            echo "<script>alert('Ticket purchased successfully!'); window.location='buyticket.php';</script>";
            exit();
        } else {
            echo "<script>alert('Failed to purchase ticket.');</script>";
        }
    } else {
        echo "<script>alert('Ticket not found.');</script>";
    }
}

// Search filters
$from = isset($_GET['from']) ? $_GET['from'] : '';
$to = isset($_GET['to']) ? $_GET['to'] : '';
$price = isset($_GET['price']) ? $_GET['price'] : '';
$date = isset($_GET['tdate']) ? $_GET['tdate'] : '';

$query = "SELECT * FROM tickets WHERE 1=1";

if (!empty($from)) {
    $query .= " AND from_location LIKE '%" . mysqli_real_escape_string($conn, $from) . "%'";
}
if (!empty($to)) {
    $query .= " AND to_location LIKE '%" . mysqli_real_escape_string($conn, $to) . "%'";
}
if (!empty($price)) {
    if ($price == '1001') {
        $query .= " AND price > 1000";
    } else {
        $query .= " AND price <= " . mysqli_real_escape_string($conn, $price);
    }
}
if (!empty($date)) {
    $query .= " AND tdate = '" . mysqli_real_escape_string($conn, $date) . "'";
}

$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Buy Ticket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap');

body {
    background: url('images/bus5.jpg') no-repeat center center fixed;
    background-size: cover;
    font-family: 'Poppins', sans-serif;
    position: relative;
    margin: 0;
    padding: 0;
}

body::before {
    content: "";
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(10, 10, 10, 0.6); /* Darker overlay for contrast */
    z-index: -1;
}

.container {
    padding-top: 30px;
    padding-bottom: 30px;
}

.search-box {
    background: rgba(255, 255, 255, 0.95);
    padding: 35px;
    border-radius: 20px;
    box-shadow: 0 6px 25px rgba(0, 0, 0, 0.15);
    transition: 0.3s;
}

.search-box h3 {
    font-weight: 700;
    color: #002855;
    margin-bottom: 20px;
}

label {
    font-weight: 500;
    color: #333;
}

.form-control, .form-select {
    border-radius: 10px;
    height: 40px;
    font-size: 0.95rem;
}

button[type="submit"] {
    font-weight: 600;
    background-color: #004080;
    color: #fff;
    border: none;
    padding: 10px 15px;
    transition: 0.3s;
    border-radius: 8px;
}

button[type="submit"]:hover {
    background-color: #0b6abf;
}

.table-responsive {
    background-color: rgba(255, 255, 255, 0.95);
    padding: 25px;
    border-radius: 20px;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
    margin-top: 20px;
}

table.table {
    margin: 0;
}

.table thead {
    background-color: #002855;
    color: white;
}

.table th, .table td {
    text-align: center;
    vertical-align: middle;
    padding: 12px;
}

.table-hover tbody tr:hover {
    background-color: #e3f2fd;
}

.btn-success {
    background-color: #28a745;
    border: none;
    padding: 6px 12px;
    font-weight: 500;
    font-size: 0.9rem;
    border-radius: 6px;
    transition: 0.3s;
}

.btn-success:hover {
    background-color: #218838;
}

.text-center.fw-bold {
    font-size: 1.25rem;
    color: white;
    margin-bottom: 20px;
    background: rgba(0, 0, 0, 0.3);
    padding: 10px;
    border-radius: 10px;
}
</style>


</head>
<body>

<div class="container">
    <p class="text-center fw-bold">Welcome, <?php echo htmlspecialchars($bname); ?>!</p>

    <div class="search-box mb-4">
        <h3 class="mb-3 text-center">Search Available Tickets</h3>
        <form method="GET" action="buyticket.php" class="row g-3">
            <div class="col-md-3">
                <label class="form-label">From</label>
                <input type="text" name="from" value="<?php echo htmlspecialchars($from); ?>" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="form-label">To</label>
                <input type="text" name="to" value="<?php echo htmlspecialchars($to); ?>" class="form-control">
            </div>
            <div class="col-md-3">
                <label class="form-label">Price</label>
                <select name="price" class="form-select">
                    <option value="">Select</option>
                    <option value="500" <?php if ($price == '500') echo 'selected'; ?>>Below ₹500</option>
                    <option value="1000" <?php if ($price == '1000') echo 'selected'; ?>>Below ₹1000</option>
                    <option value="1001" <?php if ($price == '1001') echo 'selected'; ?>>Above ₹1000</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label">Date</label>
                <input type="date" name="tdate" value="<?php echo htmlspecialchars($date); ?>" class="form-control">
            </div>
            <div class="col-md-12 d-grid mt-2">
                <button type="submit" class="btn">Search Ticket</button>
            </div>
        </form>
    </div>

    
    <div class="table-responsive">
    <h3 class="mb-3 text-center">Available Tickets</h3>
        <table class="table table-bordered table-hover bg-white">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Passer Name</th>
                    <th>From</th>
                    <th>To</th>
                    <th>Price</th>
                    <th>Date</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Buy</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <form method="POST" action="buyticket.php">
                                <td><?php echo $row['tid']; ?></td>
                                <td><?php echo htmlspecialchars($row['name']); ?></td>
                                <td><?php echo htmlspecialchars($row['from_location']); ?></td>
                                <td><?php echo htmlspecialchars($row['to_location']); ?></td>
                                <td><?php echo $row['price']; ?></td>
                                <td><?php echo $row['tdate']; ?></td>
                                <td><?php echo $row['stime']; ?></td>
                                <td><?php echo $row['etime']; ?></td>
                                <td>
                                    <input type="hidden" name="ticket_id" value="<?php echo $row['tid']; ?>">
                                    <button type="submit" name="buy" class="btn btn-success btn-sm">Buy Now</button>
                                </td>
                            </form>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="9" class="text-center">No tickets found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
