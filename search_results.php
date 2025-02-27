<?php
include('db.php');

$departure = isset($_GET['departure']) ? $_GET['departure'] : '';
$destination = isset($_GET['destination']) ? $_GET['destination'] : '';
$date = isset($_GET['date']) ? $_GET['date'] : ''; 


$date_time = $date . " 00:00:00";

$query = "SELECT * FROM flights WHERE departure_city = '$departure' AND destination_city = '$destination' AND departure_time >= '$date_time'";


$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Search Results</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
  
    <header>
        <nav>
            <div class="logo">Polish Air</div>
            <ul class="nav-links">
                <li><a href="index.html">Home</a></li>
                <li><a href="#">Flights</a></li>
                <li><a href="#">About Us</a></li>
                <li><a href="contact.html" class="active">Contact</a></li>
                <li><a href="login.html">Login</a></li>
                <li><a href="register.html" class="btn">Sign Up</a></li>
            </ul>
        </nav>
    </header>

  
    <section id="results" class="results-section">
        <h2>Search Results</h2>

        <div class="results-container">
            <?php
            
            if (mysqli_num_rows($result) > 0) {
                
                while ($flight = mysqli_fetch_assoc($result)) {
                    echo "<div class='flight-result'>";
                    echo "<p><strong>Flight ID:</strong> " . $flight["flight_id"] . "</p>";
                    echo "<p><strong>Departure:</strong> " . $flight["departure_time"] . "</p>";
                    echo "<p><strong>Arrival:</strong> " . $flight["arrival_time"] . "</p>";
                    echo "<p><strong>Price:</strong> $" . $flight["price"] . "</p>";
                    echo "<p><strong>Available Seats:</strong> " . $flight["available_seats"] . "</p>";
                    echo "<button class='btn'>Book Now</button>";
                    echo "</div>";
                }
            } else {
               
                echo "<p>No matching flights found.</p>";
            }

            
            mysqli_close($conn);
            ?>
        </div>
    </section>

    <footer>
        <div class="footer-content">
            <p>&copy; 2025 Polish Air. All rights reserved.</p>
            <ul class="social-links">
                <li><a href="#">Facebook</a></li>
                <li><a href="#">Twitter</a></li>
                <li><a href="#">Instagram</a></li>
            </ul>
        </div>
    </footer>
</body>
</html>
