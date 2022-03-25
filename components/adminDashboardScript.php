<?php

// AJOUT MANAGER
if(isset($_POST['addManager'])){
    if (!empty($_POST['newfirstname']) && 
            !empty($_POST['newlastname']) && 
            !empty($_POST['newemail']) && 
            !empty($_POST['newpassword'])){
    require_once('./components/functions.php');
    // VARIABLES
    $firstname = htmlspecialchars($_POST['newfirstname']);
    $lastname = htmlspecialchars($_POST['newlastname']);
    $email = htmlspecialchars($_POST['newemail']);
    $password = htmlspecialchars($_POST['newpassword']);

    // VERIFICATION SI EMAIL EXISTE DANS LA BDD
    $managersReq = $bdd->prepare('SELECT * FROM managers WHERE email = :email');
    $managersReq->bindValue(':email', $email);
    $managersReq->execute();
    $managerCount = $managersReq->rowCount();

    // VERIFICATIONS
    if(checkName($firstname) === false ||
        checkName($lastname) === false ||
        checkEmail($email) === false ||
        checkPwd($password) === false){
            header('location:./adminDashboard.php?error=addManager');
        } else if ($managerCount !== 0){
            header('location:./adminDashboard.php?error=emailManager');
        } else {
            // PWD ENCRYPT
            $password = password_hash($password, PASSWORD_BCRYPT);
            $newManager = $bdd->prepare('INSERT INTO managers (firstname, lastname, email, password) 
                                        VALUES (:fn, :ln, :email, :pw);');
            $newManager->bindValue(':fn', $firstname);
            $newManager->bindValue(':ln', $lastname);
            $newManager->bindValue(':email', $email);
            $newManager->bindValue(':pw', $password);
            $newManager->execute();
            header('location:./adminDashboard.php?success=addManager');
        }
    } else {
        header('location:./adminDashboard.php?error=addManager');
    }
}

// MODIFICATION MANAGER

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
            header('location:./adminDashboard.php?error=modifyManager');
        } else if ($managerCount === 0){
            header('location:./adminDashboard.php?error=modifyManager');
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
// SUPPRESSION MANAGER
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

// AJOUT HOTEL

if(isset($_POST['addHotel'])){
    if(!empty($_POST['hotelName']) &&
        !empty($_POST['address']) &&
        !empty($_POST['city']) &&
        !empty($_POST['description']) &&
        !empty($_POST['hotelManager'])
    ){
        $hotelName = htmlspecialchars($_POST['hotelName']);
        $address = htmlspecialchars($_POST['address']);
        $city = htmlspecialchars($_POST['city']);
        $description = htmlspecialchars($_POST['description']);
        $hotelManager = htmlspecialchars($_POST['hotelManager']);

        $hotelManagerId = intval($hotelManager);
        if($hotelManagerId && $hotelManagerId > 0){
            require_once('./components/functions.php');
            // VERIF QUE LE MANAGER SOIT VRAIMENT DISPO
            $isAvailable = $bdd->prepare('SELECT * FROM hotels WHERE manager_id = :mid ;');
            $isAvailable->bindValue(':mid', $hotelManagerId, PDO::PARAM_INT);
            $isAvailable->execute();
            $managerCount = $isAvailable->rowCount();
            if(checkName($hotelName) === false ||
                checkName($city) === false ||
                checkAddress($address) === false ||
                strlen($description) > 2000 ||
                $managerCount !== 0
            ){
                header('location:./adminDashboard.php?error=addHotel');
            } else {
                $addHotel = $bdd->prepare('INSERT INTO hotels (name, city, address, description, manager_id) 
                                        VALUES (:name, :city, :add, :desc, :mid); ');
                $addHotel->bindValue(':name', $hotelName, PDO::PARAM_STR);
                $addHotel->bindValue(':city', $city, PDO::PARAM_STR);
                $addHotel->bindValue(':add', $address, PDO::PARAM_STR);
                $addHotel->bindValue(':desc', $description, PDO::PARAM_STR);
                $addHotel->bindValue(':mid', $hotelManagerId, PDO::PARAM_INT);
                $addHotel->execute();
                header('location:./adminDashboard.php?success=addHotel');
            }
        } else {
            header('location:./adminDashboard.php?error=addHotel');
        }
    } else {
        header('location:./adminDashboard.php?error=addHotel');
    }
}

// SUPPRESSION HOTEL
if(!empty($_GET['deleteHotel'])){
    $hotelId = htmlspecialchars($_GET['deleteHotel']);
    $hotelId = intval($hotelId);
    if($hotelId && $hotelId > 0){
        $hotelReq = $bdd->prepare('SELECT * FROM hotels WHERE id = :id ;');
        $hotelReq->bindValue(':id', $hotelId, PDO::PARAM_INT);
        $hotelReq->execute();
        $hotelCount = $hotelReq->rowCount();
        if($hotelCount === 1){
            $deleteHotel = $bdd->prepare('DELETE FROM hotels WHERE id = :id ;');
            $deleteHotel->bindValue(':id', $hotelId, PDO::PARAM_INT);
            $deleteHotel->execute();
            header('location:./adminDashboard.php?success=deleteHotel');
        } else {
            header('location:./adminDashboard.php?error=deleteHotel');
        }
    } else {
        header('location:./adminDashboard.php?error=deleteHotel');
    }
}

// MODIFICATION HOTEL

if(isset($_POST['modifyHotel'])){
    if(!empty($_POST['newhotelName']) &&
        !empty($_POST['newaddress']) &&
        !empty($_POST['newcity']) &&
        !empty($_POST['newdescription']) &&
        !empty($_POST['newhotelManager'])
    ){
        $hotelId = htmlspecialchars($_POST['hotelId']);
        $hotelName = htmlspecialchars($_POST['newhotelName']);
        $address = htmlspecialchars($_POST['newaddress']);
        $city = htmlspecialchars($_POST['newcity']);
        $description = htmlspecialchars($_POST['newdescription']);
        $hotelManager = htmlspecialchars($_POST['newhotelManager']);

        $hotelManagerId = intval($hotelManager);
        if($hotelManagerId && $hotelManagerId > 0){
            require_once('./components/functions.php');
            if(checkName($hotelName) === false ||
                checkName($city) === false ||
                checkAddress($address) === false ||
                strlen($description) > 2000
            ){
                header('location:./adminDashboard.php?error=modifyHotel');
            } else {
                $modifyHotel = $bdd->prepare('UPDATE hotels SET name = :name, city = :city, address = :add, description = :desc , manager_id = :mid
                                                WHERE id = :id ');
                $modifyHotel->bindValue(':id', $hotelId, PDO::PARAM_STR);
                $modifyHotel->bindValue(':name', $hotelName, PDO::PARAM_STR);
                $modifyHotel->bindValue(':city', $city, PDO::PARAM_STR);
                $modifyHotel->bindValue(':add', $address, PDO::PARAM_STR);
                $modifyHotel->bindValue(':desc', $description, PDO::PARAM_STR);
                $modifyHotel->bindValue(':mid', $hotelManagerId, PDO::PARAM_INT);
                $modifyHotel->execute();
                header('location:./adminDashboard.php?success=modifyHotel');
            }
        } else {
            header('location:./adminDashboard.php?error=modifyHotel');
        }
    } else {
        header('location:./adminDashboard.php?error=modifyHotel');
    }
}


// SUPPRESSION MESSAGE
if(!empty($_GET['deleteMessage'])){
    $messageId = htmlspecialchars($_GET['deleteMessage']);
    $messageId = intval($messageId);
    if($messageId && $messageId > 0){
        $messageReq = $bdd->prepare('SELECT * FROM contactRequests WHERE id = :id ;');
        $messageReq->bindValue(':id', $messageId, PDO::PARAM_INT);
        $messageReq->execute();
        $messageCount = $messageReq->rowCount();
        if($messageCount === 1){
            $deleteMessage = $bdd->prepare('DELETE FROM contactRequests WHERE id = :id ;');
            $deleteMessage->bindValue(':id', $messageId, PDO::PARAM_INT);
            $deleteMessage->execute();
            header('location:./adminDashboard.php?success=deleteMessage');
        } else {
            header('location:./adminDashboard.php?error=deleteMessage');
        }
    } else {
        header('location:./adminDashboard.php?error=deleteMessage');
    }
}