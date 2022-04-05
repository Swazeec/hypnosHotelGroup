<?php
session_start();
require_once('./components/db/db.php');
if(isset($_SESSION['connect'])){
    if($_SESSION['connect'] == 'client'){
        require('./aws/aws-autoloader.php');
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
<section class="row  px-lg-5 mt-5">
    <!-- présentation du groupe -->
    <div class="col-md-6 d-none d-md-block text-center align-self-center">
        <img class="img-fluid" src="./assets/img/hypnos-home-flowers-blue.svg" alt="illustration, fleurs">
    </div>
    <div class="col-12 col-md-6">
        <h2 class="text-tilered">Bienvenue !</h2>
        <p>Lorem ipsum dolor sit amet. Non eveniet aliquid et porro laboriosam vel ipsa doloremque. Et quos aspernatur eos suscipit dolorem ab impedit iusto hic beatae porro.</p>
        <p>Ex expedita obcaecati et necessitatibus amet aut voluptatum earum aut reiciendis voluptas asperiores pariatur. Eum nemo omnis ad doloribus harum ut consequatur maxime ut harum consequatur. Ab quos dolor est inventore esse aut sunt molestiae a dignissimos accusamus qui molestiae nesciunt aut architecto iure.</p>
        <p>Est libero delectus ab amet magnam et vitae numquam nam nulla dolor qui eveniet galisum. Qui maxime autem sit iusto recusandae et recusandae rerum qui sint reiciendis sed deserunt expedita ex possimus atque. In dignissimos sunt aut expedita neque hic dolorem labore et rerum suscipit a mollitia odio aut veritatis cumque!</p>
    </div>
    <!-- ornement -->
    <div class="col-12 my-5 text-center">
        <img class="img-fluid px-5" src="./assets/img/hypnos-section-ornament.svg" alt="ornement">
    </div>
    <!-- affichage des hôtels -->
    <h2 id="ourHotels" class="col-12 text-md-center text-tilered pb-5">Nos hôtels</h2>

    <?php
        $hotelReq = $bdd->prepare('SELECT * FROM hotels;');
        $hotelReq->execute();
        while($hotelInfos = $hotelReq->fetch(PDO::FETCH_ASSOC)){ ?>
            <article class="col-12 col-md-4 mb-3">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div class="mb-3">
                            <h4 class="card-title text-gold"><?= $hotelInfos['name'] ?></h4>
                            <h6 class="card-subtitle mb-2 text-lgrey"><?= $hotelInfos['address'] ?><br><?= $hotelInfos['city'] ?></h6>
                            <p class="card-text"><?= $hotelInfos['description'] ?></p>
                        </div>
                        <div class="text-center d-flex flex-column px-2">
                            <a type="button" href="./hotel.php?hotel=<?= $hotelInfos['id'] ?>" class="btn bg-gold rounded-pill text-offwhite px-2">Voir les suites</a>
                        </div>
                    </div>
                </div>
            </article>

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