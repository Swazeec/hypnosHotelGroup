<?php
if(!empty($_GET['delete']) && intval($_GET['delete'])){
    $clientID = $_SESSION['userId'];
    $bookingId = htmlspecialchars($_GET['delete']);
    $bookingReq = $bdd->prepare('SELECT * FROM bookings WHERE id = :id AND client_id = :cid');
    $bookingReq->bindValue(':id', $bookingId, PDO::PARAM_INT);
    $bookingReq->bindValue(':cid', $clientID, PDO::PARAM_INT);
    $bookingReq->execute();
    $bCount = $bookingReq->rowCount();
    if($bCount == 1){
        $bookingInfos = $bookingReq->fetch(PDO::FETCH_ASSOC);
        $now = date('Y-m-d');
        if($now < $bookingInfos['cancellationDate']){
            $bDeleteReq = $bdd->prepare('DELETE FROM bookings WHERE id = :id;');
            $bDeleteReq->bindValue(':id', $bookingId, PDO::PARAM_INT);
            $bDeleteReq->execute();
            header('location:./myBookings.php?delete=success');
        } else {
            header('location:./myBookings.php?error=invalid');
        }
    } else {
        header('location:./myBookings.php?error=invalid');
    }
}