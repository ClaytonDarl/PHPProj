<?php include("includes/header.php"); ?>

<?php if(!$session->isSignedIn()) {redirect("login.php");}?>
<?php
//I do not like this, but the way the app is structured hides session from a regular user
    echo $_SESSION['admin'];
    if(!$_SESSION['admin']) {
        redirect("editUser.php?id={$session->userId}");
    }


?>

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <!-- Top nav relocated-->
    <?php include("includes/topNav.php")?>

    <!-- Side nav relocated-->
    <?php include("includes/sideNav.php")?>
        <div id="page-wrapper">
            <?php include("includes/adminContent.php")?>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

  <?php include("includes/footer.php"); ?>