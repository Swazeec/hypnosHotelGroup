<?php
require_once('./components/db/db.php');
require_once('./components/header/header-noauth.php');
?>
<section class="row px-lg-5" >
    <!-- illustration -->
    <div class="col-md-6 d-none d-md-block text-center align-self-center">
        <img class="img-fluid" src="./assets/img/hypnos-login.svg" alt="illustration, devices">
    </div>
    <!-- SE CONNECTER -->
    <div class="col-12 col-md-6">
        <h2 class="text-tilered mb-5">Se connecter</h2>
        <form action="" method="post" class="row" id="loginProForm">
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
</section>

<?php
require_once('./components/footer.php');
?>
</main>
<script src="./components/scripts/functions.js"></script>
<script src="./components/scripts/loginPro.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>