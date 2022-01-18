<?php include("includes/init.php")?>
<?php if(!$session->isSignedIn()) {redirect("login.php");}?>
<?php
    if(empty($_GET['id'])) {
        redirect("photos.php");
    }
    $photo = Photo::findbyId($_GET['id']);

    if($photo) {
        $photo->deletePhoto();
        redirect("photos.php");
    } else {
        redirect("photos.php");
    }
?>