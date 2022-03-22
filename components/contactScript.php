<?php
if(!empty($_POST['firstname']) &&
    !empty($_POST['lastname']) &&
    !empty($_POST['email']) &&
    !empty($_POST['topic']) &&
    !empty($_POST['message']) 
){
    require_once('./components/functions.php');
    // VARIABLES
    $firstname = htmlspecialchars($_POST['firstname']);
    $lastname = htmlspecialchars($_POST['lastname']);
    $email = htmlspecialchars($_POST['email']);
    $topic = intval(htmlspecialchars($_POST['topic']));
    $message = htmlspecialchars($_POST['message']);

    if(checkName($firstname) === false ||
        checkName($lastname) === false ||
        checkEmail($email) === false ||
        $topic === 0 ){
            header('location:./contact.php?error=invalid');
    } else {
        // CHECK TOPIC EXISTE
        $topicReq = $bdd->prepare('SELECT * FROM topics WHERE id = :id;');
        $topicReq->bindValue(':id', $topic, PDO::PARAM_INT);
        $topicReq->execute();
        $topicCount = $topicReq->rowCount();
        if($topicCount === 0){
            header('location:./contact.php?error=invalid');
        } else {
            if (!empty($_SESSION['userId'])) {
            // SI CLIENT
            $clientId = $_SESSION['userId'];
            $newMessage = $bdd->prepare('INSERT INTO contactRequests (firstname, lastname, email, message, topic_id, client_id) 
                                        VALUES (:fn, :ln, :email, :message, :topicId, :clientId);');
            $newMessage->bindValue(':clientId', $clientId, PDO::PARAM_INT);
        } else {
            $newMessage = $bdd->prepare('INSERT INTO contactRequests (firstname, lastname, email, message, topic_id) 
                                        VALUES (:fn, :ln, :email, :message, :topicId);');
            }
            $newMessage->bindValue(':fn', $firstname, PDO::PARAM_STR);
            $newMessage->bindValue(':ln', $lastname, PDO::PARAM_STR);
            $newMessage->bindValue(':email', $email, PDO::PARAM_STR);
            $newMessage->bindValue(':message', $message, PDO::PARAM_STR);
            $newMessage->bindValue(':topicId', $topic, PDO::PARAM_INT);
            $newMessage->execute();
            header('location:./contact.php?message=success');
        }

    }
}