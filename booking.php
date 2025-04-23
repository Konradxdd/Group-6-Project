<?php
session_start();
include 'database.php';

if (!isset($_SESSION['username'])) {
    header("Location: authorize.php");
    exit();
}

if (!isset($_GET['flight_id'])) {
    echo "Invalid request.";
    exit();
}

$flight_id = $_GET['flight_id'];
$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM flights WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $flight_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows !== 1) {
    echo "Flight not found.";
    exit();
}

$flight = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $_SESSION['flight_id'] = $flight_id;
    header("Location: seat_selection.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Contact Us</title>
</head>
<body>

    <!-- Navigation Bar -->
    <header>
        <nav>
            <div class="logo">Polish Air</div>
            <ul class="nav-links">
                <li><a href="index.html">Home</a></li>
                <li><a href="flights.php">Flights</a></li>
                <li><a href="about.html">About Us</a></li>
                <li><a href="contact.html" class="active">Contact</a></li>
                <li><a href="authorize.php" class="active">Login / Register</a></li>
                <li><a href="profile.php">My Bookings</a></li>
                <li><a href="logout.php" class="logout">Logout</a></li>
            </ul>
        </nav>
    </header>

    <!-- Booking Form -->
    <section class="booking-section">
        <div class="flight-details">
            <h2>Confirm Your Booking</h2>
            <p><strong>Airline:</strong> <?php echo $flight['airline']; ?></p>
            <p><strong>Route:</strong> <?php echo $flight['departure']; ?> ➝ <?php echo $flight['destination']; ?></p>
            <p><strong>Date:</strong> <?php echo $flight['flight_date']; ?></p>
            <p><strong>Departure:</strong> <?php echo $flight['departure_time']; ?></p>
            <p><strong>Arrival:</strong> <?php echo $flight['arrival_time']; ?></p>
            <p><strong>Price:</strong> €<?php echo $flight['price']; ?></p>

            <form method="POST">
                <button type="submit" class="btn">Confirm Booking</button>
            </form>

        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer-booking">
            <p>&copy; 2025 Airline Booking. All rights reserved.</p>
            <ul class="social-links">
                <li><a href="#">Facebook</a></li>
                <li><a href="#">Twitter</a></li>
                <li><a href="#">Instagram</a></li>
            </ul>
        </div>
    </footer>

</body>
</html>
