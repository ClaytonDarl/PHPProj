<?php include("includes/header.php"); ?>
<?php

    $page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
    $sort = !empty($_GET['sort']) ? $_GET['sort'] : 'author';
    $items = 20;
    $totalItems = Photo::count();
    $paginate = new Paginate($page, $items, $totalItems);
    $query = "SELECT * FROM photos WHERE private=0 ORDER BY " . $sort ." DESC LIMIT ". $items  . " OFFSET ". $paginate->offset();
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

            <div class="form-group">
                <form action="authorDisplay.php" method="GET">
                <label for="">Search for a specific author:</label>
                    <input type="text" name="author" id="author">
                    <input type="submit" name="submit" value="Search">
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
            <div class="row">
                <ul class="pagination">
                    <?php

                    if($paginate->pageTotal() > 1) {
                        if ($paginate->hasNext()) {
                            echo "<li class='next'><a href='index.php?page={$paginate->next()}'>Next</a></li>";
                        }

                        if ($paginate->hasPrev()) {
                            echo "<li class='prev'><a href='index.php?page={$paginate->prev()}'>Prev</a></li>";
                        }
                    }

                    for ($i=1; $i < $paginate->pageTotal(); $i++){
                        if ($i == $paginate->currPage) {
                            echo "<li class='active'><a href=''>{$i}</a></li>";
                        }
                    }
                    ?>



                </ul>
            </div>



            <!-- Blog Sidebar Widgets Column -->
            <div class="col-md-4">


        </div>
        <!-- /.row -->
        <script type="text/javascript">
            //var location = document.getElementById("photoArea");
            var photos = <?php echo json_encode($photos);?>;
            for (var i = 0; i < photos.length; i++){
                console.log(photos[i]);
                //document.write("<div class='col-xs-6 col-md-3' id='display'><a href='picture.php?id='" + photos[i]['id'] +"'class='thumbnail'><img class='galleryPhoto' src='' alt=''></a></div>");
            }
        </script>


        <?php include("includes/footer.php"); ?>
