<?php
session_start();
require_once('./components/db/db.php');
require_once('./components/contactScript.php');
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
if(!empty($_GET['error']) && $_GET['error'] == 'invalid'){ ?>
    <div class="row py-2 text-center bg-danger">
        <p class="text-white m-0">Votre demande n'a pas été envoyée. Merci d'entrer des informations valides.</p>
    </div>
<?php }
if(!empty($_GET['message']) && $_GET['message'] == 'success'){ ?>
    <div class="row py-2 text-center bg-success">
        <p class="text-white m-0">Votre demande a été envoyée avec succès ! Nous reviendrons vers vous dans les plus brefs délais.</p>
    </div>
<?php }
?>
<section class="row px-lg-5 mt-5" >
    <!-- illustration -->
    <div class="col-md-6 d-none d-md-block text-center align-self-center">
        <img class="img-fluid" src="./assets/img/hypnos-contact.svg" alt="illustration, contact">
    </div>
    <!-- NOUS CONTACTER -->
    <div class="col-12 col-md-6" >
        <h2 class="text-tilered">Nous contacter</h2>
        <form action="" method="post" class="row" id="contactForm">
            <!-- Si l'utilisateur est connecté, form prérempli -->
        <?php if(!empty($_SESSION['userId'])){
            $clientId = $_SESSION['userId'];
            $clientReq = $bdd->prepare('SELECT * FROM clients WHERE id = :id;');
            $clientReq->bindValue(':id', $clientId);
            $clientReq->execute();
            $clientInfos = $clientReq->fetch(PDO::FETCH_ASSOC); ?>
            <div class="mb-3 col-12">
                <label for="firstname" class="form-label text-gold">Prénom</label>
                <input type="text" class="form-control" id="firstname" name="firstname" value="<?= $clientInfos['firstname'] ?>" required>
                <div id="firstnameHelp" class="form-text text-danger d-none">Veuillez entrer un prénom valide</div>
            </div>
            <div class="mb-3 col-12">
                <label for="lastname" class="form-label text-gold">Nom</label>
                <input type="text" class="form-control" id="lastname" name="lastname" value="<?= $clientInfos['lastname'] ?>" required>
                <div id="lastnameHelp" class="form-text text-danger d-none">Veuillez entrer un nom valide</div>
            </div>
            <div class="mb-3 col-12">
                <label for="email" class="form-label text-gold">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= $clientInfos['email'] ?>" required>
                <div id="emailHelp" class="form-text text-danger d-none">Veuillez entrer une adresse valide</div>
            </div>
            <?php } else {?>
                <!-- form non rempli -->
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
            <?php } ?>
            <div class="mb-3 col-12">
                <label for="topic" class="form-label text-gold">Sujet de votre demande</label>
                <select class="form-select " id="topic" name="topic" required>
                    <?php 
                    $topicReq = $bdd->prepare('SELECT * FROM topics;');
                    $topicReq->execute();
                    while($topic = $topicReq->fetch(PDO::FETCH_ASSOC)){ ?>
                        <option value="<?= $topic['id'] ?>"><?= $topic['name'] ?></option>
                    <?php }
                    ?>
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