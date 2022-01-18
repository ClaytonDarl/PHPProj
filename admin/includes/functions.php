<?php
    //autoloads the required files
    function classAutoLoader($class) {
        $class = strtolower($class);

        $path = "includes/{$class}.php";

        if(file_exists($path)) {
            require_once($path);
        } else {
            die("Missing file!: {$class}.php");
        }
    }

    function redirect($link){
        header("Location: {$link}");
        exit();
    }

    spl_autoload_register("classAutoLoader");
?>