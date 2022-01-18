<?php
require_once("newConfig.php");

/**
 * Class to contain all database operations
 */
class Database {
    public $connection;

    //On database creation, connect to it
    function __construct() {
        $this->createDbConnection();
    }

    //create the database connection
    public function createDbConnection() {
        //connect to the database
        $this->connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        if($this->connection->connect_errno) {
            die("DB connection failed". $this->connection->connect_error);
        }
    }

    /**
     * Function to send a database query and return the result
     *
     * @param [string] $queryString
     * @return mysqli_result returns a mysqli_results object or true on success. returns false on failure
     */
    public function queryDB($queryString) {
        //send the query to the database
        $result = $this->connection->query($queryString);

        $this->confirmQuery($result);

        return $result;
    }

    /**
     * Checks to see if the query worked. IE it returned anything other than FALSE
     *
     * @param [mysqli_results] $result
     * @return void
     */
    private function confirmQuery($result) {
        if (!$result) {
            die("\nDB query failed!". $this->connection->error);
        }
    }

    /**
     * Escapes special characters. Returns the escaped string.
     *
     * @param [string] $string
     * @return [string]
     */
    public function escapeString($string) {
        return $this->connection->real_escape_string($string);
    }

    /**
     * Get the last inserted id value
     *
     * @return string last autoincrement id number
     */
    public function lastInsertId() {
        return mysqli_insert_id($this->connection);
    }

}

$database = new Database();
?>