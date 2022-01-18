<?php require_once("includes/header.php")?>

<?php
//log the user out and redirect to login page
    $session->logout();
    redirect("login.php");
?>