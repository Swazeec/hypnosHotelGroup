<?php
require_once('./components/db/db.php');

$data=[];
$allBookings = $bdd->prepare('SELECT * FROM bookings');
$allBookings->execute();
while ($booking = $allBookings->fetch(PDO::FETCH_ASSOC)){
    array_push($data, $booking);
}
echo json_encode($data);