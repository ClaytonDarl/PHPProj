<?php include("includes/header.php"); ?>
<?php if(!$session->isSignedIn()) {redirect("login.php");}?>
<?php if(!$_SESSION['admin']) {
        redirect("editUser.php?id={$session->userId}");
    } ?>
<?php
    $aMessage;
    if(empty($_GET['id'])) {
        //redirect("index.php");
    } else {
        $user = User::findById($_GET['id']);
    }
    if(isset($_POST['update'])){
        if($user) {
            $user->username = $_POST['username'];
            if (!$_POST['password'] == "") {
                $user->password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            }
            $user->firstName = $_POST['firstName'];
            $user->lastName = $_POST['lastName'];
            if ($_POST['permission']) {
                $user->permission = $_POST['permission'];
                $_SESSION['admin'] = true;
                echo "WOWOWOWOWO";
            } else {
                $user->permission = $_POST['permission'];
                $_SESSION['admin'] = false;
            }

            $user->userImage = "";

            //if (!User::checkUsername($_POST['username'])) {
                $user->save();
            //} else {
            //    $aMessage = "A user with that username already exists!";
            //}

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
                            Edit User Info
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
                            <?php
                                if($session->checkPermission()) {
                                   $temp = "<div class='form-group'>";
                                   $temp .= "<label for='permission'>Permission</label> <br>";
                                   $temp .= "<label for='admin'>Admin</label>";
                                   $temp .= "<input type='radio' name='permission' value='1'>";
                                   $temp .= "<label for='standard'>Standard</label>";
                                   $temp .= "<input type='radio' name='permission' value='0' checked>";
                                   $temp .= "</div>";
                                   echo $temp;
                                }
                            ?>

                            <input type="submit" name="update" value="update" class="btn btn-primary btn-lg ">
                            <a  href="userDelete.php?id=<?php echo $user->id; ?>" class="btn btn-danger btn-lg ">Delete</a>

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