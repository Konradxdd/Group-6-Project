<?php
include 'database.php';

$departure = isset($_GET['departure']) ? $_GET['departure'] : '';
$destination = isset($_GET['destination']) ? $_GET['destination'] : '';
$date = isset($_GET['date']) ? $_GET['date'] : '';

$query = "SELECT * FROM flights WHERE 1";

if (!empty($departure)) {
    $query .= " AND departure LIKE '%$departure%'";
}
if (!empty($destination)) {
    $query .= " AND destination LIKE '%$destination%'";
}
if (!empty($date)) {
    $query .= " AND flight_date = '$date'";
}

$result = $conn->query($query);
$flights = [];

while ($row = $result->fetch_assoc()) {
    $flights[] = $row;
}

echo json_encode($flights);
$conn->close();
?>
