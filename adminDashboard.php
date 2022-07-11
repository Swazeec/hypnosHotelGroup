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
if(!empty($_GET['modify']) && $_GET['modify'] == 'invalid'){ ?>
    <div class="row py-2 text-center bg-danger">
        <p class="text-white m-0">Une erreur est survenue lors de la demande de modification. Merci de réessayer ultérieurement.</p>
    </div>
<?php }
if(!empty($_GET['error']) && $_GET['error'] == 'modifyManager'){ ?>
    <div class="row py-2 text-center bg-danger">
        <p class="text-white m-0">Une erreur est survenue lors de la modification de votre manager. Merci de réessayer ultérieurement.</p>
    </div>
<?php }
if(!empty($_GET['error']) && $_GET['error'] == 'modifyHotel'){ ?>
    <div class="row py-2 text-center bg-danger">
        <p class="text-white m-0">Une erreur est survenue lors de la modification de votre hôtel. Merci de réessayer ultérieurement.</p>
    </div>
<?php }
if(!empty($_GET['error']) && $_GET['error'] == 'deleteManager'){ ?>
    <div class="row py-2 text-center bg-danger">
        <p class="text-white m-0">Une erreur est survenue lors de la suppression de votre manager. Merci de réessayer ultérieurement.</p>
    </div>
<?php }
if(!empty($_GET['error']) && $_GET['error'] == 'deleteHotel'){ ?>
    <div class="row py-2 text-center bg-danger">
        <p class="text-white m-0">Une erreur est survenue lors de la suppression de votre hôtel. Merci de réessayer ultérieurement.</p>
    </div>
<?php }
if(!empty($_GET['error']) && $_GET['error'] == 'deleteMessage'){ ?>
    <div class="row py-2 text-center bg-danger">
        <p class="text-white m-0">Une erreur est survenue lors de la suppression de votre message. Merci de réessayer ultérieurement.</p>
    </div>
<?php }
if(!empty($_GET['error']) && $_GET['error'] == 'addManager'){ ?>
    <div class="row py-2 text-center bg-danger">
        <p class="text-white m-0">Une erreur est survenue lors de l'ajout de votre manager. Merci de vérifier vos informations.</p>
    </div>
<?php }
if(!empty($_GET['error']) && $_GET['error'] == 'addHotel'){ ?>
    <div class="row py-2 text-center bg-danger">
        <p class="text-white m-0">Une erreur est survenue lors de l'ajout de votre hôtel. Merci de vérifier vos informations.</p>
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
if(!empty($_GET['success']) && $_GET['success'] == 'modifyHotel'){ ?>
    <div class="row py-2 text-center bg-success">
        <p class="text-white m-0">Votre hôtel a été modifié avec succès !</p>
    </div>
<?php }
if(!empty($_GET['success']) && $_GET['success'] == 'deleteManager'){ ?>
    <div class="row py-2 text-center bg-success">
        <p class="text-white m-0">Votre manager a été supprimé avec succès !</p>
    </div>
<?php }
if(!empty($_GET['success']) && $_GET['success'] == 'deleteHotel'){ ?>
    <div class="row py-2 text-center bg-success">
        <p class="text-white m-0">Votre hôtel, ses suites et réservations ont été supprimés avec succès !</p>
    </div>
<?php }
if(!empty($_GET['success']) && $_GET['success'] == 'deleteMessage'){ ?>
    <div class="row py-2 text-center bg-success">
        <p class="text-white m-0">Votre message a été supprimé avec succès !</p>
    </div>
<?php }
if(!empty($_GET['success']) && $_GET['success'] == 'addManager'){ ?>
    <div class="row py-2 text-center bg-success">
        <p class="text-white m-0">Votre manager a été ajouté avec succès !</p>
    </div>
<?php }
if(!empty($_GET['success']) && $_GET['success'] == 'addHotel'){ ?>
    <div class="row py-2 text-center bg-success">
        <p class="text-white m-0">Votre hôtel a été ajouté avec succès !</p>
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
                            <a class="px-2 btn" href="./modifyManager.php?manager=<?= $manager['id']?>" ><i class="bi bi-pencil text-primary"></i></a>
                            <a class="px-2 btn" data-bs-toggle="modal" data-bs-target="#deleteManager<?= $manager['id']?>"><i class="bi bi-x-lg text-danger"></i></a>
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
                                        <input type="text" class="form-control" id="newfirstname" name="newfirstname" required >
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
                <a href="#" class="border-gold text-dblue rounded-pill mx-5 p-1 text-center" data-bs-toggle="modal" data-bs-target="#addHotel"><i class="bi bi-plus"></i> nouvel hôtel</a>
                <div class="mt-5 row">
                <?php
                    $hotelsReq = $bdd->prepare('SELECT hotels.*, managers.firstname, managers.lastname
                                                FROM hotels
                                                JOIN managers ON managers.id = hotels.manager_id ');
                    $hotelsReq->execute();
                    while($hotel = $hotelsReq->fetch(PDO::FETCH_ASSOC)){ ?>
                        <p class="col-8 col-sm-9"><?= $hotel['name'].' - '. $hotel['city'] ?></p>
                        <div class="col-4 col-sm-3 text-end">
                            <a class="px-2" href="./modifyHotel.php?hotel=<?= $hotel['id']?>"><i class="bi bi-pencil text-primary"></i></a>
                            <a class="px-2" href="#" data-bs-toggle="modal" data-bs-target="#deleteHotel<?= $hotel['id']?>"><i class="bi bi-x-lg text-danger"></i></a>
                        </div>
                        <!-- Modal supprimer hotel -->
                        <div class="modal fade" id="deleteHotel<?= $hotel['id']?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header border-0">
                                        <div class="modal-title">
                                            <h5 class="text-gold" id="manager<?= $hotel['id']?>Label">Êtes-vous sûr de vouloir supprimer l'<?= $hotel['name'] ?> ?</h5>
                                            <p class="text-danger"><i class="bi bi-exclamation-circle-fill text-danger"></i> ATTENTION !!! <br>Cela entrainera la suppression de toutes ses chambres et des réservations passées.</p>

                                        </div>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body d-flex px-md-5 ">
                                        <a class="btn flex-fill me-1 bg-offwhite text-dblue border-gold rounded-pill" data-bs-dismiss="modal">annuler</a>
                                        <a href="./adminDashboard.php?deleteHotel=<?= $hotel['id']?>" class="btn flex-fill ms-1 bg-gold text-offwhite rounded-pill">supprimer</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    <?php }
                    ?>
                </div>

                <!-- MODAL ADD HOTEL -->
                <div class="modal fade" id="addHotel" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header border-0">
                                <h5 class="modal-title text-gold" id="addHotelLabel">Ajouter un hôtel</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="" method="post">
                                    <div class="mb-3 col-12">
                                        <label for="hotelName" class="form-label text-gold">Nom</label>
                                        <input type="text" class="form-control" id="hotelName" name="hotelName" required>
                                        <div id="hotelNameHelp" class="form-text text-danger d-none">Veuillez entrer un nom valide</div>
                                    </div>
                                    <div class="mb-3 col-12">
                                        <label for="address" class="form-label text-gold">Adresse</label>
                                        <input type="text" class="form-control" id="address" name="address" required>
                                        <div id="addressHelp" class="form-text text-danger d-none">Veuillez entrer une adresse valide</div>
                                    </div>
                                    <div class="mb-3 col-12">
                                        <label for="city" class="form-label text-gold">Ville</label>
                                        <input type="text" class="form-control" id="city" name="city" required>
                                        <div id="cityHelp" class="form-text text-danger d-none">Veuillez entrer un nom valide</div>
                                    </div>
                                    <div class="mb-3 col-12">
                                        <label for="description" class="form-label text-gold">Description</label>
                                        <textarea class="form-control" id="description" name="description" required></textarea>
                                        <div id="descriptionHelp" class="form-text text-danger d-none">Votre description peut contenir jusqu'à 2000 caractères</div>
                                    </div>
                                    <div class="mb-5 col-12">
                                        <label for="hotelManager" class="form-label text-gold">Manager</label>
                                        <?php
                                        // MANAGERS N'ETANT PAS ENCORE ASSIGNES A UN HOTEL :
                                        $availManagers = $bdd->prepare('SELECT * FROM managers
                                                                        WHERE id NOT IN (SELECT manager_id FROM hotels)');
                                        $availManagers->execute();
                                        $availManagersCount = $availManagers->rowCount();
                                        if($availManagersCount === 0){ ?>
                                            <p>Merci d'ajouter un manager à votre équipe au préalable</p>
                                        <?php } else { ?>
                                            <select class="form-select" id="hotelManager" name="hotelManager" required>
                                            <?php
                                            while($availManager = $availManagers->fetch(PDO::FETCH_ASSOC)){ ?>
                                                <option value="<?= $availManager['id'] ?>"><?= $availManager['firstname'].' '. $availManager['lastname']  ?></option>
                                            <?php } ?>
                                            </select>
                                            <div id="hotelManagerHelp" class="form-text text-danger d-none">Veuillez sélectionner un manager valide</div>
                                        <?php } ?>
                                    </div>
                                    <div class=" d-flex px-md-5 ">
                                        <button type="button" class="btn flex-fill me-1 bg-offwhite text-dblue border-gold rounded-pill" data-bs-dismiss="modal">annuler</button>
                                        <?php
                                        if($availManagersCount !== 0){ ?>
                                            <button type="submit" id="addHotelBtn" name="addHotel" class="btn flex-fill ms-1 bg-gold text-offwhite rounded-pill">ajouter</button>
                                        <?php } ?>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

             
        
            <!-- LES MESSAGES -->
            <div class="col-12 col-lg-4 rounded bg-offwhite d-flex flex-column mt-3" id="messages">
                <h4 class="text-gold mb-3 align-self-center">Vos messages</h4>
                <?php 
                $bdd->query('SET lc_time_names = \'fr_FR\'');
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
                    $contactsReq = $bdd->prepare('SELECT contactRequests.id,
                                                        contactRequests.firstname,
                                                        contactRequests.lastname,
                                                        contactRequests.email,
                                                        contactRequests.message,
                                                        contactRequests.client_id,
                                                        contactRequests.requestStatus_id,
                                                        DATE_FORMAT(contactRequests.requestDate, "%d/%m/%Y") AS requestDate,
                                                        topics.name 
                                                FROM contactRequests
                                                JOIN topics ON topics.id = contactRequests.topic_id
                                                ORDER BY requestDate DESC');
                    $contactsReq->execute();
                    while($message = $contactsReq->fetch(PDO::FETCH_ASSOC)){ 
                        if($message['requestStatus_id'] == 1){ ?>
                            <p class="col-8 col-sm-9  regular text-gold"><?= $message['firstname'].' '. $message['lastname'].' - '.$message['name'] ?></p>
                            <div class="col-4 col-sm-3 text-end">
                                <a class="px-2" href="#" data-bs-toggle="modal" data-bs-target="#readMessage<?= $message['id']?>"><i class="bi bi-envelope text-primary"></i></a>
                                <a class="px-2" href="#" data-bs-toggle="modal" data-bs-target="#deleteMessage<?= $message['id']?>"><i class="bi bi-x-lg text-danger"></i></a>
                            </div>
                        <?php } else { ?>
                            <p class="col-8 col-sm-9"><?= $message['firstname'].' '. $message['lastname'].' - '.$message['name'] ?></p>
                            <div class="col-4 col-sm-3 text-end">
                                <a class="px-2" href="#" data-bs-toggle="modal" data-bs-target="#readMessage<?= $message['id']?>"><i class="bi bi-envelope-open text-grey"></i></a>
                                <a class="px-2" href="#" data-bs-toggle="modal" data-bs-target="#deleteMessage<?= $message['id']?>"><i class="bi bi-x-lg text-danger"></i></a>
                            </div>
                        <?php } ?>

                            <!-- Modal supprimer message -->
                        <div class="modal fade" id="deleteMessage<?= $message['id']?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header border-0">
                                        <div class="modal-title">
                                            <h5 class="text-gold" >Êtes-vous sûr de vouloir supprimer ce message ?</h5>
                                        </div>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body d-flex px-md-5 ">
                                        <a class="btn flex-fill me-1 bg-offwhite text-dblue border-gold rounded-pill" data-bs-dismiss="modal">annuler</a>
                                        <a href="./adminDashboard.php?deleteMessage=<?= $message['id']?>" class="btn flex-fill ms-1 bg-gold text-offwhite rounded-pill">supprimer</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Modal LIRE message -->
                        <div class="modal fade" id="readMessage<?= $message['id']?>" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header border-0">
                                        <div class="modal-title">
                                            <h5 class="text-gold">Message de <?= $message['firstname'].' '.$message['lastname']?></h5>
                                            <?php
                                            if ($message['client_id'] !== null){ ?>
                                                <h6> (Client)</h6>
                                            <?php } else { ?>
                                                <h6> (Visiteur)</h6>
                                            <?php } ?>
                                        </div>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body py-0">
                                        <p>Reçu le : <?= $message['requestDate']?></p>
                                        <h6>Sujet : "<?= $message['name']?>"</h6>
                                        <p>Email : <?= $message['email']?></p>
                                        <p>Message : <?= $message['message']?></p>
                                    </div>
                                    <?php 
                                    if($message['requestStatus_id'] === 1){ ?>
                                    <!-- message non lu -> le passer en lu -->
                                        <div class="modal-footer border-0 d-flex px-md-5 ">
                                            <a class="btn flex-fill me-1 bg-offwhite text-dblue border-gold rounded-pill" data-bs-dismiss="modal">annuler</a>
                                            <a href="./adminDashboard.php?modifyMessage=<?= $message['id']?>" class="btn flex-fill ms-1 bg-gold text-offwhite rounded-pill">marquer comme lu</a>
                                        </div>
                                    <?php } else { ?>
                                    <!-- message déjà lu -> le passer en non-lu -->
                                        <div class="modal-footer border-0 d-flex px-md-5 ">
                                            <a class="btn flex-fill me-1 bg-offwhite text-dblue border-gold rounded-pill" data-bs-dismiss="modal">annuler</a>
                                            <a href="./adminDashboard.php?modifyMessage=<?= $message['id']?>" class="btn flex-fill ms-1 bg-gold text-offwhite rounded-pill">marquer comme non-lu</a>
                                        </div>
                                    <?php }
                                    ?>
                                </div>
                            </div>
                        </div>
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