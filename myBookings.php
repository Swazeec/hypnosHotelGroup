<?php
session_start();
require_once('./components/db/db.php');
require_once('./components/myBookingsScript.php');
if(isset($_SESSION['connect'])){
    if($_SESSION['connect'] == 'client'){
        require_once('./components/header/header-client.php');
        $clientId = $_SESSION['userId'];
    } else if ($_SESSION['connect'] == 'pro'){
        require_once('./components/header/header-pro.php');
    } else {
        header('location:./index.php');    
    }
} else {
    header('location:./loginClient.php'); 
}
?>
<section class="row  px-lg-5">
    <!-- présentation du groupe -->
    <div class="col-md-6 d-none d-md-block text-center align-self-center">
        <img class="img-fluid" src="./assets/img/hypnos-hotel-flower.svg" alt="illustration, fleurs">
    </div>
    <div class="col-12 col-md-6">
        <h2 class="text-tilered mb-5">Mes réservations</h2>
        <h4 class="text-gold mb-3">Bonjour <?= $_SESSION['user'] ?> !</h4>
        <p>Retrouvez sur cette page l’historique de vos réservations dans nos hôtels Hypnos ! <br>Votre satisfaction étant au centre de nos préoccupations, n’hésitez pas à nous contacter en cas de besoin.</p>
    </div>
    <!-- ornement -->
    <div class="col-12 my-5 text-center">
        <img class="img-fluid px-5" src="./assets/img/hypnos-section-ornament.svg" alt="ornement">
    </div>
    <!-- affichage des réservations -->
    <?php
        $bdd->query('SET lc_time_names = \'fr_FR\'');
        $bookingsReq = $bdd->prepare('SELECT bookings.id AS id, 
                                    DATE_FORMAT(bookings.startDate, "%d/%m/%Y") AS startDate, 
                                    DATE_FORMAT(bookings.endDate, "%d/%m/%Y" ) AS endDate,
                                   /*  DATE_FORMAT(bookings.cancellationDate, "%d/%m/%Y" ) AS  */bookings.cancellationDate, 
                                    suites.title, 
                                    hotels.name
                                    FROM bookings 
                                    JOIN suites ON suites.id = bookings.suite_id
                                    JOIN hotels ON hotels.id = suites.hotel_id
                                    WHERE client_id = :cid
                                    ORDER BY startDate DESC;');
        $bookingsReq->bindValue(':cid', $clientId, PDO::PARAM_INT);
        $bookingsReq->execute();
        $count = $bookingsReq->rowCount();
        if($count ===0){ ?>
            <h2 class="col-12 text-md-center text-tilered pb-5">Vous n'avez jamais réservé chez nous !</h2>
        <?php } else {
            while($booking = $bookingsReq->fetch(PDO::FETCH_ASSOC)){ ?>
                <article class="col-12 col-md-4 mb-3">
                    <div class="card h-100">
                        <div class="card-body d-flex flex-column justify-content-between">
                            <div class="mb-3">
                                <h4 class="card-title text-gold"><?= $booking['name'] ?></h4>
                                <p class="card-text mb-2 text-lgrey">Suite <?= $booking['title'] ?></p>
                                <p class="card-text">Arrivée : <?= $booking['startDate'] ?></p>
                                <p class="card-text">Départ : <?= $booking['endDate'] ?></p>
                            </div>
                            <!-- SI ON PEUT ANNULER, AFFICHER BOUTON -->
                            <?php
                            $today = date('Y-m-d');
                            if($today < $booking['cancellationDate']){ ?>
                                <div class="text-end">
                                    <a type="button" href="./myBookings.php?delete=<?=$booking['id'] ?>" class="btn bg-offwhite border-gold rounded-pill text-gold px-5">Annuler</a>
                                </div>
                            <?php }
                            ?>
                        </div>
                    </div>
                </article>

            <?php }
        }
    ?>

</section>

<?php
require_once('./components/footer.php');
?>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>