<?php
include "carbuyerheader.php";
include "config.php";

session_start();
if (!isset($_SESSION['csbid'])) {
    echo "<script>alert('Please login first'); window.location='carbuyerlogin.php';</script>";
    exit();
}

$buyer_id = $_SESSION['csbid'];
$uname = $_SESSION['uname'];
$buyer_email = $_SESSION['email'];

$where = [];

if (!empty($_GET['from_place'])) {
    $from = $conn->real_escape_string($_GET['from_place']);
    $where[] = "from_place LIKE '%$from%'";
}
if (!empty($_GET['to_place'])) {
    $to = $conn->real_escape_string($_GET['to_place']);
    $where[] = "to_place LIKE '%$to%'";
}
if (!empty($_GET['date'])) {
    $date = $conn->real_escape_string($_GET['date']);
    $where[] = "date = '$date'";
}
if (!empty($_GET['gender'])) {
    $gender = $conn->real_escape_string($_GET['gender']);
    $where[] = "gender = '$gender'";
}
if (!empty($_GET['price'])) {
    $price = $conn->real_escape_string($_GET['price']);
    $where[] = "price <= '$price'";
}
if (!empty($_GET['available_seat'])) {
    $seat = $conn->real_escape_string($_GET['available_seat']);
    $where[] = "available_seat >= '$seat'";
}

$condition = count($where) ? "WHERE " . implode(" AND ", $where) : "";
$sql = "SELECT * FROM car_seat $condition";
$result = $conn->query($sql);

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['book_seat'])) {
    $car_seat_id = $_POST['car_seat_id'];
    $passer_name = $conn->real_escape_string($_POST['passer_name']);
    $from_place = $conn->real_escape_string($_POST['from_place']);
    $to_place = $conn->real_escape_string($_POST['to_place']);
    $journey_date = $conn->real_escape_string($_POST['journey_date']);
    $passer_gender = $conn->real_escape_string($_POST['passer_gender']);
    $buyer_name = $conn->real_escape_string($_POST['buyer_name']);
    $buyer_gender = $conn->real_escape_string($_POST['buyer_gender']);
    $buyer_mobile = $conn->real_escape_string($_POST['buyer_mobile']);
    $seat_count = intval($_POST['seat_count']);

    $check_seat = $conn->query("SELECT available_seat FROM car_seat WHERE csid = $car_seat_id");
    if ($check_seat && $check_seat->num_rows > 0) {
        $row = $check_seat->fetch_assoc();
        if ($row['available_seat'] >= $seat_count) {
            $insert = "INSERT INTO seat_booking 
                (car_seat_id, passer_name, from_place, to_place, journey_date, passer_gender, buyer_name, buyer_gender, buyer_mobile, seat_count) 
                VALUES 
                ('$car_seat_id', '$passer_name', '$from_place', '$to_place', '$journey_date', '$passer_gender', '$buyer_name', '$buyer_gender', '$buyer_mobile', '$seat_count')";
            if ($conn->query($insert)) {
                $conn->query("UPDATE car_seat SET available_seat = available_seat - $seat_count WHERE csid = $car_seat_id");
                echo "<script>alert('Seat booked successfully!'); window.location.href='myseat.php';</script>";
                exit;
            } else {
                echo "<script>alert('Booking failed. Try again later.');</script>";
            }
        } else {
            echo "<script>alert('Not enough available seats!');</script>";
        }
    }
}

