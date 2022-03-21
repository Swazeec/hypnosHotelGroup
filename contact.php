<?php
require_once('./components/db/db.php');
require_once('./components/header/header-noauth.php');
?>
<section class="row px-lg-5" >
    <!-- illustration -->
    <div class="col-md-6 d-none d-md-block text-center align-self-center">
        <img class="img-fluid" src="./assets/img/hypnos-contact.svg" alt="illustration, contact">
    </div>
    <!-- NOUS CONTACTER -->
    <div class="col-12 col-md-6" >
        <h2 class="text-tilered">Nous contacter</h2>
        <form action="" method="post" class="row" id="contactForm">
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
                <label for="email" class="form-label text-gold">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
                <div id="emailHelp" class="form-text text-danger d-none">Veuillez entrer une adresse valide</div>
            </div>
            <div class="mb-3 col-12">
                <label for="topic" class="form-label text-gold">Sujet de votre demande</label>
                <select class="form-select " id="topic" name="topic" required>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                </select>
                <div id="topicHelp" class="form-text text-danger d-none">Veuillez sélectionner un sujet</div>
            </div>
            <div class="mb-3 col-12">
                <label for="message" class="form-label text-gold">Votre message</label>
                <textarea class="form-control" id="message" name="message" rows="3" required></textarea>
                <div id="messageHelp" class="form-text text-danger d-none">Veuillez rédiger un message de moins de 2000 caractères</div>
            </div>


            <button type="submit" id="contactBtn" class="btn bg-gold rounded-pill text-offwhite my-4 col-8 offset-2 col-md-6 offset-md-3 col-lg-4 offset-lg-4">Envoyer</button>
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