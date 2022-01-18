<?php include("includes/header.php"); ?>
<?php if(!$session->isSignedIn()) {redirect("login.php");}?>
<?php if(!$_SESSION['admin']) {
        redirect("editUser.php?id={$session->userId}");
    }?>
<?php
    $photos = Photo::findAll();

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
                        <div class="md-12">

                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Photo</th>
                                        <th>Id</th>
                                        <th>File Name</th>
                                        <th>Title</th>
                                        <th>Size</th>
                                        <th>Comments</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($photos as $photo) : ?>
                                    <tr>
                                        <td><a href="../picture.php?id= <?php echo $photo->id ?>"><img class="photoThumbnail" src="<?php echo $photo->picturePath(); ?>" alt=""></a>
                                            <div class="picturesLink">
                                                <a href="deletePhoto.php?id=<?php echo $photo->id ?>">Delete</a>
                                                <a href="editPhoto.php?id=<?php echo $photo->id ?>">Edit</a>
                                                <a href="../picture.php?id=<?php echo $photo->id ?>">View</a>
                                            </div>
                                        </td>
                                        <td><?php echo $photo->id;?></td>
                                        <td><?php echo $photo->fileName;?></td>
                                        <td><?php echo $photo->title;?></td>
                                        <td><?php echo $photo->size;?></td>
                                        <td><?php
                                            $comments = Comment::findComments($photo->id);
                                            echo count($comments);

                                        ?></td>
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