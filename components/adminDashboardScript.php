<?php
if(isset($_POST['modifyManager'])){
    if(!empty($_POST['managerId']) &&
        !empty($_POST['firstname']) &&
        !empty($_POST['lastname']) &&
        !empty($_POST['email']) &&
        !empty($_POST['password']) 
    ){
        // FONCTIONS DE VALIDATION
        require_once('./components/functions.php');

        // VARIABLES
        $managerId = htmlspecialchars($_POST['managerId']) ;
        $managerFirstname = htmlspecialchars($_POST['firstname']) ;
        $managerLastname = htmlspecialchars($_POST['lastname']);
        $managerEmail = htmlspecialchars($_POST['email']) ;
        $managerPassword = htmlspecialchars($_POST['password']);

        // VERIFICATION SI ID EXISTE DANS LA BDD
        $managerReq = $bdd->prepare('SELECT * FROM managers WHERE id = :id');
        $managerReq->bindValue(':id', $managerId, PDO::PARAM_INT);
        $managerReq->execute();
        $managerCount = $managerReq->rowCount();

        // VERIFICATIONS
        if(checkName($managerFirstname) === false ||
        checkName($managerLastname) === false ||
        checkEmail($managerEmail) === false ||
        checkPwd($managerPassword) === false){
            header('location:./adminDashboard.php?error=modifyManager1');
        } else if ($managerCount === 0){
            header('location:./adminDashboard.php?error=modifyManager2');
        } else {
            // PWD ENCRYPT
            $password = password_hash($managerPassword, PASSWORD_BCRYPT);
            $modifyManagerReq = $bdd->prepare('UPDATE managers
                                                SET firstname = :fn, lastname = :ln, email = :email, password = :pw
                                                WHERE id = :id;');
            $modifyManagerReq->bindValue(':id', $managerId);
            $modifyManagerReq->bindValue(':fn', $managerFirstname);
            $modifyManagerReq->bindValue(':ln', $managerLastname);
            $modifyManagerReq->bindValue(':email', $managerEmail);
            $modifyManagerReq->bindValue(':pw', $password);
            $modifyManagerReq->execute();
            header('location:./adminDashboard.php?success=modifyManager');
        }
    } else {
        header('location:./adminDashboard.php?error=modifyManager');
    }

}

if(!empty($_GET['deleteManager'])){
    $managerId = htmlspecialchars($_GET['deleteManager']);
    $managerId = intval($managerId);
    if($managerId && $managerId > 0){
        $managerHotelReq = $bdd->prepare('SELECT * FROM hotels WHERE manager_id = :mid ;');
        $managerHotelReq->bindValue(':mid', $managerId, PDO::PARAM_INT);
        $managerHotelReq->execute();
        $hotelCount = $managerHotelReq->rowCount();
        if($hotelCount === 0){
            // on supprime
            $deleteManager = $bdd->prepare('DELETE FROM managers WHERE id = :id;');
            $deleteManager->bindValue(':id', $managerId, PDO::PARAM_INT);
            $deleteManager->execute();
            header('location:./adminDashboard.php?success=deleteManager');
        } else {
            header('location:./adminDashboard.php?error=activeManager');
        }
    } else {
        header('location:./adminDashboard.php?error=deleteManager');
    }
}