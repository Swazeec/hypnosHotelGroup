<?php
session_start();
require_once('./components/db/db.php');
if(!isset($_GET['hotel'])){
    header('location:./adminDashboard.php?manager=invalid');
} else if(intval($_GET['hotel']) <= 0) {
    header('location:./adminDashboard.php?manager=invalid');
} else {
    $hotelId = htmlspecialchars($_GET['hotel']);
    $hotelsReq = $bdd->prepare('SELECT hotels.*, managers.firstname, managers.lastname FROM hotels JOIN managers ON managers.id = hotels.manager_id WHERE hotels.id = :id;');
    $hotelsReq->bindValue(':id', $hotelId, PDO::PARAM_INT);
    $hotelsReq->execute();
    $hotelCount = $hotelsReq->rowCount();
    if($hotelCount !== 1){
        header('location:./adminDashboard.php?hotel=invalid');
    } else {
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
        ?>
        <section class="row px-lg-5 mt-5">
            <?php
            $hotel = $hotelsReq->fetch(PDO::FETCH_ASSOC);
            ?>
            <div class="col-12 text-center mb-5">
                <h2 class="text-tilered mb-5">Modifier un hôtel :</h2>
                <h4 class="text-gold"><?= $hotel['name']?> </h4>
            </div>
            
            <form action="" method="post" class="col-12 col-md-8 offset-md-2 col-lg-6 offset-lg-3">
                <input class="d-none" name="hotelId" value="<?= $hotel['id'] ?>"></input>
                <div class="mb-3 col-12">
                    <label for="newhotelName" class="form-label text-gold">Nom</label>
                    <input type="text" class="form-control" id="newhotelName" name="newhotelName" value="<?= $hotel['name']?>" required>
                    <div id="newhotelNameHelp" class="form-text text-danger d-none">Veuillez entrer un nom valide</div>
                </div>
                <div class="mb-3 col-12">
                    <label for="newaddress" class="form-label text-gold">Adresse</label>
                    <input type="text" class="form-control" id="newaddress" name="newaddress" value="<?= $hotel['address']?>" required>
                    <div id="newaddressHelp" class="form-text text-danger d-none">Veuillez entrer une adresse valide</div>
                </div>
                <div class="mb-3 col-12">
                    <label for="newcity" class="form-label text-gold">Ville</label>
                    <input type="text" class="form-control" id="newcity" name="newcity" value="<?= $hotel['city']?>" required>
                    <div id="newcityHelp" class="form-text text-danger d-none">Veuillez entrer un nom valide</div>
                </div>
                <div class="mb-3 col-12">
                    <label for="newdescription" class="form-label text-gold">Description</label>
                    <textarea class="form-control" id="newdescription" name="newdescription" required><?= $hotel['description']?></textarea>
                    <div id="newdescriptionHelp" class="form-text text-danger d-none">Votre description peut contenir jusqu'à xxxx caractères</div>
                </div>
                <div class="mb-5 col-12">
                    <label for="newhotelManager" class="form-label text-gold">Manager</label>
                    <select class="form-select" id="newhotelManager" name="newhotelManager" required>
                        <!-- MANAGER ACTUEL -->
                        <option value="<?= $hotel['manager_id'] ?>"><?= $hotel['firstname'].' '. $hotel['lastname']  ?></option>
                        <?php
                        // MANAGERS N'ETANT PAS ENCORE ASSIGNES A UN HOTEL :
                        $availManagers = $bdd->prepare('SELECT * FROM managers
                                                        WHERE id NOT IN (SELECT manager_id FROM hotels)');
                        $availManagers->execute();
                        while($availManager = $availManagers->fetch(PDO::FETCH_ASSOC)){ ?>
                            <option value="<?= $availManager['id'] ?>"><?= $availManager['firstname'].' '. $availManager['lastname']  ?></option>
                        <?php } ?>
                    </select>
                    <div id="newhotelManagerHelp" class="form-text text-danger d-none">Veuillez sélectionner un manager valide</div>
                </div>
                <div class=" d-flex px-md-5 ">
                    <a href="./adminDashboard.php" type="button" class="btn flex-fill me-1 bg-offwhite text-dblue border-gold rounded-pill" >annuler</a>
                    <button type="submit" id="modifyHotelBtn" name="modifyHotel" class="btn flex-fill ms-1 bg-gold text-offwhite rounded-pill">modifier</button>
                </div>
            </form>
    
        </section>
        <?php
        require_once('./components/footer.php');

    }
    
    
    
}?>



</main>
<script src="./components/scripts/functions.js"></script>
<script src="./components/scripts/modifyHotel.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>