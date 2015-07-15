<?php
#TODO require_once('authenticator.php');
#TODO require_once('logger.php');

class DatabaseException extends Exception { };
/**
  * helper class containing various database methods
  */

class DatabaseHelper {
  private $mysqli;

  /**
    * constructor method that initialises the database connection
    * @param string $server the server the database belongs to
    * @param string $username the username for the database
    * @param string $password the password for the database
    * @param string $database the database to connect to
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

  /**
    * inserts a single row of data into a database based on params given and redirect
    * user on success/failure with message/error in URL parameter. Note: only accepts strings.
    *
    * @param string $table Name of table to insert new row into
    * @param array $formData Array of data to insert into new row of table
    *
    *
    */
  private function insert($table, $formData){
    $mysqli = $this->mysqli;

    foreach( $formData as $key => $value){
      $values[] = $value;
      $slots[] = "?";
      $keys[] = $key;
    }


    $sql = "INSERT INTO `$table`(". implode(',', $keys) .") VALUES (". implode(',', $slots) .")";
    $statement = $mysqli->prepare($sql);

    // since all inserted values are going to be strings @TODO in future should make this take more data types
    $types = str_repeat("s",count($values));

    // function to insert the contents of an array as arguments to the bind_param function
    $query = call_user_func_array(array($statement, "bind_param"), array_merge(array($types), $values) );

    // generate header message
    if(!$query){ //throw a mysql error
      throw new DatabaseException( "Error in mysql exception: ".$mysqli->error($query));
      $message = "Error=Failed to add (".implode(',',$values).")";
    }
    else {
      $message = "message=Successfully added (".implode(',',$values).")";
    }

    //
  }

}
?>
