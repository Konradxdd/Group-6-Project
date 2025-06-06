<?php
session_start();
include 'database.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flights</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="flights.js" defer></script>
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

    <!-- Flight Search Form -->
    <section id="flights" class="search-section">
        <h2>Find Your Flight</h2>
        <form onsubmit="fetchFlights(); return false;">
            <!-- Departure City Dropdown -->
            <select id="departure" name="departure" required onchange="updateDestinationCities();">
                <option value="">Select Departure City</option>
                <?php
                $sql = "SELECT DISTINCT departure FROM flights ORDER BY departure";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row['departure'] . "'>" . $row['departure'] . "</option>";
                    }
                } else {
                    echo "<option value=''>No departure cities found</option>";
                }
                ?>
            </select>

            <!-- Destination City Dropdown (Empty initially) -->
            <select id="destination" name="destination" required>
                <option value="">Select Destination City</option>
            </select>

            <!-- Flight Date Picker -->
            <input type="date" id="flight_date" name="flight_date" required>

            <!-- Flight Class Dropdown -->
            <select id="flight_class" name="class" required>
                <option value="economy">Economy</option>
                <option value="business">Business</option>
                <option value="first">First Class</option>
            </select>

            <!-- Search Button -->
            <button type="submit" class="btn">Search</button>
        </form>
    </section>



    <!-- Flight List -->
    <section class="flight-list">
        <h2>Available Flights</h2>
        <div id="flight-results" class="flight-container">
            <?php
                if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["departure"]) && isset($_GET["destination"]) && isset($_GET["flight_date"])) {
                    $departure = $_GET["departure"];
                    $destination = $_GET["destination"];
                    $flight_date = $_GET["flight_date"];

                    $sql = "SELECT * FROM flights WHERE departure = ? AND destination = ? AND flight_date = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("sss", $departure, $destination, $flight_date);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            $flight_id = $row['id'];

                            echo "<div class='flight-card'>";
                            echo "<div class='flight-details'>";
                            echo "<strong>{$row['airline']}</strong>";
                            echo "<p>{$row['departure']} ➝ {$row['destination']}</p>";
                            echo "<p>Departure: {$row['departure_time']} | Arrival: {$row['arrival_time']}</p>";
                            echo "<p class='flight-price'>€{$row['price']}</p>";
                            echo "</div>";

                            if (!isset($_SESSION['username'])) {
                                echo "<a href='authorize.php?redirect=booking.php&flight_id={$row['id']}' class='book-btn'>Login to Book</a>";
                            } else {
                                echo "<a href='booking.php?flight_id={$row['id']}' class='book-btn'>Book Now</a>";
                            }

                            echo "</div>";
                        }
                    } else {
                        echo "<p>No flights found</p>";
                    }
                }
            ?>
        </div>
    </section>

     <!-- Footer -->
     <footer class="flights-footer">
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
