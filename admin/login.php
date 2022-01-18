<?php require_once("includes/header.php")?>

<?php
    //if a login form has been submitted do stuff with it
    if(isset($_POST['submit'])) {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        //verify the user exists in the database
        $userFound = User::verifyUser($username, $password);
        echo var_dump($userFound);

        if($userFound) {
            $session->login($userFound);

            //check the permission for redirection
            if ($session->checkPermission()) {
                redirect("index.php");
            } else {
                redirect("../index.php");
            }
            echo var_dump($session);
        } else {
            $aMessage = "Username or password is incorrect!";
            //redirect("login.php");
        }
    } else {

        $aMessage = "";
        $username = "";
        $password = "";
    }
?>

<div class="col-md-4 col-md-offset-3">

<h4 class="bg-danger"><?php echo $aMessage; ?></h4>

<form id="login-id" action="" method="post">

<div class="form-group">
	<label for="username">Username</label>
	<input type="text" class="form-control" name="username" value="<?php echo htmlentities($username); ?>" >

</div>

<div class="form-group">
	<label for="password">Password</label>
	<input type="password" class="form-control" name="password" value="<?php echo htmlentities($password); ?>">
</div>

<a href="createUser.php" class="btn btn-primary">Create a New User</a>

<div class="form-group">
<input type="submit" name="submit" value="Login" class="btn btn-primary">

</div>


</form>


</div>