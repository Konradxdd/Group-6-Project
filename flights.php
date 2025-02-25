<?php
include 'database.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flights</title>
    <link rel="stylesheet" href="style.css">
    <script src="flights.js" defer></script>
</head>
<body>
    
    <!-- Navigation Bar -->
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

    <!-- Flight Search Form -->
    <section id="flights" class="search-section">
        <h2>Find Your Flight</h2>
        <form onsubmit="fetchFlights(); return false;">
            <input type="text" id="departure" name="departure" placeholder="Departure City" required>
            <input type="text" id="destination" name="destination" placeholder="Destination City" required>
            <input type="date" id="flight_date" name="flight_date" required>
            <select id="flight_class" name="class" required>
                <option value="economy">Economy</option>
                <option value="business">Business</option>
                <option value="first">First Class</option>
            </select>
            <button type="submit" class="btn">Search</button>
        </form>
    </section>

    <!-- Flight List -->
    <section class="flight-list">
        <h2>Available Flights</h2>
        <table>
            <thead>
                <tr>
                    <th>Airline</th>
                    <th>Departure</th>
                    <th>Destination</th>
                    <th>Departure Time</th>
                    <th>Arrival Time</th>
                    <th>Price (£)</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody id="flight-results">
                <?php
                    if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["departure"]) && isset($_GET["destination"]) && isset($_GET["flight_date"])) {
                        $departure = $_GET["departure"];
                        $destination = $_GET["destination"];
                        $flight_date = $_GET["flight_date"];

                        $sql = "SELECT * FROM flights WHERE departure_city = ? AND destination_city = ? AND flight_date = ?";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("sss", $departure, $destination, $flight_date);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>
                                        <td>{$row['airline']}</td>
                                        <td>{$row['departure_city']}</td>
                                        <td>{$row['destination_city']}</td>
                                        <td>{$row['departure_time']}</td>
                                        <td>{$row['arrival_time']}</td>
                                        <td>{$row['price']}</td>
                                        <td>{$row['flight_date']}</td>
                                    </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7'>No flights found</td></tr>";
                        }
                    }
                    ?>
            </tbody>
        </table>
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