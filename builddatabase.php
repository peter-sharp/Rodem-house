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
      `email` VARCHAR(50) NOT NULL,
      `password` TEXT NOT NULL,
      `type_id` INT(10) UNSIGNED NOT NULL
		)",

		"CREATE TABLE IF NOT EXISTS `user_types` (
      `ID` INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      `title` VARCHAR(50) NOT NULL,
      `DESCRIPTION` TEXT NOT NULL
		)",

    "CREATE TABLE IF NOT EXISTS `events` (
				`ID` INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `title` VARCHAR(50) NOT NULL,
				`page_id` INT(10) UNSIGNED NOT NULL,
				`category_id` INT(10) UNSIGNED NOT NULL,
        `description` TEXT NOT NULL,
        `datetime` TINYTEXT NOT NULL,
        `address_id` INT(10) UNSIGNED,
				`edited_by` INT(10) UNSIGNED NOT NULL,
				`image_id` INT(10) UNSIGNED,
				`featured` TINYINT(1) UNSIGNED NOT NULL
		)",

		"CREATE TABLE IF NOT EXISTS `categories` (
      `ID` INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      `title` TEXT NOT NULL,
			`description` MEDIUMTEXT,
			`address_id` INT(10) UNSIGNED
		)",

		"CREATE TABLE IF NOT EXISTS `pages` (
      `ID` INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      `title` TEXT NOT NULL,
			`body` MEDIUMTEXT,
			`contacts_id` INT(10) UNSIGNED,
			`edited_by` INT(10) UNSIGNED NOT NULL
		)",

		"CREATE TABLE IF NOT EXISTS `contacts` (
      `ID` INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      `cellphone` TEXT NOT NULL,
			`phone` TEXT NOT NULL,
			`email` TEXT NOT NULL,
			`address_id` INT(10) UNSIGNED NOT NULL
		)",

    "CREATE TABLE IF NOT EXISTS `addresses` (
      `ID` INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      `title` TEXT NOT NULL,
			`address` TEXT NOT NULL,
			`coordinates` TEXT NOT NULL
		)",
);

    $this->querySqlQue($sqlQueries);
	}
}

# Start DatabaseBuilder if called from command line
if (php_sapi_name() == "cli") {
  echo "Building database....\n";
  $website = new DatabaseBuilder();
}
?>
