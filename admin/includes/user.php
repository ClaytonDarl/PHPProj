<?php

class User extends DbObject{
    protected static $db_table = 'users';
    protected static $db_table_fields = ['username', 'password', 'firstName', 'lastName', 'userImage', 'permission'];

    public $id;
    public $username;
    public $password;
    public $firstName;
    public $lastName;
    public $userImage;
    public $permission;
    public $uploadDirectory = "images";
    public $imagePlaceholder = "https://via.placeholder.com/64";

    public function imagePathandPlaceholder() {
        return empty($this->userImage) ? $this->imagePlaceholder : $this->uploadDirectory.DS.$this->userImage;
    }
    /**
     * Verifies if a user exists in the database
     *
     * @param [string] $username
     * @param [string] $password
     * @return User if the a user has been found
     * @return false if no user fitting the query was found
     */
    public static function verifyUser($username, $password){
        global $database;
        $username = $database->escapeString($username);
        $password = $database->escapeString($password);
        //$password = password_hash($database->escapeString($password), PASSWORD_DEFAULT);
        //$query = "SELECT * FROM ". self::$db_table ." WHERE username='{$username}' AND password='{$password}' LIMIT 1";
        $query = "SELECT * FROM ". self::$db_table ." WHERE username='{$username}' LIMIT 1";

        //Query the database here
        $resultArray = self::findQuery($query);

        //If we find a user, verify the password
        if (!empty($resultArray)) {
            return password_verify($password, $resultArray[0]->password) ? array_shift($resultArray) : false;
        } else {
            return false;
        }

        //if we get a result, verify the password.
        //return !empty($resultArray) ? array_shift($resultArray) : false;

        //if not empty, return the 1st element in the result, else return false
        //return !empty($resultArray) ? array_shift($resultArray) : false;
    }

    public static function checkUsername($username) {
        global $database;
        $username = $database->escapeString($username);
        $query = "SELECT * FROM ". self::$db_table ." WHERE username='{$username}'";

        $result = self::findQuery($query);
        return !empty($result) ? array_shift($result) : false;


    }

    public function deleteUser() {
        if($this->delete()) {
            return true;
        } else {
            return false;
        }
    }

    //check if the user is an admin
    public function checkAdmin() {
        return $this->permission ? true : false;
    }
}

//End user Class

?>