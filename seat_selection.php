<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flight Seat Selection</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Navigation Bar -->
    <header>
        <nav>
            <div class="logo">Polish Air</div>
            <ul class="nav-links">
                <li><a href="index.html">Home</a></li>
                <li><a href="flights.php">Flights</a></li>
                <li><a href="#">About Us</a></li>
                <li><a href="contact.html" class="active">Contact</a></li>
                <li><a href="login.html">Login</a></li>
                <li><a href="register.html" class="btn">Sign Up</a></li>
            </ul>
        </nav>
    </header>

    <!-- Seat Section -->
    <section class="seat-section">
        <div class="container">
            <h2>Select Your Seat</h2>
            
            <div class ="plane">
                <div class="seats">
                    <?php
                    include 'database.php';

                    $rows = ['A', 'B', 'C', 'D', 'E', 'F'];
                    $columns = 6; 

                    for ($i = 1; $i <= 10; $i++) {
                        echo "<div class='row'>";
                        foreach ($rows as $seat) {

                            if ($seat === 'D') {
                                echo "<div class='gap'></div>";
                            }
                            $seat_id = $seat . $i;
                            
                            $check = mysqli_query($conn, "SELECT * FROM bookings WHERE seat_number='$seat_id'");
                            $occupied = mysqli_num_rows($check) > 0 ? "occupied" : "";  

                            echo "<div class='seat $occupied' id='$seat_id' data-seat='$seat_id'>$seat_id</div>";
                        }
                        echo "</div>";
                    }
                    ?>
                </div>
            </div>

            <button id="confirm-btn">Confirm Selection</button>
    
            <script src="seat.js"></script>

        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
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
