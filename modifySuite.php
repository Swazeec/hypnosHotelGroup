<?php
session_start();
require_once('./components/db/db.php');
if(isset($_SESSION['connect'])){
    if($_SESSION['connect'] == 'pro' ){
        if($_SESSION['role'] == 'manager' ){
            // on vérifie que le manager soit bien associé à un hôtel
            $manager_id = $_SESSION['proId'];
            $hotelIdReq = $bdd->prepare('SELECT id FROM hotels WHERE manager_id = :mid ;');
            $hotelIdReq->bindValue(':mid', $manager_id, PDO::PARAM_INT);
            $hotelIdReq->execute();
            $count = $hotelIdReq->rowCount();
            if($count === 0){
                header('location:./managerDashboard.php?error=hotel');
            } else {
                $hotelId = $hotelIdReq->fetch(PDO::FETCH_ASSOC);
                // on vérifie que l'id soit bien un nombre positif
                if(!isset($_GET['suite'])){
                    header('location:./managerDashboard.php?suite=invalid');
                } else if(intval($_GET['suite']) <= 0) {
                    header('location:./managerDashboard.php?suite=invalid');
                } else {
                    // on vérifie que la suite existe et soit bien associée à l'hôtel du manager
                    $suiteId = $_GET['suite'];
                    $suiteReq = $bdd->prepare('SELECT suites.*, prices.price FROM suites JOIN prices ON prices.id = suites.price_id WHERE suites.id = :id AND hotel_id = :hid ;');
                    $suiteReq->bindValue(':id', $suiteId, PDO::PARAM_INT);
                    $suiteReq->bindValue(':hid', $hotelId, PDO::PARAM_INT);
                    $suiteReq->execute();
                    $suiteCount = $suiteReq->rowCount();
                    if($suiteCount === 0){
                        header('location:./managerDashboard.php?suite=invalid');
                    } else {
                        require_once('./components/modifySuiteScript.php');
                        require_once('./components/header/header-pro.php');
                        $suiteInfos = $suiteReq->fetch(PDO::FETCH_ASSOC);
                    }
                }
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
if(!empty($_GET['error']) && $_GET['error'] == 'invalidInfos'){ ?>
    <div class="row py-2 text-center bg-danger">
        <p class="text-white m-0">Une erreur est survenue lors de la modification de votre suite. Merci de saisir des informations valides.</p>
    </div>
<?php }
if(!empty($_GET['error']) && $_GET['error'] == 'invalidPicture'){ ?>
    <div class="row py-2 text-center bg-danger">
        <p class="text-white m-0">Une erreur est survenue lors de la modification de votre suite. Merci de choisir une photo valide.</p>
    </div>
<?php }
if(!empty($_GET['error']) && $_GET['error'] == 'picture'){ ?>
    <div class="row py-2 text-center bg-danger">
        <p class="text-white m-0">Une erreur est survenue lors de la mise en ligne de votre photo. Merci de réessayer.</p>
    </div>
<?php }
?>
<section class="row  px-lg-5 mt-5">
    <div class="col-12 text-center mb-5">
        <h2 class="text-tilered mb-4">Modifier une suite :</h2>
        <h4 class="text-gold"><?= $suiteInfos['title']?> </h4>

    </div>
    <div class="col-12 col-md-8 offset-md-2">
        <form  class="row" method="post" enctype="multipart/form-data">
            <!-- NOM -->
            <div class="mb-3 col-12 col-md-9">
                <label for="suiteName" class="form-label text-gold">Nom de la suite</label>
                <input type="text" class="form-control" id="suiteName" name="suiteName" value="<?= $suiteInfos['title']?>" required>
                <div id="suiteNameHelp" class="form-text text-danger d-none">Veuillez entrer un nom valide</div>
            </div>
            <!-- PRIX -->
            <div class="mb-3 col-12 col-md-3">
                <label for="price" class="form-label text-gold">Prix</label>
                <?php
                $priceReq = $bdd->prepare('SELECT * FROM prices WHERE id != :id');
                $priceReq->bindValue(':id', $suiteInfos['price_id'], PDO::PARAM_INT);
                $priceReq->execute(); ?>
                <select class="form-select" id="price" name="price" required>
                    <option value="<?= $suiteInfos['price_id'] ?>"><?= $suiteInfos['price']?> €</option>
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
                <textarea class="form-control" id="description" name="description" required><?= $suiteInfos['description']?></textarea>
                <div id="descriptionHelp" class="form-text text-danger d-none">Votre description peut contenir jusqu'à 2000 caractères</div>
            </div>
            <!-- LIEN BOOKING EXT. -->
            <div class="mb-3 col-12">
                <label for="bookingLink" class="form-label text-gold">Lien vers Booking.com</label>
                <input type="text" class="form-control" id="bookingLink" name="bookingLink" value="<?= $suiteInfos['link']?>" required>
                <div id="bookingLinkHelp" class="form-text text-danger d-none">Veuillez entrer une adresse valide</div>
            </div>
            <!-- AFFICHER PHOTO PRINCIPALE ACTUELLE -->
            <div class="mb-3 col-12 col-md-6">
                <label class="form-label text-gold">Photo principale</label>
                <img class="img-fluid" src="<?= $suiteInfos['primePicture'] ?>" alt="Photo principale de la suite">
            </div>


            <!-- AFFICHER PHOTOS GALERIE + POSSIBILITE DE SUPPR. -->
            <div class="mb-3 col-12 col-md-6">
                <label class="form-label text-gold">Galerie</label>
                <?php 
                $galeriePicturesReq = $bdd->prepare('SELECT * FROM pictures WHERE suite_id = :sid;');
                $galeriePicturesReq->bindValue(':sid', $suiteId, PDO::PARAM_INT);
                $galeriePicturesReq->execute();
                $pictCount = $galeriePicturesReq->rowCount();
                if($pictCount === 0){ ?>
                    <h5 class="text-tilered text-center mt-md-5">Pas de galerie pour le moment !</h5>
                <?php } else { ?>
                    <div id="galerieControls" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <?php 
                            $galerie = $galeriePicturesReq->fetchAll(PDO::FETCH_ASSOC);
                            for($i = 0; $i < count($galerie); $i++){
                                if($i === 0){ ?>
                                    <div class="carousel-item active text-end">
                                        <a href="./modifySuite.php?suite=<?= $suiteId ?>&deleteGaleriePict=<?= $galerie[$i]['id'] ?>" class="position-absolute top-0 end-0 p-1" style="z-index: 10;"><i class="bi bi-x-lg text-danger"></i></a>
                                        <img src="<?= $galerie[$i]['picture'] ?>" class="d-block w-100" alt="Photo de galerie">
                                    </div>
                                <?php } else { ?>
                                    <div class="carousel-item text-end">
                                        <a href="./modifySuite.php?suite=<?= $suiteId ?>&deleteGaleriePict=<?= $galerie[$i]['id'] ?>" class="position-absolute top-0 end-0 p-1" style="z-index: 10;"><i class="bi bi-x-lg text-danger"></i></a>
                                        <img src="<?= $galerie[$i]['picture'] ?>" class="d-block w-100" alt="Photo de galerie">
                                    </div>
                                <?php }
                            }
                            ?>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#galerieControls" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#galerieControls" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>

                <?php }
                ?>

                <!-- <div class="row">
                    <img class="img-fluid col-6 col-md-6 col-lg-4 mb-3" src="<?= $suiteInfos['primePicture'] ?>" alt="Photo principale de la suite">
                    <img class="img-fluid col-6 col-md-6 col-lg-4 mb-3" src="<?= $suiteInfos['primePicture'] ?>" alt="Photo principale de la suite">
                    <img class="img-fluid col-6 col-md-6 col-lg-4 mb-3" src="<?= $suiteInfos['primePicture'] ?>" alt="Photo principale de la suite">
                    <img class="img-fluid col-6 col-md-6 col-lg-4 mb-3" src="<?= $suiteInfos['primePicture'] ?>" alt="Photo principale de la suite">
                    <img class="img-fluid col-6 col-md-6 col-lg-4 mb-3" src="<?= $suiteInfos['primePicture'] ?>" alt="Photo principale de la suite">
                    <img class="img-fluid col-6 col-md-6 col-lg-4 mb-3" src="<?= $suiteInfos['primePicture'] ?>" alt="Photo principale de la suite">
                    <img class="img-fluid col-6 col-md-6 col-lg-4 mb-3" src="<?= $suiteInfos['primePicture'] ?>" alt="Photo principale de la suite">
                    <img class="img-fluid col-6 col-md-6 col-lg-4 mb-3" src="<?= $suiteInfos['primePicture'] ?>" alt="Photo principale de la suite">
                    <img class="img-fluid col-6 col-md-6 col-lg-4 mb-3" src="<?= $suiteInfos['primePicture'] ?>" alt="Photo principale de la suite">
                    <img class="img-fluid col-6 col-md-6 col-lg-4 mb-3" src="<?= $suiteInfos['primePicture'] ?>" alt="Photo principale de la suite">
                </div> -->
            </div>


            <!-- CHANGER PHOTO PRINCIPALE -->
            <div class="mb-3 col-12 col-md-6">
                <label for="primePicture" class="form-label text-gold">Changer la photo principale</label>
                <input class="form-control" type="file" id="primePicture" name="primePicture" accept="image/jpeg">
                <div id="primePictureHelp" class="form-text text-danger d-none">Veuillez sélectionner une photo valide</div>
            </div>
            <!-- AJOUTER PHOTOS GALERIE -->
            <div class="mb-5 col-12 col-md-6">
                <label for="galeriePictures" class="form-label text-gold">Ajouter des photos à la galerie</label>
                <input class="form-control" type="file" id="galeriePictures" name="galeriePictures[]" accept="image/jpeg" multiple>
                <div id="galeriePicturesHelp" class="form-text text-danger d-none">Veuillez sélectionner une ou plusieurs photos valides</div>
            </div>
            <!-- BOUTONS -->
            <div class=" d-flex px-md-5 ">
                <a href="./managerDashboard.php" class="btn flex-fill me-1 bg-offwhite text-dblue border-gold rounded-pill" >annuler</a>
                <button type="submit" id="modifySuiteBtn" name="modifySuite" class="btn flex-fill ms-1 bg-gold text-offwhite rounded-pill">modifier</button>
            </div>
        </form>
    </div>


</section>

<?php
require_once('./components/footer.php');
?>
</main>
<script src="./components/scripts/functions.js"></script>
<script src="./components/scripts/modifySuite.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>