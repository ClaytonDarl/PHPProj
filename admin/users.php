<?php include("includes/header.php"); ?>
<?php if(!$session->isSignedIn() ) {redirect("login.php");} //edit this to display a message that the user does not have permission?>
<?php
    if(!$_SESSION['admin']) {
        redirect("editUser.php?id={$session->userId}");
    }
?>
<?php
    $users = User::findAll();
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
                            Users
                        </h1>
                        <a href="addUser.php" class="btn btn-primary">Add User</a>
                        <div class="md-12">

                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Photo</th>
                                        <th>Username</th>
                                        <th>First Name</th>
                                        <th>Last Name</th>
                                        <th>Type</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($users as $user) : ?>
                                    <tr>
                                        <td><?php echo $user->id?></td>

                                        <td> <img class="userImage" src="<?php echo $user->imagePathandPlaceholder(); ?> " alt="">
                                        </td>

                                        <td><?php echo $user->username?>
                                        <div class="picturesLink">
                                                <a href="userDelete.php?id=<?php echo $user->id ?>">Delete</a>
                                                <a href="editUser.php?id=<?php echo $user->id ?>">Edit</a>
                                                <a href="#">View</a>
                                        </div></td>
                                        <td><?php echo $user->firstName?></td>
                                        <td><?php echo $user->lastName?></td>
                                        <td>
                                        <?php
                                        if ($user->permission == 0){
                                            echo "Standard";
                                        } else {
                                            echo "Admin";
                                        };
                                        ?>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <!--END TABLE-->
                        </div>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

  <?php include("includes/footer.php"); ?>