<?php
class mysqliConnectorException extends Exception { };

class MysqliConnector {
  private $mysqli;
  private $_server;
  private $_username;
  private $_password;
  private $_database;
  static private $_instance;

  static public function getInstance ( $config = 'mysql_config.json' ) {
    if(!self::$_instance) {
      self::$_instance = new self('mysql_config.json');
    }
    return self::$_instance;
  }

  /**
    * constructor function is protected to prevent an instance being created by clling the new
    * keyword on this class.
    */
  protected function __construct ($config) {
    $params = $this->getConfig ( $config );
    $this->_server   =  $params['server'];
    $this->_username =  $params['username'];
    $this->_password =  $params['password'];
    $this->_database =  $params['database'];
    $this->connect();
    $this->selectDatabase();
  }
  /**
    * returns the current mysqli connection
    */
  public function getConnection ( ) {
    return $this->mysqli;
  }

  /**
    * reads a given json file and returns it as a multi-dimensional array
    * @param string $file Location of the config file
    * @TODO add checks to make sure given JSON file is correct
    */
  private function getConfig ($file) {
    $fileStr = file_get_contents($file);
    $json = json_decode($fileStr, true);
    return $json;
  }

  /**
    * Select the database and connect to it using given parameters
    * If it is unable to connect it throws an error message.
    */
  private function connect (){
    try {
      $mysqli = new mysqli($this->_server, $this->_username, $this->_password);

      $this->mysqli = $mysqli;
    }
    catch (Exception $error) {
      throw new mysqliConnectorException ('Mysqli connection error: ' . $error->getMessage() );
    }
  }

  /**
    * selects a database with a given database name or the current if none given
    * @param string $database name of database to select.
    */
  protected function selectDatabase ($database = null) {
    try {
      // TODO see if $this-> database can be a default value, then this line won't be necessary
      $this->_database = (isset($database)) ? $database: $this->_database;
      $this->mysqli->select_db($this->_database);
    }
    catch (Exception $error) {
      throw new mysqliConnectorException ('Mysqli database selection error: ' . $error->getMessage() );
    }
  }

  /**
    * returns the name of the current selected database
    */
  protected function getDatabaseName () {
    return $this->_database;
  }
}
