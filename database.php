<?php
#TODO require_once('authenticator.php');
#TODO require_once('logger.php');

class databaseException extends Exception { };
/**
  * helper class containing various database methods
  */

class DatabaseHelper {
  private $mysqli;

  /**
    * constructor method that initialises the database connection
    */
  function DatabaseHelper($server = null, $username = null, $password = null, $database = null){
    $server   = ();
    $username = ();
    $password = ();
    $database = ();
    //open connection to the database:
    try {
      $this->mysqli = $this->connect();
    }
    catch (Exception $error) {
      throw new DatabaseException('DatabaseHelper mysqli connection error: ' . $error->getMessage() );)
    }
  }

  /**
     * Select the database and connect to it using given parameters
     * If it is unable to connect it dies with an error message.
     * @param string $server the server the database belongs to
     * @param string $username the username for the database
     * @param string $password the password for the database
     * @param string $database the database to connect to
     * @return resource $mysql Successfully connected Mysql database resource.
     */
  private function connect($server, $username, $password, $database) {
    //connect and select database
    $mysqli = new mysqli($server, $username, $password, $database);

    $mysqli->select_db($database);

    return $mysqli;
  }
}
?>
