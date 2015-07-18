<?php
class databaseBuilderException extends Exception { };

class DatabaseBuilder {
	private $servername;
	private $username;
	private $password;
	private $connection;
	public function DatabaseBuilder($servername = null, $username = null, $password = null){
		$this->servername = ($servername) ? : 'localhost';
		$this->username = ($username) ? : 'root';
		$this->password = ($password) ? : 'Ch4ng3m3#';
		$this->connection = $this->createConnection();
		$this->createAndEnterDatabase('website');
		$this->createTables();
		$this->insertDefaultValues();
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
			try {
      	$query = $this->querySql($sql);
				if ($query)
						echo "Sql query: \\$sql\\ , succeeded!\n";
			}
			catch(Exception $error){
				$queryno = array_search($sql, $sqlQueries)+1;
				echo "Warning, could not execute query no.$queryno \n Due to $error";
			}
		}
  }

	public function querySql ($sql) {
		if ($this->connection->query($sql)) {
			return TRUE;
    }
		else
			throw new databaseBuilderException( "MySQL Error: ".$this->connection->error);
	}

	private function createTables(){
		$sqlQueries = array(

		"CREATE TABLE IF NOT EXISTS `users` (
      `ID` INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      `email` VARCHAR(50) NOT NULL,
      `password` MEDIUMTEXT NOT NULL,
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

	private function insertDefaultValues(){
		$sqlQueries = array(
			"INSERT IGNORE INTO `website`.`user_types`
			SET `ID` = 1,
			`title` = 'editor',
			`DESCRIPTION` = 'Can only edit events on the website'",

			"INSERT IGNORE INTO `website`.`user_types`
			SET `ID` = 2,
			`title` = 'admin',
			`DESCRIPTION` = 'Can edit almost everything on the website'",

			"INSERT IGNORE INTO `website`.`users`
			SET `ID` = 1,
			`email` = 'hong_gildong@hanmail.net',
			`password` = '".password_hash("k0ng34Ho^G12", PASSWORD_DEFAULT)."',
			`type_id` = 2",

			"INSERT IGNORE INTO `website`.`users`
			SET `ID` = 2,
			`email` = 'dooman@hanmail.net',
			`password` = '".password_hash("cabB@ge46pIg", PASSWORD_DEFAULT)."',
			`type_id` = 1"
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
