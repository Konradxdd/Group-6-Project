<?php

if ($_SERVER["REQUEST METHOD"])=="POST"{
$firstName =($_POST['first_name']);
    $familyName = ($_POST['family_name']);
    $phone = ($_POST['phone']);
    $email = ($_POST['email']);
    $departure = ($_POST['departure']);
    $destination = ($_POST['destination']);
    $date = ($_POST['date']);
    $passengers =($_POST['number']);

    //booking confirm

    echo "<h1>Booking Confirmation</h1>";
    echo "<p><strong>First Name:</strong> $firstName</p>";
    echo "<p><strong>Family Name:</strong> $familyName</p>";
    echo "<p><strong>Phone:</strong> $phone</p>";
    echo "<p><strong>Email:</strong> $email</p>";
    echo "<p><strong>Departure City:</strong> $departure</p>";
    echo "<p><strong>Destination:</strong> $destination</p>";
    echo "<p><strong>Departure Date:</strong> $date</p>";
    echo "<p><strong>Number of Passengers:</strong> $passengers</p>";

    

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>booking page</title>
    <link  rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form for booking ">
        <h1> flight booking </h1>
        <form action="booking.php" method="post">

            <label for="name"> firstname :</label>
            <input type="text" id="name" name="name ">

            <label for="name"> family name :</label>
            <input type="text" id=" name" name="name ">

            <label for="phone"> phone number :</label>
            <input type="phone" id="phone" name="phone">
            i

            <label for="phone"> email :</label>
            <input type="email" id="email" name="email" placeholder="@gmail.com">


            <label for="departure">  departure city : </label>
            <input type="text" id="departure " name="departure">

            <label for="destination"> destination :</label>
            <input type="text" id="destination" name="destination">

            <label for="date"> departure date  :</label>
            <input type="" id="date" name="date">

            <label for="passenger"> number of passenger :</label>
            <input type="number" id="number" name="number">
            

            <button type="submit" > book now</button>
            <button type="reset" > reset </button>










        </form>

    </div>

    <!-- Footer -->
    <footer>
        <div class="footer-content">
            <p>&copy; 2025 Airline Booking. All rights reserved.</p>
    
</body>
</html>