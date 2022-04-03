<?php
// SUPPRESSION SUITE
if(!empty($_GET['deleteSuite'])){
    $suiteId = htmlspecialchars($_GET['deleteSuite']);
    $suiteId = intval($suiteId);
    if($suiteId && $suiteId > 0){
        $suiteReq = $bdd->prepare('SELECT * FROM suites WHERE id = :id ;');
        $suiteReq->bindValue(':id', $suiteId, PDO::PARAM_INT);
        $suiteReq->execute();
        $count = $suiteReq->rowCount();
        if($count !== 0){
            // on supprime
            $deleteSuite = $bdd->prepare('DELETE FROM suites WHERE id = :id;');
            $deleteSuite->bindValue(':id', $suiteId, PDO::PARAM_INT);
            $deleteSuite->execute();
            header('location:./managerDashboard.php?success=deleteSuite');
        } else {
            header('location:./managerDashboard.php?error=deleteSuite');
        }
    } else {
        header('location:./managerDashboard.php?error=deleteSuite');
    }
}