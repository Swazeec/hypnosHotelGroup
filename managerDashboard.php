<?php
session_start();
require_once('./components/db/db.php');
if(isset($_SESSION['connect'])){
    if($_SESSION['connect'] == 'pro' ){
        if($_SESSION['role'] == 'manager' ){
            require_once('./components/managerDashboardScript.php');
            require_once('./components/header/header-pro.php');
        } else if($_SESSION['role'] == 'admin' ){
            header('location:./adminDashboard.php');
        }
    } else {
        header('location:./index.php');    
    }
} else {
    header('location:./index.php'); 
}
if(!empty($_GET['error']) && $_GET['error'] == 'hotel'){ ?>
    <div class="row py-2 text-center bg-danger">
        <p class="text-white m-0">Merci de contacter votre administrateur.</p>
    </div>
<?php }
if(!empty($_GET['error']) && $_GET['error'] == 'bucket'){ ?>
    <div class="row py-2 text-center bg-danger">
        <p class="text-white m-0">Un problème est survenu avec le service d'upload d'images. Merci de contacter votre administrateur.</p>
    </div>
<?php }
if(!empty($_GET['error']) && $_GET['error'] == 'deleteSuite'){ ?>
    <div class="row py-2 text-center bg-danger">
        <p class="text-white m-0">Une erreur est survenue lors de la suppression de votre suite. Merci de réessayer ultérieurement.</p>
    </div>
<?php }
if(!empty($_GET['suite']) && $_GET['suite'] == 'invalid'){ ?>
    <div class="row py-2 text-center bg-danger">
        <p class="text-white m-0">Une erreur est survenue lors de la demande de modification. Merci de réessayer ultérieurement.</p>
    </div>
<?php }
if(!empty($_GET['success']) && $_GET['success'] == 'addSuite'){ ?>
    <div class="row py-2 text-center bg-success">
        <p class="text-white m-0">Suite ajoutée avec succès !</p>
    </div>
<?php }
if(!empty($_GET['success']) && $_GET['success'] == 'deleteSuite'){ ?>
    <div class="row py-2 text-center bg-success">
        <p class="text-white m-0">Votre suite ainsi que ses réservations ont été supprimées avec succès !</p>
    </div>
<?php }
if(!empty($_GET['success']) && $_GET['success'] == 'modifySuite'){ ?>
    <div class="row py-2 text-center bg-success">
        <p class="text-white m-0">Votre suite a été modifiée avec succès !</p>
    </div>
<?php }
?>
<section class="row  px-lg-5 mt-5">
    <div class="col-12 text-center mb-5">
        <h2 class="text-tilered mb-4">Espace manager</h2>
        <h4 class="text-gold mb-5">Bonjour <?= $_SESSION['user'] ?> !</h4>
        <a href="./addSuite.php" class="border-gold text-dblue rounded-pill px-5 py-1 text-center"><i class="bi bi-plus"></i> nouvelle suite</a>
    </div>
    <?php
        // on récupère l'id manager
        $managerId = $_SESSION['proId'];

        // on récupère l'id de son hotel
        $hotelIdReq = $bdd->prepare('SELECT id FROM hotels WHERE manager_id = :mid');
        $hotelIdReq->bindValue(':mid', $managerId, PDO::PARAM_INT);
        $hotelIdReq->execute();
        $hotelId = $hotelIdReq->fetch(PDO::FETCH_ASSOC);

        //on récupère et affiche les suites concernées
        $suitesReq = $bdd->prepare('SELECT suites.*, prices.price FROM suites JOIN prices ON prices.id = suites.price_id WHERE hotel_id = :hid ORDER BY id DESC;');
        $suitesReq->bindValue(':hid', $hotelId, PDO::PARAM_INT);
        $suitesReq->execute();
        while($suitesInfos = $suitesReq->fetch(PDO::FETCH_ASSOC)){ ?>
            <article class="col-12 col-md-6 col-lg-4 mb-3">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
                                <h4 class="card-title text-gold"><?= $suitesInfos['title'] ?></h4>
                                <div class="text-center px-2">
                                    <a class="px-2 btn" href="./modifySuite.php?suite=<?= $suitesInfos['id'] ?>" ><i class="bi bi-pencil text-primary"></i></a>
                                    <a class="px-2 btn" href="#" data-bs-toggle="modal" data-bs-target="#deleteSuite<?= $suitesInfos['id'] ?>"><i class="bi bi-x-lg text-danger"></i></a>                        
                                </div>
                            </div>
                            <h6 class="card-subtitle mb-2 text-lgrey"><?= $suitesInfos['price'] ?> € la nuit</h6>
                            <p class="card-text"><?= $suitesInfos['description'] ?></p>
                        </div>
                        <div >
                            <p class="card__img" style="background-image: url('<?= $suitesInfos['primePicture'] ?>');"></p>
                        </div>
                        
                    </div>
                    <div class="row px-2 d-flex justify-content-center">
                        <div class="col-12 mb-3">
                            <a href="<?= $suitesInfos['link'] ?>" class="card-text px-2">Lien booking.com</a>
                        </div>
                        <?php 
                        $picturesReq = $bdd->prepare('SELECT * FROM pictures WHERE suite_id = :sid ;');
                        $picturesReq->bindValue(':sid', $suitesInfos['id'], PDO::PARAM_INT);
                        $picturesReq->execute();
                        // s'il n'y a pas de photos correspondant à la suite dans la table, on désactive le bouton
                        $picturesCount = $picturesReq->rowCount();
                        if($picturesCount === 0) { ?>
                            <button type="button" class="col-6 btn bg-offwhite border-gold rounded-pill text-dblue px-2 mx-2 mb-3 disabled">galerie d'images</button>
                        <?php } else { ?>
                            <button type="button" class="col-6 btn bg-offwhite border-gold rounded-pill text-dblue px-2 mx-2 mb-3" data-bs-toggle="modal" data-bs-target="#suite<?= $suitesInfos['id'] ?>">galerie d'images</button>
                        <?php } ?>
                    </div>
                </div>
            </article>
            <!-- MODALE GALERIE IMAGES SI IMAGES DISPOS -->
            <?php 
            if($picturesCount !== 0){ ?>
                <div class="modal fade bg-offwhite" id="suite<?= $suitesInfos['id'] ?>" tabindex="-1" aria-labelledby="suiteGallerie" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                        <div class="modal-header border-0">
                            <h5 class="modal-title text-gold border-0" id="suiteGallerie">Suite <?= $suitesInfos['title'] ?></h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div id="carouselIndicators<?= $suitesInfos['id'] ?>" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <?php 
                                    $pictures = $picturesReq->fetchAll(PDO::FETCH_ASSOC);
                                    for($i = 0; $i < count($pictures) ; $i++){
                                        if($i == 0){ ?>
                                            <div class="carousel-item active">
                                                <img src="<?= $pictures[$i]['picture'] ?>" class="d-block w-100" alt="...">
                                            </div>
                                        <?php } else { ?>
                                            <div class="carousel-item">
                                                <img src="<?= $pictures[$i]['picture'] ?>" class="d-block w-100" alt="...">
                                            </div>
                                        <?php 
                                        }
                                    }
                                    ?>
                                </div>
                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselIndicators<?= $suitesInfos['id'] ?>" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselIndicators<?= $suitesInfos['id'] ?>" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="button" class="btn bg-gold text-offwhite rounded-pill px-5" data-bs-dismiss="modal">Close</button>
                        </div>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <!-- MODAL POUR SUPPRIMER SUITE -->
            <div class="modal fade" id="deleteSuite<?= $suitesInfos['id'] ?>" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header border-0">
                            <div class="modal-title">
                                <h5 class="text-gold mb-3">Êtes-vous sûr de vouloir supprimer la suite <?= $suitesInfos['title'] ?> ?</h5>
                                <p class="text-danger"><i class="bi bi-exclamation-circle-fill text-danger"></i> ATTENTION !!! <br>Cela entrainera la suppression de toutes les réservations pour cette suite.</p>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body d-flex px-md-5 ">
                            <a class="btn flex-fill me-1 bg-offwhite text-dblue border-gold rounded-pill" data-bs-dismiss="modal">annuler</a>
                            <a href="./managerDashboard.php?deleteSuite=<?= $suitesInfos['id'] ?>" class="btn flex-fill ms-1 bg-gold text-offwhite rounded-pill">supprimer</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php }
    ?>

</section>

<?php
require_once('./components/footer.php');
?>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>