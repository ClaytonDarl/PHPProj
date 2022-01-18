<?php

class DbObject {

    /**
     * Generalized function for sending user queries,
     *
     * @param [string] The sql query to be sent
     * @return Array An array of users found by the query
     */
    public static function findQuery($query) {
        global $database;
        $result = $database->queryDB($query);
        $objects = [];

        while ($row = mysqli_fetch_array($result)) {
            $objects[] = static::instantiate($row);
        }
        return $objects;
    }

    /**
     * Create a new user
     *
     * @param [array] $foundObject
     * @return object
     */
    public static function instantiate($foundObject) {
        //gets the class that calls this function
        $calledClass = get_called_class();
        $object = new $calledClass;

        foreach ($foundObject as $key => $value) {
            if ($object->hasAttribute($key)) {
                $object->$key = $value;
            }
        }

        return $object;
    }

    /**
     * Check if the attribute exists in the User class
     *
     * @param [type] $attribute
     * @return boolean -> True if the object contains the attribute, false if not
     */
    private function hasAttribute($attribute) {
        return property_exists(get_called_class(), $attribute);
    }

    /**
     * Find all users
     *
     * @return array An array of all the users in the database
     */
    public static function findAll() {
        $queryResult = static::findQuery("SELECT * FROM ". static::$db_table . " ");
        return $queryResult;
    }

    /**
     * Find a user based on the id number
     *
     * @param [Integer] $id
     * @return object The user found that corresponds to the id
     * @return false if no user if found
     */
    public static function findById($id) {
        $resultArray = static::findQuery("SELECT * FROM ".  static::$db_table ." WHERE id={$id}");

        //if not empty, return the 1st element in the result, else return false
        return !empty($resultArray) ? array_shift($resultArray) : false;
    }

    /**
     * Get all the properties associated with the class
     *
     * @return array
     */
    protected function getProperties(){
        $properties = [];

        //for every property check if this class has the property
        foreach(static::$db_table_fields as $dbField) {
            if (property_exists($this, $dbField)) {
                $properties[$dbField] = $this->$dbField;
            }
        }
        return $properties;
    }

    /**
     * Escape special characters in the properties that could be present.
     *
     * @return array properties
     */
    protected function cleanProperties() {
        global $database;

        $cleanProperties = [];
        foreach ($this->getProperties() as $key => $value) {
            $cleanProperties[$key] = $database->escapeString($value);

        }
        return $cleanProperties;
    }

    /**
     * Checks if the user exists, if it does updates the user, if not creates one
     *
     * @return boolean
     */
    public function save() {
        return isset($this->id) ? $this->update() : $this->create();
    }

    /**
     * Create a new user in the database
     *
     * @return boolean
     */
    public function create() {
        global $database;

        $properties = $this->cleanProperties();

        $query = "INSERT INTO ". static::$db_table ."(" .  implode(",", array_keys($properties)) .")";
        $query .= "VALUES ('".  implode("','", array_values($properties)) ."')";
        //echo "<h1> {$query} </h1>";
        //will return true or false
        if ($database->queryDB($query)) {
            $this->id = $database->lastInsertId();
            return true;
        } else {
            return false;
        }

    }

    /**
     * Update a user's info in the database
     *
     * @return boolean
     */
    public function update() {
        global $database;
        $properties = $this->cleanProperties();

        $propertyPairs = [];

        foreach ($properties as $key => $value) {
            $propertyPairs[] = "{$key}='{$value}'";
        }

        $query = "UPDATE ". static::$db_table ." SET ";
        $query .= implode(", ", $propertyPairs);
        $query .= "WHERE id= " . $database->escapeString($this->id);

        $database->queryDB($query);
        return (mysqli_affected_rows($database->connection) == 1) ? true : false;

    }

    /**
     * Delet a user from the database, deletes by id
     *
     * @return boolean
     */
    public function delete() {
        global $database;
        $query = "DELETE FROM ".  static::$db_table ." WHERE id= '" . $database->escapeString($this->id) . "'";
        $database->queryDB($query);
        return (mysqli_affected_rows($database->connection) == 1) ? true : false;
    }

    public static function count(){
        global $database;
        $query = "SELECT COUNT(*) FROM ". static::$db_table;

        $result = $database->queryDB($query);

        return array_shift(mysqli_fetch_array($result));
    }
}

?>