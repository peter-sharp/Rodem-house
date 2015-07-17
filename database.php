<?php
#TODO require_once('authenticator.php');
#TODO require_once('logger.php');

class DatabaseException extends Exception { };
/**
  * helper class containing various database methods
  */

class DatabaseHelper {
  private $mysqli;

  public $server;
  public $username;
  public $password;
  public $database;

  /**
    * constructor method that initialises the database connection
    * @param string $server the server the database belongs to
    * @param string $username the username for the database
    * @param string $password the password for the database
    * @param string $database the database to connect to
    */
  function DatabaseHelper($server = null, $username = null, $password = null, $database = null){
    $this->server   = $server ?: "localhost";
    $this->username = $username ?: "root";
    $this->password = $password ?: "";
    $this->database = $database ?: "website";
    //open connection to the database:
    try {
      $this->mysqli = $this->connect();
    }
    catch (Exception $error) {
      throw new DatabaseException('DatabaseHelper mysqli connection error: ' . $error->getMessage() );
    }
  }

  /**
     * Select the database and connect to it using given parameters
     * If it is unable to connect it throws an error message.
     * @param string $server the server the database belongs to
     * @param string $username the username for the database
     * @param string $password the password for the database
     * @param string $database the database to connect to
     * @return resource $mysql Successfully connected Mysql database resource.
     */
  private function connect() {
    //connect and select database
    $mysqli = new mysqli($this->server, $this->username, $this->password, $this->database);

    $mysqli->select_db($this->database);

    return $mysqli;
  }

  /**
    * inserts a single row of data into a database based on params given and redirect
    * user on success/failure with message/error in URL parameter. Note: only accepts strings.
    *
    * @param string $table Name of table to insert new row into
    * @param array $formData Array of data to insert into new row of table
    *
    *
    */
  public function insert($table, $formData){
    $mysqli = $this->mysqli;
    if(!$this->array_isAssoc($formData))
        throw new DatabaseException("Form data needs to be an associative array! \n current:". print_r($formData, true));
    foreach( $formData as $key => $value){
      $values[] = $value;
      $slots[] = "?";
      $keys[] = $key;
    }


    $sql = "INSERT INTO `$table`(". implode(',', $keys) .") VALUES (". implode(',', $slots) .")";
    if(!$statement = $mysqli->prepare($sql)){
      throw new DatabaseException("Error prepearing statement:".$mysqli->error);
    }

    // since all inserted values are going to be strings @TODO in future should make this take more data types
    $types = implode('',$this->createTypesArray($values) );

    // function to insert the contents of an array as arguments to the bind_param function
    $bind_param_args = array_merge(array($types), $values);

    $query = call_user_func_array(array($statement, "bind_param"), $this->array_refValues($bind_param_args));
    $statement->execute();

    // generate header message
    if(!$query){ //throw a mysql error
      throw new DatabaseException( "Error in mysql exception: ".$mysqli->error($query));
      $message = "Error=Failed to add (".implode(',',$values).")";
    }
    else {
      $message = "message=Successfully added (".implode(',',$values).")";
    }
    return $message;
  }

  /**
    * returns an array of single character strings representing
    * the variable types in the list
    *
    * @param array $values an array of values to check
    *
    * @return array $types an array of variable type strings
    */
  private function createTypesArray($values){

    $types = array();
    foreach($values as $value){
      $type = gettype($value);
      switch($type){
        case 'integer':
          $types[] = 'i';
          break;
        case 'string':
          $types[] = 's';
          break;
        default:
          throw new DatabaseException("insert: could not insert $value because $type is not compatible with database");
      }
    }
    return $types;
  }

  /**
    * checks whether a given array is associative or indexed
    */
  private function array_isAssoc(array $array) {
    return (bool)count(array_filter(array_keys($array), 'is_string'));
  }

  /**
    * sets the values of a given associative array to refferences
    * @param array $array array to convert
    * @return array $array: if php version less than 5.3 or $refferences: array with refferences as values
    */
  private function array_refValues(array $array){
    if(strnatcmp(phpversion(),'5.3') >=0 ) {//Reference is required for PHP 5.3+
      $references = array();
      foreach($array as $key => $value)
          $references[$key] = &$array[$key];
      return $references;
    }
    return $array;

  }

  /**
  * retrieves contents of given rows from a given table
  *
  */

}
?>
