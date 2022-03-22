<?php
session_start();
if(!isset($_GET['hotel']) && intval($_GET['hotel']) === 0){
    header('location:./index.php?error=invalidHotel');
} else {
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

    $hotelId = htmlspecialchars($_GET['hotel']);
    require_once('./components/db/db.php');
    $hotelReq = $bdd->prepare('SELECT * FROM hotels WHERE id = :id;');
    $hotelReq->bindValue(':id', $hotelId, PDO::PARAM_INT);
    $hotelReq->execute();
    $count = $hotelReq->rowCount();
    if($count === 0){
        header('location:./index.php?error=invalidHotel');
    } else {?>
        <section class="row px-lg-5 mt-5">
            <!-- présentation de l'hotel -->
            <div class="col-md-6 d-none d-md-block text-center align-self-center">
                <img class="img-fluid" src="./assets/img/hypnos-hotel-flower.svg" alt="illustration, fleurs">
            </div>
            <div class="col-12 col-md-6">
            <?php
                while($hotelInfos = $hotelReq->fetch(PDO::FETCH_ASSOC)){ ?>
                    <h2 class="text-tilered"><?= $hotelInfos['name'] ?></h2>
                    <h6 class="mb-2 text-lgrey"><?= $hotelInfos['address'] ?><br><?= $hotelInfos['city'] ?></h6>
                    <p><?= $hotelInfos['description'] ?></p>
                <?php }
            ?>
            </div>
            <!-- ornement -->
            <div class="col-12 my-5 text-center">
                <img class="img-fluid px-5" src="./assets/img/hypnos-section-ornament.svg" alt="ornement">
            </div>
            <!-- affichage des hôtels -->
            <h2 id="ourHotels" class="col-12 text-md-center text-tilered pb-5">Nos suites</h2>
            <?php
            $suiteReq = $bdd->prepare('SELECT suites.*, prices.price FROM suites JOIN prices ON prices.id = suites.price_id WHERE hotel_id = :id');
            $suiteReq->bindValue(':id', $hotelId, PDO::PARAM_INT);
            $suiteReq->execute();
            while($suiteInfos = $suiteReq->fetch(PDO::FETCH_ASSOC)){ ?>
                <article class="col-12 mb-3">
                    <div class="card p-3">
                        <div class="row">
                            <div class="d-none d-md-block col-md-5 col-lg-4">
                                <p class="card__img" style="background-image: url('<?= $suiteInfos['primePicture'] ?>');"></p>
                                <!-- <img src="<?= $suiteInfos['primePicture'] ?>" class="img-fluid card__img" alt="photo suite"> -->
                            </div>
                            <div class="col-12 col-md-7 col-lg-8 d-flex flex-column justify-content-between">
                                <div class="mb-3 px-0">
                                    <h4 class="card-title text-gold"><?= $suiteInfos['title'] ?></h4>
                                    <h6 class="card-subtitle mb-2 text-lgrey">à partir de <?= $suiteInfos['price'] ?> € la nuit</h6>
                                    <div class="d-md-none">
                                        <p class="card__img" style="background-image: url('<?= $suiteInfos['primePicture'] ?>');"></p>
                                        <!-- <img src="<?= $suiteInfos['primePicture'] ?>" class="img-fluid card__img" alt="photo suite"> -->
                                    </div>
                                    <p class="card-text pb-2 pb-md-0 py-md-2"><?= $suiteInfos['description'] ?></p>
                                </div>
                                <div class="text-center row px-2 d-flex justify-content-center justify-content-md-end">
                                    <?php 
                                    $picturesReq = $bdd->prepare('SELECT * FROM pictures WHERE suite_id = :sid ;');
                                    $picturesReq->bindValue(':sid', $suiteInfos['id'], PDO::PARAM_INT);
                                    $picturesReq->execute();
                                    // s'il n'y a pas de photos correspondant à la suite dans la table, on désactive le bouton
                                    $picturesCount = $picturesReq->rowCount();
                                    if($picturesCount === 0) { ?>
                                        <button type="button" class="col-5 btn bg-offwhite border-gold rounded-pill text-dblue px-2 mx-2 disabled">galerie d'images</button>
                                    <?php } else { ?>
                                        <button type="button" class="col-5 btn bg-offwhite border-gold rounded-pill text-dblue px-2 mx-2" data-bs-toggle="modal" data-bs-target="#suite<?= $suiteInfos['id'] ?>">galerie d'images</button>
                                    <?php } ?>
                                    <a type="button" href="./booking.php?suite=<?= $suiteInfos['id'] ?>" class="col-5 btn bg-gold rounded-pill text-offwhite px-2 mx-2">réserver</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </article>
                <!-- MODALE GALERIE IMAGES SI IMAGES DISPOS -->
                <?php 
                if($picturesCount !== 0){ ?>
                    <div class="modal fade bg-offwhite" id="suite<?= $suiteInfos['id'] ?>" tabindex="-1" aria-labelledby="suiteGallerie" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title text-gold border-0" id="suiteGallerie">Suite <?= $suiteInfos['title'] ?></h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div id="carouselIndicators" class="carousel slide" data-bs-ride="carousel">
                                    <div class="carousel-inner">
                                        <?php 
                                        while($picture = $picturesReq->fetch(PDO::FETCH_ASSOC)){ ?>
                                            <div class="carousel-item active">
                                                <img src="<?= $picture['picture'] ?>" class="d-block w-100" alt="...">
                                            </div>
                                        <?php }
                                        ?>
                                    </div>
                                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselIndicators" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#carouselIndicators" data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn bg-gold text-offwhite rounded-pill px-5" data-bs-dismiss="modal">Close</button>
                            </div>
                            </div>
                        </div>
                    </div>

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

    <?php }

}