$show_booking_form = false;
if (isset($_GET['csid'])) {
    $car_seat_id = intval($_GET['csid']);
    $res = $conn->query("SELECT * FROM car_seat WHERE csid = $car_seat_id");
    if ($res && $res->num_rows > 0) {
        $booking_data = $res->fetch_assoc();
        $show_booking_form = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Buy Seat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: url('images/admin_log.jpg') no-repeat center center fixed;
            background-size: cover;
        }
        .container {
            padding: 10px;
        }
        .filter-box, .booking-form {
            background: #fff;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        table {
            background: #fff;
            border-radius: 10px;
        }
        th, td {
            text-align: center;
            vertical-align: middle;
        }
    </style>
</head>
<body>
<p class="text-center fw-bold mt-3">Welcome, <?php echo htmlspecialchars($uname); ?>!</p>
<div class="container">
    <h1 class="text-center mb-4">Buy a Seat</h1>

    <?php if ($show_booking_form): ?>
        <div class="booking-form">
            <h4 class="text-center mb-3">Booking Form</h4>
            <form method="POST">
                <input type="hidden" name="car_seat_id" value="<?= $booking_data['csid'] ?>">
                <input type="hidden" name="passer_name" value="<?= $booking_data['passer_name'] ?>">
                <input type="hidden" name="from_place" value="<?= $booking_data['from_place'] ?>">
                <input type="hidden" name="to_place" value="<?= $booking_data['to_place'] ?>">
                <input type="hidden" name="journey_date" value="<?= $booking_data['date'] ?>">
                <input type="hidden" name="passer_gender" value="<?= $booking_data['gender'] ?>">

                <div class="row g-3">
                    <div class="col-md-4">
                        <label>Passer Name</label>
                        <input class="form-control" value="<?= $booking_data['passer_name'] ?>" disabled>
                    </div>
                    <div class="col-md-4">
                        <label>From</label>
                        <input class="form-control" value="<?= $booking_data['from_place'] ?>" disabled>
                    </div>
                    <div class="col-md-4">
                        <label>To</label>
                        <input class="form-control" value="<?= $booking_data['to_place'] ?>" disabled>
                    </div>
                    <div class="col-md-4">
                        <label>Date</label>
                        <input class="form-control" value="<?= $booking_data['date'] ?>" disabled>
                    </div>
                    <div class="col-md-4">
                        <label>Passer Gender</label>
                        <input class="form-control" value="<?= $booking_data['gender'] ?>" disabled>
                    </div>
                    <div class="col-md-4">
                        <label>Your Name</label>
                        <input class="form-control" name="buyer_name" value="<?= htmlspecialchars($uname); ?>" readonly>
                    </div>
                    <div class="col-md-4">
                        <label>Your Gender</label>
                        <select class="form-select" name="buyer_gender" required>
                            <option value="">-- Select --</option>
                            <option>Male</option>
                            <option>Female</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label>Mobile No</label>
                        <input type="text" class="form-control" name="buyer_mobile" pattern="[0-9+]{10,15}" required>
                    </div>
                    <div class="col-md-4">
                        <label>Seat Count</label>
                        <input type="number" name="seat_count" class="form-control" min="1" max="<?= $booking_data['available_seat'] ?>" required>
                    </div>
                    <div class="col-12 text-center mt-3">
                        <button type="submit" name="book_seat" class="btn btn-success">Book Seat</button>
                    </div>
                </div>
            </form>
        </div>
    <?php endif; ?>

    <!-- Filter form -->
    <form method="GET" class="filter-box">
        <div class="row g-3">
            <div class="col-md-2">
                <label>From</label>
                <input type="text" name="from_place" class="form-control">
            </div>
            <div class="col-md-2">
                <label>To</label>
                <input type="text" name="to_place" class="form-control">
            </div>
            <div class="col-md-2">
                <label>Date</label>
                <input type="date" name="date" class="form-control">
            </div>
            <div class="col-md-2">
                <label>Gender</label>
                <select name="gender" class="form-select">
                    <option value="">-- Select --</option>
                    <option>Male</option>
                    <option>Female</option>
                </select>
            </div>
            <div class="col-md-2">
                <label>Max Price</label>
                <input type="number" name="price" class="form-control">
            </div>
            <div class="col-md-2">
                <label>Min Seats</label>
                <input type="number" name="available_seat" class="form-control">
            </div>
            <div class="col-12 text-center mt-3">
                <button class="btn btn-primary">Search</button>
            </div>
        </div>
    </form>

    <!-- Results Table -->
    <?php if ($result && $result->num_rows > 0): ?>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Passer Name</th>
                        <th>From</th>
                        <th>To</th>
                        <th>Date</th>
                        <th>Gender</th>
                        <th>Available Seat</th>
                        <th>Price</th>
                        <th>Book</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['passer_name']); ?></td>
                            <td><?= htmlspecialchars($row['from_place']); ?></td>
                            <td><?= htmlspecialchars($row['to_place']); ?></td>
                            <td><?= htmlspecialchars($row['date']); ?></td>
                            <td><?= htmlspecialchars($row['gender']); ?></td>
                            <td><?= $row['available_seat']; ?></td>
                            <td><?= $row['price']; ?></td>
                            <td>
                                <a href="buyseat.php?csid=<?= $row['csid']; ?>" class="btn btn-sm btn-primary">Book</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <p class="text-center text-danger">No seats available for selected criteria.</p>
    <?php endif; ?>
</div>
</body>
</html>