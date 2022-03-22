<?php
if(isset($_POST['submit'])){
    if(!empty($_SESSION['connect']) && $_SESSION['connect'] == 'client'){
        if(!empty($_SESSION['userId'])){
            $clientId = htmlspecialchars($_SESSION['userId']);
            if(!empty($_POST['suite']) &&
                !empty($_POST['startDate']) &&
                !empty($_POST['endDate'])
            ){
                //VARIABLES
                $suiteId = htmlspecialchars($_POST['suite']);
                $startDate = htmlspecialchars($_POST['startDate']);
                $endDate = htmlspecialchars($_POST['endDate']);
                $now = date('Y-m-d');
                if($startDate > $now && $startDate < $endDate){
                    // INSERTION BDD
                    $booking = $bdd->prepare('INSERT INTO bookings (startDate, endDate, suite_id, client_id) 
                                    VALUES (:sd, :ed, :sid, :cid);');
                    $booking->bindValue(':sd', $startDate, PDO::PARAM_STR);
                    $booking->bindValue(':ed', $endDate, PDO::PARAM_STR);
                    $booking->bindValue(':sid', $suiteId, PDO::PARAM_INT);
                    $booking->bindValue(':cid', $clientId, PDO::PARAM_INT);
                    $booking->execute();
                    header('location:./myBookings.php');
                } else {
                    header('location:./booking.php?error=invalid');
                }
            }   
        }
    } else {
        header('location:./booking.php?error=connexion');
    }
    
    
}