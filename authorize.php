<?php
session_start();

if (isset($_SESSION['username'])) {
    if ($_SESSION['role'] == 'staff') {
        header("Location: staff_page.php");
    } else {
        header("Location: customer_page.php");
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login / Register</title>
    <link rel="stylesheet" href="style.css">
    <script>
        function toggleForm(formType) {
            if (formType === 'login') {
                document.getElementById('loginForm').style.display = 'block';
                document.getElementById('registerForm').style.display = 'none';
            } else {
                document.getElementById('loginForm').style.display = 'none';
                document.getElementById('registerForm').style.display = 'block';
            }
        }
    </script>
</head>
<body>


    <header>
        <nav>
            <div class="logo">Polish Air</div>
            <ul class="nav-links">
                <li><a href="index.html">Home</a></li>
                <li><a href="flights.php">Flights</a></li>
                <li><a href="about.html">About Us</a></li>
                <li><a href="contact.html">Contact</a></li>
                <li><a href="authorize.php" class="active">Login / Register</a></li>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    
    <section class="auth-container">
        
        <section class="login-section">
            <div id="loginForm" class="container">
                <h2>Login</h2><br>
                <form action="process_login.php" method="POST">
                    <label for="username">Username:</label><br>
                    <input type="text" id="username" name="username" required><br><br>

                    <label for="password">Password:</label><br>
                    <input type="password" id="password" name="password" required><br><br>

                    <button type="submit">Login</button><br><br>
                </form>
                <p>Don't have an account? <a href="javascript:void(0);" onclick="toggleForm('register')">Sign Up</a></p>
            </div>
        </section>
        
        <section class="registration-section">
            <div id="registerForm" class="container" style="display: none;">
                <h2>Register</h2><br><br>
                <form action="process_registration.php" method="POST">
                    <label for="username">Username:</label><br>
                    <input type="text" id="username" name="username" required><br><br>

                    <label for="email">Email:</label><br>
                    <input type="email" id="email" name="email" required><br><br>

                    <label for="password">Password:</label><br>
                    <input type="password" id="password" name="password" required><br><br>

                    <label for="confirm_password">Confirm Password:</label><br>
                    <input type="password" id="confirm_password" name="confirm_password" required><br><br>

                    <button type="submit">Register</button><br><br>
                </form>
                <p>Already have an account? <a href="javascript:void(0);" onclick="toggleForm('login')">Login</a></p>
            </div>
        </section>

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
