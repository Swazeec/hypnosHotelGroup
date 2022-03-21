<?php
session_start();
require_once('./components/db/db.php');
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
?>
<section class="row px-lg-5" >
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

    <!-- NOUS CONTACTER -->
    <div class="col-12 col-md-8 offset-md-2 col-lg-6 offset-lg-3">
        <form action="" method="post" class="row" id="bookingForm">
            
            <div class="mb-3 col-12">
                <label for="suite" class="form-label text-gold">Votre suite</label>
                <select class="form-select " id="suite" name="suite" required>
                    <option value="1">Hôtel xxx (Rennes) - Suite Maija Isola</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
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
            
            <button type="submit" id="bookingBtn" class="btn bg-gold rounded-pill text-offwhite my-4 col-8 offset-2 col-md-6 offset-md-3">Vérifier la disponibilité</button>
        </form>
    </div>
    
</section>

<?php
require_once('./components/footer.php');
?>
</main>
<script src="./components/scripts/functions.js"></script>
<script src="./components/scripts/contact.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>