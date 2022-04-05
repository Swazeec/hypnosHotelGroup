<?php
require('./aws/aws-autoloader.php');
use Aws\S3\S3Client;
// si getenv('JAWSDB_URL') est true, c'est que c'est la version en ligne, sinon, version locale
if(getenv('JAWSDB_URL') !== false){
    if (!empty(getenv('S3_BUCKET'))) {
        $bucket = getenv('S3_BUCKET');
    } else {
        header('location:./managerDashboard.php?error=bucket');
        exit();
    }
} else {
    $bucket = 'hypnoshotelgroup';
}
    
$s3 = new S3Client([
        'region' => 'eu-west-3',
        'version' => '2006-03-01'
    ]);

// SUPPRESSION PHOTO
if(!empty($_GET['deleteGaleriePict'])){
    $suiteID = htmlspecialchars($_GET['suite']);
    $suiteID = intval($suiteID);
    $galeriePictId = htmlspecialchars($_GET['deleteGaleriePict']);
    $galeriePictId = intval($galeriePictId);
    if($galeriePictId && $galeriePictId > 0 && $suiteID && $suiteID > 0){
        $galeriePictReq = $bdd->prepare('SELECT * FROM pictures WHERE id = :id ;');
        $galeriePictReq->bindValue(':id', $galeriePictId, PDO::PARAM_INT);
        $galeriePictReq->execute();
        $count = $galeriePictReq->rowCount();
        if($count !== 0){
            // on supprime
            $deleteSuite = $bdd->prepare('DELETE FROM pictures WHERE id = :id;');
            $deleteSuite->bindValue(':id', $galeriePictId, PDO::PARAM_INT);
            $deleteSuite->execute();
            header("location:./modifySuite.php?suite=$suiteID&success=deleteSuite");
        } else {
            header("location:./modifySuite.php?suite=$suiteID&error=deleteSuite");
        }
    } else {
        header("location:./modifySuite.php?suite=$suiteID&error=deleteSuite");
    }
}

// MAJ SUITE EN BDD
if(!empty($_POST['suiteName']) &&
    !empty($_POST['price']) &&
    !empty($_POST['description']) &&
    !empty($_POST['bookingLink']) 
){
    require_once('./components/functions.php');

    // VARIABLES
    $suiteName = htmlspecialchars($_POST['suiteName']);
    $price = htmlspecialchars($_POST['price']);
    $description = htmlspecialchars($_POST['description']);
    $bookingLink = htmlspecialchars($_POST['bookingLink']);
    

    if(checkName($suiteName) === false ||
    intval($price) <= 0 ||
    strlen($description) > 2000 ||
    checkURL($bookingLink) === false /* ||
    checkPicture($primePicture) === false */
    ){
        header("location:./modifySuite.php?suite=$suiteID&error=invalidInfos");
    } else {
        // on modifie nom / prix / description / url
        $suiteUpdate = $bdd->prepare('UPDATE suites 
                                    SET title = :title, description = :desc, link = :link, price_id = :pid
                                    WHERE id = :id');
        $suiteUpdate->bindValue(':title', $suiteName, PDO::PARAM_STR);
        $suiteUpdate->bindValue(':desc', $description, PDO::PARAM_STR);
        $suiteUpdate->bindValue(':link', $bookingLink, PDO::PARAM_STR);
        $suiteUpdate->bindValue(':pid', $price, PDO::PARAM_INT);
        $suiteUpdate->bindValue(':id', $suiteId, PDO::PARAM_INT);
        $suiteUpdate->execute();

        if(!empty($_FILES['primePicture'])){
    
            $primePicture = $_FILES['primePicture'];
    
            if(checkPicture($primePicture) === false){
                header("location:./modifySuite.php?suite=$suiteID&error=invalidPicture");
            } else {
                // si changement de primePicture, on ajoute à S3 et on change en bdd
                try{
                    $suitePP = $s3->putObject(array(
                        'Bucket' => $bucket,
                        'Key'    => 'hypnosHotelGroup_'.time() . '_' . $_FILES['primePicture']['name'],
                        'SourceFile' => $_FILES['primePicture']['tmp_name']
                    ));
                } catch (Aws\S3\Exception\S3Exception $e){
                    header("location:./modifySuite.php?suite=$suiteID&error=picture");
                    exit();
                }
    
                $primePictureURL = $suitePP['ObjectURL']; 
    
                $suiteUpdate = $bdd->prepare('UPDATE suites 
                                        SET primePicture = :pp
                                        WHERE id = :id');
                $suiteUpdate->bindValue(':pp', $primePictureURL, PDO::PARAM_STR);
                $suiteUpdate->bindValue(':id', $suiteId, PDO::PARAM_INT);
                $suiteUpdate->execute();
            }    
        } 

        // si ajout de photo dans la galerie, ajout à s3 puis en bdd
            
        if(isset($_FILES['galeriePictures'])){

            // VERIFIER LES IMAGES
            $galeriePictures = $_FILES['galeriePictures'];

            if(checkPictures($galeriePictures) === false){
                header("location:./modifySuite.php?suite=$suiteID&error=invalidPicture");
            } else {
                for($i=0 ; $i < count($galeriePictures['name']) ; $i++){
                    try{
                        $GP = $s3->putObject(array(
                            'Bucket' => $bucket,
                            'Key'    => 'hypnosHotelGroup_'.time() . '_' . $_FILES['galeriePictures']['name'][$i],
                            'SourceFile' => $_FILES['galeriePictures']['tmp_name'][$i]
                        ));
                    } catch (Aws\S3\Exception\S3Exception $e){
                        header("location:./modifySuite.php?suite=$suiteID&error=picture");
                        exit();
                    }
                    
                    $pictureURL = $GP['ObjectURL']; 
                    
                    // AJOUTER EN BDD
                    $addPictReq = $bdd->prepare('INSERT INTO pictures (picture, suite_id) VALUES (:url, :sid);');
                    $addPictReq->bindValue(':url', $pictureURL, PDO::PARAM_STR);
                    $addPictReq->bindValue(':sid', $suiteId, PDO::PARAM_INT);
                    $addPictReq->execute();
                    
                } 
            }
        }
        header('location:./managerDashboard.php?success=modifySuite');
    }
}