<?php include("includes/header.php"); ?>
<?php
    $author = $_GET['author'];
    $query = "SELECT * FROM photos WHERE author='$author'";
    $photos = Photo::findQuery($query);
    if ($session->isSignedIn()) {
        $user = User::findById($session->userId);
        $username = $user->username;
    }

?>



        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-12">
            <a href="admin/upload.php?username=<?php echo $username; ?>" class="btn btn-primary">Add Photo</a>


            <div class="form-group" name="sorter">
            <label for="sorter">Sort by:</label>
            <form action="index.php?sort=creationDate" method='get'>
                <input type="submit" name="sort" value="creationDate">
            </form>
            <form action="http://localhost/~claytondarlington/photo/index.php?sort=author">
                <input type="submit" name="sort" value="author">
            </form>
            <form action="index.php?sort=likes">
                <input type="submit" name="likes "value="likes">
            </form>
            </div>

            <div class="thumbnails row" id="photoArea">
                <?php foreach($photos as $photo): ?>
                        <div class="col-xs-6 col-md-3" id="display">
                            <a href="picture.php?id=<?php echo $photo->id; ?>" class="thumbnail">
                                <img class="galleryPhoto" src="admin/<?php echo $photo->picturePath(); ?>" alt="">
                            </a>
                        </div>
                <?php endforeach ?>
            </div>
            </div>
                </div>



            <!-- Blog Sidebar Widgets Column -->
            <div class="col-md-4">


        </div>
        <!-- /.row -->
        <?php include("includes/footer.php"); ?>