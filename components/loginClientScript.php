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
}