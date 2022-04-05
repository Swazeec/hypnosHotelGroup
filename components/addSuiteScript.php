<?php
require_once('./aws/aws-autoloader.php');

use Aws\S3\S3Client;

// si getenv('JAWSDB_URL') est true, c'est que c'est la version en ligne, sinon, version locale
if(getenv('JAWSDB_URL') !== false){
    if (getenv('S3_BUCKET') !== false) {
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

if(!empty($_POST['suiteName']) &&
    !empty($_POST['price']) &&
    !empty($_POST['description']) &&
    !empty($_POST['bookingLink']) &&
    !empty($_FILES['primePicture'])
){
    require_once('./components/functions.php');

    // VARIABLES
    $suiteName = htmlspecialchars($_POST['suiteName']);
    $price = htmlspecialchars($_POST['price']);
    $description = htmlspecialchars($_POST['description']);
    $bookingLink = htmlspecialchars($_POST['bookingLink']);
    $primePicture = $_FILES['primePicture'];

    if(checkName($suiteName) === false ||
    intval($price) <= 0 ||
    strlen($description) > 2000 ||
    checkURL($bookingLink) === false ||
    checkPicture($primePicture) === false
    ){
        header('location:./addSuite.php?error=addSuite');
    } else {
        // AJOUT IMAGE S3 + RECUP URL
        try{
            $suitePP = $s3->putObject(array(
                'Bucket' => $bucket,
                'Key'    => 'hypnosHotelGroup_'.time() . '_' . $_FILES['primePicture']['name'],
                'SourceFile' => $_FILES['primePicture']['tmp_name']
            ));
        } catch (Aws\S3\Exception\S3Exception $e){
            header('location:./addSuite.php?error=picture');
            exit();
        }
        
        $primePictureURL = $suitePP['ObjectURL']; 

        // AJOUT SUITE BDD
    
        $addSuiteReq = $bdd->prepare('INSERT INTO suites (title, description, primePicture, link, price_id, hotel_id) 
                                    VALUES (:title, :desc, :primePict, :link, :pid, :hid);');
        $addSuiteReq->bindValue(':title', $suiteName, PDO::PARAM_STR);
        $addSuiteReq->bindValue(':desc', $description, PDO::PARAM_STR);        
        $addSuiteReq->bindValue(':primePict', $primePictureURL, PDO::PARAM_STR);
        $addSuiteReq->bindValue(':link', $bookingLink, PDO::PARAM_STR);
        $addSuiteReq->bindValue(':pid', $price, PDO::PARAM_INT);
        $addSuiteReq->bindValue(':hid', $hotelId, PDO::PARAM_INT);
        if($addSuiteReq->execute()){
            
            // SI IMAGES POUR GALERIE
            if(isset($_FILES['galeriePictures'])){
                // RECUPERER ID SUITE
                $suiteIdReq = $bdd->prepare('SELECT id FROM suites WHERE title = :title AND hotel_id = :hid ;');
                $suiteIdReq->bindValue(':title', $suiteName, PDO::PARAM_STR);
                $suiteIdReq->bindValue(':hid', $hotelId, PDO::PARAM_INT);
                $suiteIdReq->execute();
                $suiteId = $suiteIdReq->fetch(PDO::FETCH_ASSOC);
    
                // VERIFIER LES IMAGES
                $galeriePictures = $_FILES['galeriePictures'];

                if(checkPictures($galeriePictures) === true){
                    for($i=0 ; $i < count($galeriePictures['name']) ; $i++){
                        try{
                            $GP = $s3->putObject(array(
                                'Bucket' => $bucket,
                                'Key'    => 'hypnosHotelGroup_'.time() . '_' . $_FILES['galeriePictures']['name'][$i],
                                'SourceFile' => $_FILES['galeriePictures']['tmp_name'][$i]
                            ));
                        } catch (Aws\S3\Exception\S3Exception $e){
                            header('location:./addSuite.php?error=galeriePicture');
                            exit();
                        }
                        
                        $pictureURL = $GP['ObjectURL']; 
                        
                        // AJOUTER EN BDD
                        $addPictReq = $bdd->prepare('INSERT INTO pictures (picture, suite_id) VALUES (:url, :sid);');
                        $addPictReq->bindValue(':url', $pictureURL, PDO::PARAM_STR);
                        $addPictReq->bindValue(':sid', $suiteId['id'], PDO::PARAM_INT);
                        $addPictReq->execute();
                        
                        header('location:./managerDashboard.php?success=addSuite');
                    } 
                } else {
                    header('location:./addSuite.php?error=galeriePicture');
                }
            }
            header('location:./managerDashboard.php?success=addSuite');

        } else {
            header('location:./addSuite.php?error=addSuite');
        }

    
    }
}





