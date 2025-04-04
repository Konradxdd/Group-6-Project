<?php
session_start();
include 'database.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: authorize.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM bookings WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Bookings</title>
    <link rel="stylesheet" href="styles.css">
</head>
<style>
    h2 {
    text-align: center;
    color: #333;
    padding: 20px;
    }

    a {
    color: #007bff;
    text-decoration: none;
    }

    a:hover {
        text-decoration: underline;
    }

    table {
        width: 80%;
        margin: 20px auto;
        border-collapse: collapse;
        background-color: #ffffff;
        box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    }

    th, td {
        padding: 12px 15px;
        text-align: left;
        border: 1px solid #ddd;
    }

    th {
        background-color: #007bff;
        color: white;
    }

    tr:nth-child(even) {
        background-color: #f9f9f9;
    }

    tr:hover {
        background-color: #f1f1f1;
    }

</style>
<body>
    <h2>My Flight Bookings</h2>

    <?php if ($result->num_rows == 0): ?>
        <p>You have no bookings at the moment.</p>
    <?php else: ?>
        <table border="1">
            <tr>
                <th>Flight ID</th>
                <th>Departure</th>
                <th>Destination</th>
                <th>Seat Number</th>
                <th>Booking Date</th>
                <th>Status</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['flight_id']); ?></td>
                <td><?php echo substr($row['flight_id'], 0, 2); ?></td>
                <td><?php echo substr($row['flight_id'], 2, 2); ?></td>
                <td><?php echo htmlspecialchars($row['seat_number']); ?></td>
                <td><?php echo htmlspecialchars($row['booking_date']); ?></td>
                <td><?php echo htmlspecialchars($row['booking_status']); ?></td>
            </tr>
            <?php endwhile; ?>
        </table>
    <?php endif; ?>

    <a href="logout.php">Logout</a>
</body>
</html>
 
