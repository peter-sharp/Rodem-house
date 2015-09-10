<?php
class mysqlConnectorException extends Exception { };

class MysqlConnector {
  protected $mysqli;
  private $server;
  private $username;
  private $password;
  private $database;
  function __construct($server = null, $username = null, $password = null, $database = null){
    $params = $this.getConfig('mysql_config.json');
    $this->server   = $server ?: $params['server'];
    $this->username = $username ?: $params['username'];
    $this->password = $password ?: $params['password'];
    $this->database = $database ?: $params['database'];
    $this.connect();
  }
  private function getConfig ($file) {
    $fileStr = file_get_contents($file);
    $json = json_decode($fileStr);
    return $json;
  }

  /**
    * Select the database and connect to it using given parameters
    * If it is unable to connect it throws an error message.
    */
  private function connect (){
    try {
      $mysqli = new mysqli($this->server, $this->username, $this->password);

      $this->mysqli = $mysqli;
    }
    catch (Exception $error) {
      throw new mysqlConnectorException ('Mysqli connection error: ' . $error->getMessage() );
    }
  }

  /**
    * selects a database with a given database name or the current if none given
    * @param string $database name of database to select.
    */
  protected function selectDatabase ($database = null) {
    try {
      // TODO see if $this-> database can be a default value, then this line won't be necessary
      $this->database = (isset($database)) ? $database: $this->database;
      $this->mysqli->select_db($this->database);
    }
    catch (Exception $error) {
      throw new mysqlConnectorException ('Mysqli database selection error: ' . $error->getMessage() );
    }
  }

  /**
    * returns the name of the current selected database
    */
  protected function getDatabaseName () {
    return $this->database;
  }
}
