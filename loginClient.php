<?php
session_start();
require_once('./components/db/db.php');
require_once('./components/loginClientScript.php');
if(isset($_SESSION['connect'])){
    if($_SESSION['connect'] == 'client'){
        header('location:./myBookings.php');
    } else if ($_SESSION['connect'] == 'pro'){
        require_once('./components/header/header-pro.php');
    } else {
        require_once('./components/header/header-noauth.php');
    }
} else {
    require_once('./components/header/header-noauth.php');
}

if(!empty($_GET['error']) && $_GET['error'] == 'signupfail'){ ?>
    <div class="row py-2 text-center bg-danger">
        <p class="text-white m-0">Une erreur est survenue lors de la création de votre compte. Merci de réessayer ultérieurement.</p>
    </div>
<?php }
if(!empty($_GET['error']) && $_GET['error'] == 'email'){ ?>
    <div class="row py-2 text-center bg-danger">
        <p class="text-white m-0">Vous ne pouvez pas utiliser cette adresse email.</p>
    </div>
<?php }
if(isset($_GET['error']) && $_GET['error'] == 'invalid'){ ?>
    <div class="row py-2 text-center bg-danger">
        <p class="text-white m-0">Identifiants invalides</p>
    </div>
<?php } 
if(isset($_GET['signup']) && $_GET['signup'] == 'success'){ ?>
    <div class="row py-2 text-center bg-success">
        <p class="text-white m-0">Compte créé avec succès ! Connectez-vous !</p>
    </div>
<?php }
?>
<section class="row px-lg-5 mt-5" >
    <!-- illustration -->
    <div class="col-md-6 d-none d-md-block text-center align-self-center">
        <img class="img-fluid" src="./assets/img/hypnos-login.svg" alt="illustration, devices">
    </div>
    <!-- SE CONNECTER -->
    <div class="col-12 col-md-6" id="logInSection">
        <h2 class="text-tilered">Se connecter</h2>
        <p>Nouveau client ? <a href="#" id="signInLink">S'inscrire</a></p>
        <form action="" method="post" class="row" id="loginClientForm">
            <div class="mb-3 col-12">
                <label for="emailLogIn" class="form-label text-gold">Email</label>
                <input type="email" class="form-control" id="emailLogIn" name="emailLogIn" required>
                <div id="emailLogHelp" class="form-text text-danger d-none">Veuillez entrer une adresse valide</div>
            </div>
            <div class="mb-3 col-12">
                <label for="passwordLogIn" class="form-label text-gold">Mot de passe</label>
                <input type="password" class="form-control" id="passwordLogIn" name="passwordLogIn" required>
                <div id="pwdLogHelp" class="form-text text-danger d-none">Votre mot de passe est incorrect</div>
            </div>
            <button type="submit" class="btn bg-gold rounded-pill text-offwhite my-4 col-8 offset-2 col-md-6 offset-md-3 col-lg-4 offset-lg-4" id="logBtn">Se connecter</button>
        </form>
    </div>
    
    <!-- S'INSCRIRE -->
    <div class="col-12 col-md-6 d-none" id="signUpSection">
        <h2 class="text-tilered">S'inscrire</h2>
        <form action="" method="post" class="row" id="signUpForm">
            <div class="mb-3 col-12">
                <label for="firstname" class="form-label text-gold">Prénom</label>
                <input type="text" class="form-control" id="firstname" name="firstname" required>
                <div id="firstnameHelp" class="form-text text-danger d-none">Veuillez entrer un prénom valide</div>

            </div>
            <div class="mb-3 col-12">
                <label for="lastname" class="form-label text-gold">Nom</label>
                <input type="text" class="form-control" id="lastname" name="lastname" required>
                <div id="lastnameHelp" class="form-text text-danger d-none">Veuillez entrer un nom valide</div>

            </div>
            <div class="mb-3 col-12">
                <label for="emailSignIn" class="form-label text-gold">Email</label>
                <input type="email" class="form-control" id="emailSignIn" name="emailSignIn" required>
                <div id="emailSignHelp" class="form-text text-danger d-none">Veuillez entrer une adresse valide</div>
            </div>
            <div class="mb-3 col-12">
                <label for="passwordSignIn" class="form-label text-gold">Mot de passe</label>
                <input type="password" class="form-control" id="passwordSignIn" name="passwordSignIn" required>
                <div id="pwdSignHelp" class="form-text text-danger d-none">Votre mot de passe doit contenir entre 8 et 15 caractères, dont 1 maj., 1 min., 1 chiffre et 1 caractère spécial</div>
            </div>
            <button type="submit" id="signUpBtn" class="btn bg-gold rounded-pill text-offwhite my-4 col-8 offset-2 col-md-6 offset-md-3 col-lg-4 offset-lg-4">S'inscrire</button>
        </form>
    </div>
</section>

<?php
require_once('./components/footer.php');
?>
</main>
<script src="./components/scripts/functions.js"></script>
<script src="./components/scripts/loginClient.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>