<?php include("includes/header.php"); ?>
<?php include("admin/includes/init.php")?>
<?php

//if(!$session->isSignedIn()) {redirect("login.php");}
    if(empty($_GET['id'])) {
        redirect("index.php");
    }
    $photo = Photo::findById($_GET['id']);
    if ($session->isSignedIn()){
        $user = User::findById($session->userId);
    }
    if(isset($_POST['like'])) {
        $photo->likes++;
        $photo->save();
        @header("Refresh:0");
    }

    echo $user->permission;


    if(isset($_POST['submit'])) {

        $author = trim($_POST['author']);
        $content = trim($_POST['content']);

        $comment = Comment::createComment($photo->id,$author, $content);

        if($comment && $comment->save()) {
            @header("Refresh:0");
        } else {
            $message = "There was an issue saving the comment!";
            $author = "";
            $content = "";
        }
    }

    $photoComments = Comment::findComments($photo->id);

?>
<div class="row">
        <div class="col-lg-8">

                <!-- Blog Post -->
                <?php
                    if($photo->author == $user->username) {
                        echo "<a href='admin/editPhoto.php?id={$photo->id}'>Edit Blog</a>";
                        echo "<a href='admin/deletePhoto.php?id={$photo->id}'>Delete Blog</a>";
                    }
                ?>

                <!-- Title -->
                <h1><?php echo $photo->title; ?></h1>

                <!-- Author -->
                <p class="lead">
                    by <a href="#"><?php echo $photo->author; ?></a>
                </p>

                <hr>

                <!-- Date/Time -->
                <p><span class="glyphicon glyphicon-time"></span> <?php echo $photo->creationDate;?></p>
                <form action="" method="POST">
                <label for="">Like this post</label>
                    <input type="submit" name="like" value="like">
                </form><p id="likes"><?php echo $photo->likes; ?></p>


                </script>
                <hr>

                <!-- Preview Image -->
                <img class="img-responsive" src="admin/<?php echo $photo->picturePath();?>" alt="">

                <hr>

                <!-- Post Content -->
                <p class="lead"> <?php echo $photo->caption;?></p>
                <p><?php echo $photo->description; ?></p>

                <hr>

                <!-- Blog Comments -->

                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form role="form" method="post">
                        <div class="form-group">
                            <label for="author">Author</label>
                            <input type="text" name="author" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="content">Comment</label>
                            <textarea name="content" class="form-control" rows="3"></textarea>
                        </div>
                        <button type="submit" name='submit' class="btn btn-primary">Submit</button>
                    </form>
                </div>

                <hr>

                <!-- Posted Comments -->

                <?php foreach ($photoComments as $photoComment) : ?>
                    <div class="media">
                        <a href="#" class="pull-left">
                            <img src="https://via.placeholder.com/64" alt="" class="media-object">
                        </a>
                        <div class="media-body">
                            <h4 class="media-heading"><?php echo $photoComment->author ?></h4>
                        </div>
                        <?php echo $photoComment->body ?>
                    </div>

                <?php endforeach; ?>
            </div>
            <!-- Blog Sidebar Widgets Column -->
            <div class="col-md-4">
                 <?php include("includes/sidebar.php"); ?>
        </div>
        <!-- /.row -->
        <?php include("includes/footer.php"); ?>
