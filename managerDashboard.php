<?php
session_start();
require_once('./components/db/db.php');
if(isset($_SESSION['connect'])){
    if($_SESSION['connect'] == 'pro' ){
        if($_SESSION['role'] == 'manager' ){
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
?>
<section class="row  px-lg-5 mt-5">
    <!-- présentation du groupe -->
    <div class="col-md-6 d-none d-md-block text-center align-self-center">
        <img class="img-fluid" src="./assets/img/hypnos-hotel-flower.svg" alt="illustration, fleurs">
    </div>
    <div class="col-12 col-md-6">
        <h2 class="text-tilered mb-5">Espace manager</h2>
        <h4 class="text-gold mb-3">Bonjour <?= $_SESSION['user'] ?> !</h4>
    </div>
    <!-- ornement -->
    <div class="col-12 my-5 text-center">
        <img class="img-fluid px-5" src="./assets/img/hypnos-section-ornament.svg" alt="ornement">
    </div>
    <h2 class="col-12 text-md-center text-tilered pb-5">En construction</h2>

</section>

<?php
require_once('./components/footer.php');
?>
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>