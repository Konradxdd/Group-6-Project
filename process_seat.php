<?php
include 'database.php';

if (isset($_POST['seat'])) {
    $seat = $_POST['seat'];

    $check = mysqli_query($conn, "SELECT * FROM bookings WHERE seat_number='$seat'");
    if (mysqli_num_rows($check) > 0) {
        echo "failed";
    } else {
        mysqli_query($conn, "INSERT INTO bookings (seat_number) VALUES ('$seat')");
        echo "success";
    }
}
?>
