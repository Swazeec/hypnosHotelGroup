<?php
session_start();
require_once('./components/db/db.php');
if(!isset($_GET['manager'])){
    header('location:./adminDashboard.php?modify=invalid');
} else if(intval($_GET['manager']) <= 0) {
    header('location:./adminDashboard.php?modify=invalid');
} else {
    $managerId = htmlspecialchars($_GET['manager']);
    $managersReq = $bdd->prepare('SELECT * FROM managers WHERE id = :id;');
    $managersReq->bindValue(':id', $managerId, PDO::PARAM_INT);
    $managersReq->execute();
    $managerCount = $managersReq->rowCount();
    if($managerCount !== 1){
        header('location:./adminDashboard.php?modify=invalid');
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
            $manager = $managersReq->fetch(PDO::FETCH_ASSOC);
            ?>
            <div class="col-12 text-center mb-5">
                <h2 class="text-tilered mb-5">Modifier un manager :</h2>
                <h4 class="text-gold"><?= $manager['firstname'].' '. $manager['lastname'] ?> </h4>
            </div>
            
            <form action="" method="post" class="col-12 col-md-8 offset-md-2 col-lg-6 offset-lg-3">
                <input class="d-none" name="managerId" value="<?= $manager['id'] ?>"></input>
                <div class="mb-3 ">
                    <label for="firstname" class="form-label text-gold">Prénom</label>
                    <input type="text" class="form-control" id="firstname" name="firstname" value="<?= $manager['firstname'] ?>" required>
                    <div id="firstnameHelp" class="form-text text-danger d-none">Veuillez entrer un prénom valide</div>
                </div>
                <div class="mb-3 ">
                    <label for="lastname" class="form-label text-gold">Nom</label>
                    <input type="text" class="form-control" id="lastname" name="lastname" value="<?= $manager['lastname'] ?>" required>
                    <div id="lastnameHelp" class="form-text text-danger d-none">Veuillez entrer un nom valide</div>
                </div>
                <div class="mb-3 ">
                    <label for="email" class="form-label text-gold">Email</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?= $manager['email'] ?>" required>
                    <div id="emailHelp" class="form-text text-danger d-none">Veuillez entrer une adresse valide</div>
                </div>
                <div class="mb-3 ">
                    <label for="password" class="form-label text-gold">Mot de passe</label>
                    <input type="password" class="form-control" id="password" name="password" value="" required>
                    <div id="pwdHelp" class="form-text text-danger d-none">Votre mot de passe doit contenir entre 8 et 15 caractères, dont 1 maj., 1 min., 1 chiffre et 1 caractère spécial</div>
                </div>
                <div class="modal-body d-flex px-md-5 ">
                    <a href="./adminDashboard.php" type="button" class="btn flex-fill me-1 bg-offwhite text-dblue border-gold rounded-pill" >annuler</a>
                    <button type="submit" id="modifyManager" name="modifyManager" class="btn flex-fill ms-1 bg-gold text-offwhite rounded-pill">modifier</button>
                </div>
            </form>
    
        </section>
        <?php
        require_once('./components/footer.php');

    }
    
    
    
}?>



</main>
<script src="./components/scripts/functions.js"></script>
<script src="./components/scripts/modifyManager.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>