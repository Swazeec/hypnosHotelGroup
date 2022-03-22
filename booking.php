<?php
session_start();
require_once('./components/db/db.php');
require_once('./components/bookingScript.php');
if(isset($_SESSION['connect'])){
    if($_SESSION['connect'] == 'client'){
        require_once('./components/header/header-client.php');
    } else if ($_SESSION['connect'] == 'pro'){
        require_once('./components/header/header-pro.php');
    } else {
        require_once('./components/header/header-noauth.php');
    }
} else {
    require_once('./components/header/header-noauth.php');
}
if(!empty($_GET['error']) && $_GET['error'] == 'invalid'){ ?>
    <div class="row py-2 text-center bg-danger">
        <p class="text-white m-0">Votre demande n'a pas été envoyée. Merci d'entrer des informations valides.</p>
    </div>
<?php }
if(!empty($_GET['error']) && $_GET['error'] == 'connexion'){ ?>
    <div class="row py-2 text-center bg-danger">
        <p class="text-white m-0">Votre demande n'a pas été envoyée. Merci de vous connecter avant de réserver.</p>
    </div>
<?php }
?>
<section class="row px-lg-5 mt-5" >
    <!-- présentation -->
    <div class="col-md-6 d-none d-md-block text-center align-self-center">
        <img class="img-fluid" src="./assets/img/hypnos-hotel-flower.svg" alt="illustration, fleurs">
    </div>
    <div class="col-12 col-md-6">
        <h2 class="text-tilered mb-5">Réserver une suite</h2>
        <p>Pour réserver, rien de plus simple !</p>
        <p>Sélectionnez votre hôtel, votre suite, les dates de votre visite, et validez !</p>
        <p>Attention, vous devez avoir un compte client et être connecté pour pouvoir effectuer votre réservation</p>
    </div>
    <!-- ornement -->
    <div class="col-12 my-5 text-center">
        <img class="img-fluid px-5" src="./assets/img/hypnos-section-ornament.svg" alt="ornement">
    </div>

    <!-- RESERVER -->
    <div class="col-12 col-md-8 offset-md-2 col-lg-6 offset-lg-3">
        <form action="" method="post" class="row" id="bookingForm">
            <div class="mb-3 col-12">
                <label for="suite" class="form-label text-gold">Votre suite</label>
                <select class="form-select " id="suite" name="suite" required>
                    <?php
                    // POUR AFFICHAGE SUITES
                    $suitesReq = $bdd->prepare('SELECT suites.id AS id, suites.title AS suite, hotels.name AS hotel, hotels.city
                                                FROM suites
                                                JOIN hotels ON hotels.id = suites.hotel_id');
                    $suitesReq->execute();
                    while($suiteInfos = $suitesReq->fetch(PDO::FETCH_ASSOC)){ ?>
                        <option value="<?= $suiteInfos['id'] ?>"><?= $suiteInfos['hotel'] ?> (<?= $suiteInfos['city'] ?>) - Suite <?= $suiteInfos['suite'] ?></option>
                    <?php }
                    ?>
                </select>
                <div id="suiteHelp" class="form-text text-danger d-none">Veuillez sélectionner une suite</div>
            </div>
            <div class="mb-3 col-12 col-md-6">
                <label for="startDate" class="form-label text-gold">Arrivée</label>
                <input type="date" class="form-control" id="startDate" name="startDate" required>
                <div id="startDateHelp" class="form-text text-danger d-none">Veuillez entrer une date valide</div>
            </div>
            <div class="mb-3 col-12 col-md-6">
                <label for="endDate" class="form-label text-gold">Départ</label>
                <input type="date" class="form-control" id="endDate" name="endDate" required>
                <div id="endDateHelp" class="form-text text-danger d-none">Veuillez entrer une date valide</div>
            </div>
            <div class="mb-3 col-12 d-none" id="available">
                <h4 class="text-gold mb-3">Bonne nouvelle !</h4>
                <p id="availability">La suite est disponible aux dates demandées. Il ne vous reste plus qu'à valider !</p>
                <?php
                if(empty($_SESSION['connect']) || (!empty($_SESSION['connect']) && $_SESSION['connect'] != 'client')){ ?>
                    <p>Rappelez-vous : vous devez vous identifier avant de réserver ! C'est <a href="./loginClient.php">ici</a> !</p>
                <?php }
                ?>
                <div class="row">
                    <button type="submit" name="submit" class="btn bg-gold rounded-pill text-offwhite my-4 col-12 col-md-4 offset-md-4" >Valider</button>
                </div>
            </div>
            <div class="mb-3 col-12 d-none" id="unavailable">
                <h4 class="text-gold mb-3" >Oupsi...</h4>
                <p >La suite n'est pas disponible aux dates demandées. Vous pouvez changer de suite, ou de dates !</p>
            </div>
            <button type="btn" id="bookingBtn" class="btn bg-gold rounded-pill text-offwhite my-4 col-8 offset-2 col-md-6 offset-md-3" >Vérifier la disponibilité</button>
        </form>
    </div>

<!-- Modal -->
<!-- <div class="modal fade" id="showAvailability" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content d-flex flex-column justify-content-between">
            <div class="modal-body pb-0">
                <h4 class="text-gold mb-3" id="availabilityTitle"></h4>
                <p id="availability"></p>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn border-gold bg-offwhite rounded-pill px-5" data-bs-dismiss="modal">annuler</button>
                <button type="button" class="btn bg-gold text-offwhite rounded-pill px-5" id="bookingValidate">réserver</button>
            </div>
        </div>
    </div>
</div> -->

    
</section>

<?php
require_once('./components/footer.php');
?>
</main>
<script src="./components/scripts/booking.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>