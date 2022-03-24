<?php
session_start();
require_once('./components/db/db.php');
require_once('./components/adminDashboardScript.php');
if(isset($_SESSION['connect'])){
    if($_SESSION['connect'] == 'pro' ){
        if($_SESSION['role'] == 'admin' ){
            require_once('./components/header/header-pro.php');
        } else if($_SESSION['role'] == 'manager' ){
            header('location:./managerDashboard.php');
        }
    } else {
        header('location:./index.php');    
    }
} else {
    header('location:./index.php'); 
}

if(!empty($_GET['error']) && $_GET['error'] == 'modifyManager'){ ?>
    <div class="row py-2 text-center bg-danger">
        <p class="text-white m-0">Une erreur est survenue lors de la modification de votre manager. Merci de réessayer ultérieurement.</p>
    </div>
<?php }
if(!empty($_GET['error']) && $_GET['error'] == 'deleteManager'){ ?>
    <div class="row py-2 text-center bg-danger">
        <p class="text-white m-0">Une erreur est survenue lors de la suppression de votre manager. Merci de réessayer ultérieurement.</p>
    </div>
<?php }
if(!empty($_GET['error']) && $_GET['error'] == 'addManager'){ ?>
    <div class="row py-2 text-center bg-danger">
        <p class="text-white m-0">Une erreur est survenue lors de l'ajout de votre manager. Merci de vérifier vos informations.</p>
    </div>
<?php }
if(!empty($_GET['error']) && $_GET['error'] == 'emailManager'){ ?>
    <div class="row py-2 text-center bg-danger">
        <p class="text-white m-0">Cette adresse email est déjà attribuée à un compte manager.</p>
    </div>
<?php }
if(!empty($_GET['error']) && $_GET['error'] == 'activeManager'){ ?>
    <div class="row py-2 text-center bg-danger">
        <p class="text-white m-0">Vous ne pouvez pas supprimer ce manager, il gère actuellement un hôtel. Vous devez d'abord créer et / ou associer un nouveau manager à son hôtel !</p>
    </div>
<?php }
if(!empty($_GET['success']) && $_GET['success'] == 'modifyManager'){ ?>
    <div class="row py-2 text-center bg-success">
        <p class="text-white m-0">Votre manager a été modifié avec succès !</p>
    </div>
<?php }
if(!empty($_GET['success']) && $_GET['success'] == 'deleteManager'){ ?>
    <div class="row py-2 text-center bg-success">
        <p class="text-white m-0">Votre manager a été supprimé avec succès !</p>
    </div>
<?php }
if(!empty($_GET['success']) && $_GET['success'] == 'addManager'){ ?>
    <div class="row py-2 text-center bg-success">
        <p class="text-white m-0">Votre manager a été ajouté avec succès !</p>
    </div>
<?php }
?>
<section class="row px-lg-5 mt-5">
    <div class="col-12 text-center mb-5">
        <h2 class="text-tilered mb-5">Espace administrateur</h2>
        <h4 class="text-gold">Bonjour <?= $_SESSION['user'] ?> !</h4>
    </div>
    <!-- Partie qui affiche les managers, les hotels et les messages -->
    <div class="col-12">
        <div class="row">

            <!-- LES MANAGERS -->
            <div class="col-12 col-lg-4 rounded bg-offwhite d-flex flex-column  mt-3" id="managers">
                <h4 class="text-gold mb-3 align-self-center">Vos managers</h4>
                <a href="#" class="border-gold text-dblue rounded-pill mx-5 p-1 text-center" data-bs-toggle="modal" data-bs-target="#addManager"><i class="bi bi-plus"></i> nouveau manager</a>
                <div class="mt-5 row">
                    <?php
                    $managersReq = $bdd->prepare('SELECT managers.*, hotels.name 
                                                FROM managers
                                                LEFT JOIN hotels ON hotels.manager_id = managers.id');
                    $managersReq->execute();

                    function hotel($value){
                        if($value !== null){
                            return ' - '.$value;
                        }
                    }
                    while($manager = $managersReq->fetch(PDO::FETCH_ASSOC)){ ?>
                        <p class="col-8 col-sm-9"><?= $manager['firstname'].' '. $manager['lastname']. hotel($manager['name']) ?></p>
                        <div class="col-4 col-sm-3 text-end">
                            <a class="px-2 btn" data-bs-toggle="modal" data-bs-target="#modifyManager<?= $manager['id']?>"><i class="bi bi-pencil text-primary"></i></a>
                            <a class="px-2 btn" data-bs-toggle="modal" data-bs-target="#deleteManager<?= $manager['id']?>"><i class="bi bi-x-lg text-danger"></i></a>
                        </div>                        

                        <!-- Modal modif manager -->
                        <div class="modal fade" id="modifyManager<?= $manager['id']?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header border-0">
                                        <h5 class="modal-title text-gold" id="manager<?= $manager['id']?>Label"><?= $manager['firstname'].' '. $manager['lastname']. ' - '.$manager['name'] ?></h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="" method="post">
                                            <input class="d-none" name="managerId" value="<?= $manager['id'] ?>"></input>
                                            <div class="mb-3 col-12">
                                                <label for="firstname" class="form-label text-gold">Prénom</label>
                                                <input type="text" class="form-control" id="firstname" name="firstname" value="<?= $manager['firstname'] ?>" required>
                                                <div id="firstnameHelp" class="form-text text-danger d-none">Veuillez entrer un prénom valide</div>
                                            </div>
                                            <div class="mb-3 col-12">
                                                <label for="lastname" class="form-label text-gold">Nom</label>
                                                <input type="text" class="form-control" id="lastname" name="lastname" value="<?= $manager['lastname'] ?>" required>
                                                <div id="lastnameHelp" class="form-text text-danger d-none">Veuillez entrer un nom valide</div>
                                            </div>
                                            <div class="mb-3 col-12">
                                                <label for="email" class="form-label text-gold">Email</label>
                                                <input type="email" class="form-control" id="email" name="email" value="<?= $manager['email'] ?>" required>
                                                <div id="emailHelp" class="form-text text-danger d-none">Veuillez entrer une adresse valide</div>
                                            </div>
                                            <div class="mb-3 col-12">
                                                <label for="password" class="form-label text-gold">Mot de passe</label>
                                                <input type="password" class="form-control" id="password" name="password" value="" required>
                                                <div id="pwdHelp" class="form-text text-danger d-none">Votre mot de passe doit contenir entre 8 et 15 caractères, dont 1 maj., 1 min., 1 chiffre et 1 caractère spécial</div>
                                            </div>
                                            <div class="modal-body d-flex px-md-5 ">
                                                <button type="button" class="btn flex-fill me-1 bg-offwhite text-dblue border-gold rounded-pill" data-bs-dismiss="modal">annuler</button>
                                                <button type="submit" id="modifyManager" name="modifyManager" class="btn flex-fill ms-1 bg-gold text-offwhite rounded-pill">modifier</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal supprimer manager -->
                        <div class="modal fade" id="deleteManager<?= $manager['id']?>" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header border-0">
                                            <h5 class="modal-title text-gold" id="manager<?= $manager['id']?>Label">Êtes-vous sûr de vouloir supprimer <?= $manager['firstname'].' '. $manager['lastname'] ?> ?</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body d-flex px-md-5 ">
                                            <a class="btn flex-fill me-1 bg-offwhite text-dblue border-gold rounded-pill" data-bs-dismiss="modal">annuler</a>
                                            <a href="./adminDashboard.php?deleteManager=<?= $manager['id']?>" class="btn flex-fill ms-1 bg-gold text-offwhite rounded-pill">supprimer</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    
                    
                    
                    
                    
                    
                    
                    
                    
                    <?php }
                    ?>
                </div>
                <!-- Modal add manager -->
                <div class="modal fade" id="addManager" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header border-0">
                                <h5 class="modal-title text-gold" id="addManagerLabel">Ajouter un manager</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="" method="post">
                                    <div class="mb-3 col-12">
                                        <label for="newfirstname" class="form-label text-gold">Prénom</label>
                                        <input type="text" class="form-control" id="newfirstname" name="newfirstname" required>
                                        <div id="newfirstnameHelp" class="form-text text-danger d-none">Veuillez entrer un prénom valide</div>
                                    </div>
                                    <div class="mb-3 col-12">
                                        <label for="newlastname" class="form-label text-gold">Nom</label>
                                        <input type="text" class="form-control" id="newlastname" name="newlastname" required>
                                        <div id="newlastnameHelp" class="form-text text-danger d-none">Veuillez entrer un nom valide</div>
                                    </div>
                                    <div class="mb-3 col-12">
                                        <label for="newemail" class="form-label text-gold">Email</label>
                                        <input type="email" class="form-control" id="newemail" name="newemail" required>
                                        <div id="newemailHelp" class="form-text text-danger d-none">Veuillez entrer une adresse valide</div>
                                    </div>
                                    <div class="mb-3 col-12">
                                        <label for="newpassword" class="form-label text-gold">Mot de passe</label>
                                        <input type="password" class="form-control" id="newpassword" name="newpassword" required>
                                        <div id="newpwdHelp" class="form-text text-danger d-none">Votre mot de passe doit contenir entre 8 et 15 caractères, dont 1 maj., 1 min., 1 chiffre et 1 caractère spécial</div>
                                    </div>
                                    <div class=" d-flex px-md-5 ">
                                        <button type="button" class="btn flex-fill me-1 bg-offwhite text-dblue border-gold rounded-pill" data-bs-dismiss="modal">annuler</button>
                                        <button type="submit" id="addManagerBtn" name="addManager" class="btn flex-fill ms-1 bg-gold text-offwhite rounded-pill">ajouter</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- LES HOTELS -->
            <div class="col-12 col-lg-4 rounded bg-offwhite d-flex flex-column mt-3" id="hotels">
                <h4 class="text-gold mb-3 align-self-center">Vos hôtels</h4>
                <a href="#" class="border-gold text-dblue rounded-pill mx-5 p-1 text-center"><i class="bi bi-plus"></i> nouvel hôtel</a>
                <div class="mt-5 row">
                <?php
                    $hotelsReq = $bdd->prepare('SELECT * 
                                                FROM hotels');
                    $hotelsReq->execute();
                    while($hotel = $hotelsReq->fetch(PDO::FETCH_ASSOC)){ ?>
                        <p class="col-8 col-sm-9"><?= $hotel['name'].' - '. $hotel['city'] ?></p>
                        <div class="col-4 col-sm-3 text-end">
                            <a class="px-2" href="./adminDashboard.php?modify=hotel<?= $hotel['id']?>"><i class="bi bi-pencil text-primary"></i></a>
                            <a class="px-2" href="./adminDashboard.php?delete=hotel<?= $hotel['id']?>"><i class="bi bi-x-lg text-danger"></i></a>
                        </div>
                    <?php }
                    ?>
                </div>
            </div>

            <!-- LES MESSAGES -->
            <div class="col-12 col-lg-4 rounded bg-offwhite d-flex flex-column mt-3" id="messages">
                <h4 class="text-gold mb-3 align-self-center">Vos messages</h4>
                <?php 
                $newMessages = $bdd->prepare('SELECT * FROM contactRequests WHERE requestStatus_id = 1');
                $newMessages->execute();
                $newMessagesCount = $newMessages->rowCount();
                if($newMessagesCount === 0){ ?>
                    <p href="#" class="border-gold text-dblue rounded-pill mx-5 p-1 mb-0 text-center">pas de nouveau message !</p>
                <?php } else if($newMessagesCount ===1){ ?>
                    <p href="#" class="border-gold text-dblue rounded-pill mx-5 p-1 mb-0 text-center"><?= $newMessagesCount ?> nouveau message</p>
                <?php } else { ?>
                    <p href="#" class="border-gold text-dblue rounded-pill mx-5 p-1 mb-0 text-center"><?= $newMessagesCount ?> nouveaux messages</p>
                <?php }
                ?>
                <div class="mt-5 row">
                <?php
                    $contactsReq = $bdd->prepare('SELECT * 
                                                FROM contactRequests
                                                JOIN topics ON topics.id = contactRequests.topic_id
                                                ORDER BY requestDate DESC');
                    $contactsReq->execute();
                    while($message = $contactsReq->fetch(PDO::FETCH_ASSOC)){ 
                        if($message['requestStatus_id'] == 1){ ?>
                            <p class="col-8 col-sm-9  regular text-gold"><?= $message['firstname'].' '. $message['lastname'].' - '.$message['name'] ?></p>
                            <div class="col-4 col-sm-3 text-end">
                                <a class="px-2" href="#"><i class="bi bi-envelope text-primary"></i></a>
                                <a class="px-2" href="./adminDashboard.php?delete=message<?= $message['id']?>"><i class="bi bi-x-lg text-danger"></i></a>
                            </div>
                        <?php } else { ?>
                            <p class="col-8 col-sm-9"><?= $message['firstname'].' '. $message['lastname'].' - '.$message['name'] ?></p>
                            <div class="col-4 col-sm-3 text-end">
                                <a class="px-2" href="#"><i class="bi bi-envelope-open text-grey"></i></a>
                                <a class="px-2" href="./adminDashboard.php?delete=message<?= $message['id']?>"><i class="bi bi-x-lg text-danger"></i></a>
                            </div>
                        <?php }
                            ?>
                    <?php }
                    ?>
                </div>
            </div>




        </div>
    </div>

</section>

<?php
require_once('./components/footer.php');
?>
</main>
<script src="./components/scripts/functions.js"></script>
<script src="./components/scripts/adminDashboard.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>