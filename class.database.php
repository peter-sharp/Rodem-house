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
  public function insertInTable($table, $formData){


    $sql = "INSERT INTO `$table`({{COLUMNS}}) VALUES ({{VALUES}})";

    // get values for header message
    $values = array_values($formData);

    try{
      $this->secureQuery($sql,$formData);

      $message = "message=Successfully added (".implode(',',$values).")";
    }
    catch(Exception $error) {
      $message = "Error=Failed to add (".implode(',',$values).")";
      //$logger->log($error);
      //echo $error;
    }
    finally {
      return $message;
    }
  }

  /**
    * prepares binds and executes a given mysql statement.
    * uses templates:
    * {{COLUMNS}} for columns to perform action on
    * {{values}} for values to add
    * {{UPDATES}} for columns to update
    * @param string $query query to execute
    * @param associative array $data to insert into the sql statement
    *  throws an error if not successful
    */
  public function secureQuery($sql,$data){
    $mysqli = $this->mysqli;

    if(!$this->array_isAssoc($data))
        throw new DatabaseException("data needs to be an associative array! \n current:". print_r($formData, true));

    $columns = array_keys($data);
    $values = array_values($data);

    // generate a value types string for the prepared statement
    $types = implode('',$this->createTypesArray($values) );

    //check for template sql
    $isTemplate = strpos($sql,"{{");
    if( $isTemplate !== FALSE){
      $finalSql = $this->generateFromTemplate($sql, $columns);
    }
    else {
      $finalSql = $sql;
    }

    if(!$statement = $mysqli->prepare($finalSql)){
      throw new DatabaseException("Error prepearing statement:".$mysqli->error);
    }

    // function to insert the contents of an array as arguments to the bind_param function
    $bind_param_args = array_merge(array($types), $values);
    $query = call_user_func_array(array($statement, "bind_param"), $this->array_refValues($bind_param_args));

    $statement->execute();
    if($mysqli->error) //throw a mysql error
      throw new DatabaseException( "Error in mysql: ".$mysqli->error);

    $statement->store_result();
    if($statement->num_rows > 0){
        return $this->getResultsFromStatement($statement);
    }

  }

  /**
    * gets results from a mysqli statement if they EXISTS
    * @param object $statement mysqli statement(stmt) object
    * @return array results
    */
  private function getResultsFromStatement($statement){


    $metadata = $statement->result_metadata();

    //keeps returning the definition of on column of a result untill all columns have been retrieved
    while ($field = $metadata->fetch_field()) {
        $parameters[] = &$row[$field->name];
    }
    //print_r($metadata);
    //print_r(get_class_methods($metadata));

    call_user_func_array(array($statement, 'bind_result'), $parameters);
    while ($statement->fetch()) {
      foreach($row as $key => $value) {
        $column[$key] = $value;
      }
      $results[] = $column;
    }
    return $results;

  }

  /**
    * fils out given mysql templates with given parameters
    * uses templates:
    * {{COLUMNS}} for columns to perform action on
    * {{values}} for values to add
    * {{UPDATES}} for columns to update
    * @param string $sqlTemplate Template to fill with parameters
    * @param array $columns To populate the teplates with
    * @return generated teplate string
    */
  private function generateFromTemplate($sqlTemplate, $columns){

    // generate slots for each value
    $slots = str_split( str_repeat("?", count($columns)) );
    // replace {{COLUMNS}}, {{VALUES}} and {{UPDATES}} with their actual values
    $valuesToInsert = array( implode(',', $columns), implode(',', $slots), implode('=?, ',array_slice($columns, 0 , -1))."=?" ); //array_slice cuts ID off the end
    $stringsToReplace = array( "{{COLUMNS}}", "{{VALUES}}","{{UPDATES}}" );

    return str_replace($stringsToReplace, $valuesToInsert, $sqlTemplate);
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
      switch(gettype($value)){
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
    return count(array_filter(array_keys($array), 'is_string')) != 0;
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
     * Enables updates to specific data in the database for a given table
     *
     * @param string $table Name of table to update in
     * @param int $id Id of form row to update data within specified table
     * @param associative array $formData data to insert into row of specified ID
     *        with the format 'column => value'
     *
     * @TODO write update method
     */
  public function updateInTable($table,  $id, $formData){
    $sql = "UPDATE `$table` SET {{UPDATES}} WHERE ID=?";

    // get values for header message
    $values = array_values($formData);
    //append ID onto the end to match sql query
    $formDataAndID = array_merge($formData,array("ID" => $id));
    try{
      $this->secureQuery($sql,$formDataAndID);

      $message = "message=Successfully updated (".implode(',',$values).")";
    }
    catch(Exception $error) {
      $message = "Error=Failed to update (".implode(',',$values).")";
      //$logger->log($error);
      //echo $error;
    }
    finally {
      return $message;
    }
  }

   /**
   * removes a row of a given table based on given parameters
   *
   * @param string $table Name of table to remove row from
   * @param string $column column to search for value
   * @param string $value value in column of row or rows to remove
   *
   * @TODO write remove function
   */
  public function removeFromTable($table, $column, $value){
    $sqlQuery = "DELETE FROM `$table` WHERE $column=$value";
    try{
      $result = $this->mysqli->query($sqlQuery);
      $message = "$result row".(($result > 1)? "s" : "")." deleted \n";
      return $message;
    }
    catch (Exception $error){
      throw new DatabaseException($error);
    }
  }



    /**
    * retrieves all rows of given columns from a given table
    * NOTE not efficient for tables with thousands of rows
    * @TODO add minimum and maximum ID parameters
    * @param array $table table in which to get rows from
    * @param array $columnNames collumns to get data from
    * @param string $joinSql [optional] sql to join other tables @TODO..maybe find way to automate this
    * @return multi-dimensional array $rowData
    */
  public function getRowsFromTable($table, $columnNames, $joinSql = ""){
    if (func_num_args() > 1){

      $sqlQuery = "SELECT ".implode(",", $columnNames)." FROM `$table`".$joinSql;

    }
    else {
      $sqlQuery = "SELECT * FROM `$table`";
    }

    $result = $this->queryRows($sqlQuery);

    return $result;
  }

  /**
   * executes a given sql query on a row and returns an appropriate value.
   *
   * @param string $sql SQL to run against connected database
   * @return associative array $row Row matched by the given SQL statement
   */
  public function queryRow($sql = null){
    $mysqli = $this->mysqli;
    $this->query = $this->query ? : $mysqli->query($sql);
    
    if($mysqli->error){
          throw new DatabaseException( "Error in mysql: ".$mysqli->error);
    }

    // we have selected something
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