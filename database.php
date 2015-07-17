<?php
#TODO require_once('authenticator.php');
#TODO require_once('logger.php');

class DatabaseException extends Exception { };
/**
  * helper class containing various database methods
  */

class DatabaseHelper {
  private $mysqli;
  private $query;

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
    $this->password = $password ?: "Ch4ng3m3#";
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
      throw new DatabaseException( "Error in mysql: ".$mysqli->error($query));
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
  * retrieves contents of given columns from a given table
  * @param array $table table in which to get rows from
  * @param strings $columns... rows to get data from
  * @return multi-dimensional array $rowData
  */
  public function getRowsFromTable($table){
    if (func_num_args() > 1){

      $columnNames = array_slice(func_get_args(), 1);
      $sqlQuery = "SELECT ".implode(", ", $columnNames)." FROM `$table`";

    }
    else {
      $sqlQuery = "SELECT * FROM `$table`";
    }

    $result = $this->queryRows($sqlQuery);
    return $result;
  }

  /**
   * fetches an associative array of a single row from a table in the given sql.
   *
   * @param string $sql SQL to run against connected database
   * @return associative array $row Row matched by the given SQL statement
   */
  private function queryRow($sql = null){
    $mysqli = $this->mysqli;
    $this->query = $this->query ? : $mysqli->query($sql);
    if(!$this->query)
          throw new DatabaseException( "Error in mysql: ".$mysqli->error);

    $result = $this->query->fetch_assoc();
    return $result;
  }
  /**
    * calls the function queryRow for each row in a table and appends each
    *  result to an array returning the results once finished.
    *  @param string $sql SQL to run against connected database
    * @return array of associative arrays
    **/
  private function queryRows($sql = null){
    $result = array();
    while($row = $this->queryRow($sql) ){
      $result[] = $row;
    }
    return $result;
  }


}
?>
