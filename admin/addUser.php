<?php include("includes/header.php"); ?>
<?php if(!$session->isSignedIn()) {redirect("login.php");}?>

<?php
    $aMessage;

    $user = new User();
    if(isset($_POST['create'])){
        if($user) {
            $user->username = $_POST['username'];
            if (!$_POST['password'] == "") {
                $user->password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            }
            $user->firstName = $_POST['firstName'];
            $user->lastName = $_POST['lastName'];
            $user->permission = $_POST['permission'];
            $user->userImage = "";

            if (!User::checkUsername($_POST['username'])) {
                $user->save();
                redirect("users.php");
            } else {
                $aMessage = "A user with that username already exists!";
            }

        }
    }
?>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <!-- Top nav relocated-->
    <?php include("includes/topNav.php")?>

    <!-- Side nav relocated-->
    <?php include("includes/sideNav.php")?>
        <div id="page-wrapper">
        <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Photo
                            <small>Subheading</small>
                        </h1>
                    <h4 class="bg-danger"><?php echo $aMessage; ?></h4>
                    <form action="" method="post">
                        <div class="col-md-8">
                        <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" name="username" class="form-control" value="<?php echo $user->username?>">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" name="password" class="form-control" value="">
                            </div>
                            <div class="form-group">
                                <label for="caption">First Name</label>
                                <input type="text" name="firstName" class="form-control" value="<?php echo $user->firstName?>">
                            </div>
                            <div class="form-group">
                                <label for="caption">Last Name</label>
                                <input type="text" name="lastName" class="form-control" value="<?php echo $user->lastName?>">
                            </div>
                            <div class="form-group">
                                <label for="permission">Permission</label> <br>
                                <label for="admin">Admin</label>
                                <input type="radio" name="permission" value="1">
                                <label for="standard">Standard</label>
                                <input type="radio" name="permission" value="0" checked>
                            </div>
                            <input type="submit" name="create" value="Create" class="btn btn-primary btn-lg ">

                        </div>
                    </form>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

  <?php include("includes/footer.php"); ?>