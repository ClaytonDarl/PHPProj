<?php include("includes/header.php"); ?>
<?php if(!$session->isSignedIn()) {redirect("login.php");}?>

<?php
    $username = $_GET['username'];
    echo "USERNAME".$username;
$message = "";
    if(isset($_POST['submit'])) {
        $photo = new Photo();
        $photo->title = $_POST['title'];
        $photo->description = $_POST['description'];
        $photo->altText = $_POST['altText'];
        $photo->caption = $_POST['caption'];
        $photo->author = $_POST['author'];
        $photo->setFile($_FILES['fileUpload']);
        $photo->likes = 0;
        $photo->creationDate = date("Y-m-d");
        $photo->private = 0;
        if($photo->saveFile()) {
            $message =  "File uploaded successfully!";
        } else {

        }
    }

?>
        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <!-- Top nav relocated-->
    <?php include("includes/topNav.php")?>

    <!-- Side nav relocated-->
    <?php
        //if ($session->checkPermission()) {
            include("includes/sideNav.php");
        //}
    ?>

        <div id="page-wrapper">
        <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Upload
                            <small>Subheading</small>
                        </h1>
                        <!--Upload photo form -->
                        <?php echo $message ?>
                        <form action="upload.php" method="post" enctype="multipart/form-data">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input type="text" name="title" value="title" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="author">Author</label>
                                <input name='author' type="text" class="form-control" value="<?php echo $username;?>">
                            </div>
                            <div class="form-group">
                                <label for="caption">Caption</label>
                                <input type="text" name="caption" class="form-control" value="<?php echo $photo->caption?>">
                            </div>
                            <div class="form-group">
                                <label for="caption">Alt Text</label>
                                <input type="text" name="altText" class="form-control" value="<?php echo $photo->altText?>">
                            </div>
                            <div class="form-group">
                                <label for="desc">Description</label>
                                <textarea id="desc" class="form-control" name="description" id="" cols="30" rows="10"><?php echo $photo->description?></textarea>
                            </div>
                            <div class="form-group">
                                <input type="file" name="fileUpload">
                            </div>
                            <input class="btn btn-primary btn-lg " type="submit" name="submit">
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