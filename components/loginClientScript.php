<?php
if(!empty($_POST['emailLogIn']) && !empty($_POST['passwordLogIn'])){
    
    // VARIABLES
    $email = htmlspecialchars($_POST['emailLogIn']);
    $password = htmlspecialchars($_POST['passwordLogIn']);

    // VERIFICATION EMAIL/PWD
    $userReq = $bdd->prepare('SELECT * FROM clients WHERE email = :email');
    $userReq->bindValue(':email', $email, PDO::PARAM_STR);
    $userReq->execute();
    $user = $userReq->fetch(PDO::FETCH_ASSOC);

    if(isset($user['email']) && password_verify($password, $user['password'])){
        $_SESSION['connect'] = 'client';
        $_SESSION['user'] = $user['firstname'];
        $_SESSION['userId'] = $user['id'];
        header('location:./myBookings.php');
    } else {
        header('location:./loginClient.php?error=invalid');
    }
} else if (!empty($_POST['firstname']) && 
            !empty($_POST['lastname']) && 
            !empty($_POST['emailSignIn']) && 
            !empty($_POST['passwordSignIn'])){
    require_once('./components/functions.php');
    // VARIABLES
    $firstname = htmlspecialchars($_POST['firstname']);
    $lastname = htmlspecialchars($_POST['lastname']);
    $email = htmlspecialchars($_POST['emailSignIn']);
    $password = htmlspecialchars($_POST['passwordSignIn']);

    // VERIFICATION SI EMAIL EXISTE DANS LA BDD
    $clientsReq = $bdd->prepare('SELECT * FROM clients WHERE email = :email');
    $clientsReq->bindValue(':email', $email);
    $clientsReq->execute();
    $clientCount = $clientsReq->rowCount();

    // VERIFICATIONS
    if(checkName($firstname) === false ||
        checkName($lastname) === false ||
        checkEmail($email) === false ||
        checkPwd($password) === false){
            header('location:./loginClient.php?error=signupfail');
        } else if ($clientCount !== 0){
            header('location:./loginClient.php?error=email');
        } else {
        // PWD ENCRYPT
        $password = password_hash($password, PASSWORD_BCRYPT);
        $newClient = $bdd->prepare('INSERT INTO clients (firstname, lastname, email, password) 
                                    VALUES (:fn, :ln, :email, :pw);');
        $newClient->bindValue(':fn', $firstname);
        $newClient->bindValue(':ln', $lastname);
        $newClient->bindValue(':email', $email);
        $newClient->bindValue(':pw', $password);
        $newClient->execute();
        header('location:./loginClient.php?signup=success');
    }
}