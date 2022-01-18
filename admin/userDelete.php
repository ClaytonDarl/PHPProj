<?php include("includes/init.php")?>
<?php if(!$session->isSignedIn()) {redirect("login.php");}?>
<?php
    if(empty($_GET['id'])) {
        redirect("users.php");
    }
    $user = User::findbyId($_GET['id']);

    if($user) {
        $user->deleteUser();
        $session->logout();
        redirect("login.php");
    } else {
        redirect("users.php");
    }
?>