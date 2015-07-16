<?php
class databaseBuilderException extends Exception { };

class DatabaseBuilder {
	private $servername;
	private $username;
	private $password;
	private $connection;
	public function DatabaseBuilder($servername = null, $username = null, $password = null){
		$this->servername = ($servername) ? $servername : 'localhost';
		$this->username = ($username) ? $username : 'root';
		$this->password = ($password) ? $password : 'Ch4ng3m3#';
		$this->connection = $this->createConnection();
		$this->createAndEnterDatabase('website');
		$this->createTables();
	}

	private function createConnection () {
		$connection = new mysqli($this->servername, $this->username, $this->password);
		//check connection
		if ($connection->connect_error)
			die("Connection failed: " . $this->connection->connect_error);
		else
      return $connection;
	}

	private function createAndEnterDatabase ($database) {
		$sqlQueries = array("CREATE DATABASE IF NOT EXISTS `$database`", "USE `$database`");
    $this->querySqlQue($sqlQueries);
	}

   /* processes an array of query statements
    * @param array $sqlQueries Que of array statements to be processed
    * @return mixed true if successful error message if not
    */
  public function querySqlQue ($sqlQueries) {
    foreach($sqlQueries as $sql){
      $querie = $this->querySql($sql);
			if($querie)
        echo "$sql = Success!\n";
		}
  }

	public function querySql ($sql) {
		if ($this->connection->query($sql)) {
			return TRUE;
      echo "Sql query: '$sql' , succeeded!\n";
    }
		else
			throw new databaseBuilderException( "MySQL Error: ".$this->connection->error);
	}

	private function createTables(){
		$sqlQueries = array(

		"CREATE TABLE IF NOT EXISTS `users` (
      `ID` INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      `username` VARCHAR(50) NOT NULL,
      `password` TEXT NOT NULL,
      `type` VARCHAR(30) NOT NULL
		)",

    "CREATE TABLE IF NOT EXISTS `events` (
				`ID` INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `title` VARCHAR(50) NOT NULL,
        `description` TEXT NOT NULL,
        `datetime` TINYTEXT NOT NULL,
        `address` TEXT NOT NULL
		)",

		"CREATE TABLE IF NOT EXISTS `home_page` (
      `ID` INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      `intro` TEXT NOT NULL
		)",

    "CREATE TABLE IF NOT EXISTS `about_page` (
      `ID` INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      `intro` MEDIUMTEXT NOT NULL
		)",

    "CREATE TABLE IF NOT EXISTS `meetings_page` (
      `ID` INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      `CATEGORY` VARCHAR(50) NOT NULL,
      `intro` TEXT NOT NULL
		)",

    "CREATE TABLE IF NOT EXISTS `contact_page` (
      `ID` INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      `cellphone` TEXT NOT NULL,
			`phone` TEXT NOT NULL,
			`email` TEXT NOT NULL,
			`address` TEXT NOT NULL
		)",

		"CREATE TABLE IF NOT EXISTS `english_page` (
      `ID` INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      `description` MEDIUMTEXT NOT NULL,
			`datetime` TINYTEXT NOT NULL
		)");

    $this->querySqlQue($sqlQueries);
	}
}

# Start DatabaseBuilder if called from command line
if (php_sapi_name() == "cli") {
  echo "Building database....\n";
  $website = new DatabaseBuilder();
}
?>
