<?php
if(!empty($_POST['emailLogIn']) && !empty($_POST['passwordLogIn'])){
    
    // VARIABLES
    $email = htmlspecialchars($_POST['emailLogIn']);
    $password = htmlspecialchars($_POST['passwordLogIn']);

    // ON VERIFIE SI ADMIN
    $adminReq = $bdd->prepare('SELECT * FROM admins WHERE email = :email');
    $adminReq->bindValue(':email', $email, PDO::PARAM_STR);
    $adminReq->execute();
    $admin = $adminReq->fetch(PDO::FETCH_ASSOC);
    if(isset($admin['email']) && password_verify($password, $admin['password'])){
        $_SESSION['connect'] = 'pro';
        $_SESSION['role'] = 'admin';
        $_SESSION['user'] = $admin['firstname'];
        $_SESSION['proId'] = $admin['id'];
        header('location:./adminDashboard.php');
        exit();
    } else {
        // SINON ON VERIFIE SI MANAGER
        $managerReq = $bdd->prepare('SELECT * FROM managers WHERE email = :email');
        $managerReq->bindValue(':email', $email, PDO::PARAM_STR);
        $managerReq->execute();
        $manager = $managerReq->fetch(PDO::FETCH_ASSOC);
        if(isset($manager['email']) && password_verify($password, $manager['password'])){
            $_SESSION['connect'] = 'pro';
            $_SESSION['role'] = 'manager';
            $_SESSION['user'] = $manager['firstname'];
            $_SESSION['proId'] = $manager['id'];
            header('location:./managerDashboard.php');
            exit();
        } else {
            //SINON ERREUR
            header('location:./loginPro.php?error=invalid');
            exit();
        }
    }
}