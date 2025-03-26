<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstName = $_POST['first_name'];
    $familyName = $_POST['family_name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $departure = $_POST['departure'];
    $destination = $_POST['destination'];
    $date = $_POST['date'];
    $passengers = $_POST['number'];

    // Booking Confirmation
    echo "<h1>Booking Confirmation</h1>";
    echo "<p><strong>First Name:</strong> $firstName</p>";
    echo "<p><strong>Family Name:</strong> $familyName</p>";
    echo "<p><strong>Phone:</strong> $phone</p>";
    echo "<p><strong>Email:</strong> $email</p>";
    echo "<p><strong>Departure City:</strong> $departure</p>";
    echo "<p><strong>Destination:</strong> $destination</p>";
    echo "<p><strong>Departure Date:</strong> $date</p>";
    echo "<p><strong>Number of Passengers:</strong> $passengers</p>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-container">
        <h1>Flight Booking</h1>
        <form action="booking.php" method="post">

            <label for="first_name">First Name:</label>
            <input type="text" id="first_name" name="first_name" required>

            <label for="family_name">Family Name:</label>
            <input type="text" id="family_name" name="family_name" required>

            <label for="phone">Phone Number:</label>
            <input type="tel" id="phone" name="phone" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="example@gmail.com" required>

            <label for="departure">Departure City:</label>
            <input type="text" id="departure" name="departure" required>

            <label for="destination">Destination:</label>
            <input type="text" id="destination" name="destination" required>

            <label for="date">Departure Date:</label>
            <input type="date" id="date" name="date" required>

            <label for="number">Number of Passengers:</label>
            <input type="number" id="number" name="number" min="1" required>

            <button type="submit">Book Now</button>
            <button type="reset">Reset</button>
        </form>
    </div>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <p>&copy; 2025 Airline Booking. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
