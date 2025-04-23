<?php
include '../database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $booking_id = $_POST['booking_id'];
    $action = $_POST['action'];

    if (in_array($action, ['Approved', 'Rejected'])) {
        $stmt = $conn->prepare("UPDATE bookings SET refund_status = ? WHERE booking_id = ?");
        $stmt->bind_param("si", $action, $booking_id);
        $stmt->execute();
    }
}

$query = "SELECT b.booking_id, b.user_id, b.flight_id, b.refund_requested, b.refund_status, b.refund_amount, f.flight_date
          FROM bookings b
          JOIN flights f ON b.flight_id = f.id
          WHERE b.refund_requested = 1";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Refund Management | Staff</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="staff.css">
</head>
<body>
    <div class="sidebar">
        <h2>Staff Dashboard</h2>
        <ul>
            <li><a href="staff.html">Dashboard</a></li>
            <li><a href="manageflights.html">Manage Flights</a></li>
            <li><a href="staffm.html">Staff Management</a></li>
            <li><a href="staffprofile.html">Profile</a></li>
            <li><a href="refunds.php" class="active">Manage Refunds</a></li>
            <li><a href="../logout.php" class="logout">Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <header>
            <h1>Refund Requests</h1>
        </header>

        <?php if ($result->num_rows === 0): ?>
            <p>No refund requests found.</p>
        <?php else: ?>
            <table>
                <tr>
                    <th>Booking ID</th>
                    <th>User ID</th>
                    <th>Flight ID</th>
                    <th>Flight Date</th>
                    <th>Refund Amount</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['booking_id']; ?></td>
                        <td><?php echo $row['user_id']; ?></td>
                        <td><?php echo $row['flight_id']; ?></td>
                        <td><?php echo $row['flight_date']; ?></td>
                        <td>&euro;<?php echo $row['refund_amount']; ?></td>
                        <td><?php echo $row['refund_status']; ?></td>
                        <td>
                            <?php if ($row['refund_status'] === 'Pending'): ?>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="booking_id" value="<?php echo $row['booking_id']; ?>">
                                    <button name="action" value="Approved">Approve</button>
                                    <button name="action" value="Rejected">Reject</button>
                                </form>
                            <?php else: ?>
                                <span><?php echo $row['refund_status']; ?></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>
