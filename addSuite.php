<?php
session_start();
require_once('./components/db/db.php');
if(isset($_SESSION['connect'])){
    if($_SESSION['connect'] == 'pro' ){
        if($_SESSION['role'] == 'manager' ){
            $manager_id = $_SESSION['proId'];
            $hotelIdReq = $bdd->prepare('SELECT id FROM hotels WHERE manager_id = :mid ;');
            $hotelIdReq->bindValue(':mid', $manager_id, PDO::PARAM_INT);
            $hotelIdReq->execute();
            $count = $hotelIdReq->rowCount();
            if($count === 0){
                header('location:./managerDashboard.php?error=hotel');
            } else {
                require_once('./components/addSuiteScript.php');
                require_once('./components/header/header-pro.php');
                $hotelId = $hotelIdReq->fetch(PDO::FETCH_ASSOC);
            }

        } else if($_SESSION['role'] == 'admin' ){
            header('location:./adminDashboard.php');
        }
    } else {
        header('location:./index.php');    
    }
} else {
    header('location:./index.php'); 
}
if(!empty($_GET['error']) && $_GET['error'] == 'addSuite'){ ?>
    <div class="row py-2 text-center bg-danger">
        <p class="text-white m-0">Une erreur est survenue lors de l'ajout de votre suite. Merci de réessayer ultérieurement.</p>
    </div>
<?php }
if(!empty($_GET['error']) && $_GET['error'] == 'galeriePicture'){ ?>
    <div class="row py-2 text-center bg-danger">
        <p class="text-white m-0">Votre suite a été créée mais une erreur est survenue lors de l'ajout des photos de galerie. Merci de vérifier votre suite puis de la modifier pour ajouter vos photos.</p>
    </div>
<?php }
if(!empty($_GET['error']) && $_GET['error'] == 'picture'){ ?>
    <div class="row py-2 text-center bg-danger">
        <p class="text-white m-0">Une erreur est survenue lors de l'ajout de votre photo principale, votre suite n'a pas été créée. Merci de réessayer ultérieurement.</p>
    </div>
<?php }
?>
<section class="row  px-lg-5 mt-5">
    <div class="col-12 text-center mb-5">
        <h2 class="text-tilered mb-4">Ajouter une suite</h2>
    </div>
    <div class="col-12 col-md-8 offset-md-2">
        <form  class="row" method="post" enctype="multipart/form-data">
            <!-- NOM -->
            <div class="mb-3 col-12 col-md-9">
                <label for="suiteName" class="form-label text-gold">Nom de la suite</label>
                <input type="text" class="form-control" id="suiteName" name="suiteName" required>
                <div id="suiteNameHelp" class="form-text text-danger d-none">Veuillez entrer un nom valide</div>
            </div>
            <!-- PRIX -->
            <div class="mb-3 col-12 col-md-3">
                <label for="price" class="form-label text-gold">Prix</label>
                <?php
                $priceReq = $bdd->prepare('SELECT * FROM prices');
                $priceReq->execute(); ?>
                <select class="form-select" id="price" name="price" required>
                <?php
                while($price = $priceReq->fetch(PDO::FETCH_ASSOC)){ ?>
                    <option value="<?= $price['id'] ?>"><?= $price['price']?> €</option>
                <?php } ?>
                </select>
                <div id="priceHelp" class="form-text text-danger d-none">Veuillez sélectionner un prix valide</div>
            </div>
            <!-- DESCRIPTION -->
            <div class="mb-3 col-12">
                <label for="description" class="form-label text-gold">Description</label>
                <textarea class="form-control" id="description" name="description" required></textarea>
                <div id="descriptionHelp" class="form-text text-danger d-none">Votre description peut contenir jusqu'à 2000 caractères</div>
            </div>
            <!-- LIEN BOOKING EXT. -->
            <div class="mb-3 col-12">
                <label for="bookingLink" class="form-label text-gold">Lien vers Booking.com</label>
                <input type="text" class="form-control" id="bookingLink" name="bookingLink" required>
            <div id="bookingLinkHelp" class="form-text text-danger d-none">Veuillez entrer une adresse valide</div>
            </div>
            <!-- PHOTO PRINCIPALE -->
            <div class="mb-3 col-12 col-md-6">
                <label for="primePicture" class="form-label text-gold">Photo principale</label>
                <input class="form-control" type="file" id="primePicture" name="primePicture" accept="image/jpeg" required>
                <div id="primePictureHelp" class="form-text text-danger d-none">Veuillez sélectionner une photo valide</div>
            </div>
            <!-- GALERIE PHOTO -->
            <div class="mb-5 col-12 col-md-6">
                <label for="galeriePictures" class="form-label text-gold">Galerie photo</label>
                <input class="form-control" type="file" id="galeriePictures" name="galeriePictures[]" accept="image/jpeg" multiple>
                <div id="galeriePicturesHelp" class="form-text text-danger d-none">Veuillez sélectionner une ou plusieurs photos valides</div>
            </div>
            <!-- BOUTONS -->
            <div class=" d-flex px-md-5 ">
                <a href="./managerDashboard.php" class="btn flex-fill me-1 bg-offwhite text-dblue border-gold rounded-pill">annuler</a>
                <button type="submit" id="addSuiteBtn" name="addSuite" class="btn flex-fill ms-1 bg-gold text-offwhite rounded-pill">ajouter</button>
            </div>
        </form>
    </div>


</section>

<?php
require_once('./components/footer.php');
?>
</main>
<script src="./components/scripts/functions.js"></script>
<script src="./components/scripts/addSuite.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>