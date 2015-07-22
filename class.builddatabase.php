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
      `type_title` VARCHAR(50) NOT NULL,
      `type_description` TEXT NOT NULL
		)",

    "CREATE TABLE IF NOT EXISTS `events` (
				`ID` INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        `event_title` VARCHAR(50) NOT NULL,
				`page_id` INT(10) UNSIGNED NOT NULL,
				`category_id` INT(10) UNSIGNED NOT NULL,
        `event_description` TEXT NOT NULL,
        `datetime` TINYTEXT NOT NULL,
        `address_id` INT(10) UNSIGNED,
				`edited_by` INT(10) UNSIGNED NOT NULL,
				`image_id` INT(10) UNSIGNED,
				`featured` TINYINT(1) UNSIGNED NOT NULL
		)",

		"CREATE TABLE IF NOT EXISTS `categories` (
      `ID` INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      `category_title` TEXT NOT NULL,
			`category_description` MEDIUMTEXT,
			`address_id` INT(10) UNSIGNED
		)",

		"CREATE TABLE IF NOT EXISTS `pages` (
      `ID` INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      `page_title` TEXT NOT NULL,
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
      `address_title` TEXT NOT NULL,
			`address` TEXT NOT NULL,
			`coordinates` TEXT NOT NULL
		)",
		"CREATE TABLE IF NOT EXISTS `images` (
      `ID` INT(10) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
      `image_title` TEXT NOT NULL,
			`image_description` TEXT NOT NULL,
			`image_location` TEXT NOT NULL
		)"
		);

    $this->querySqlQue($sqlQueries);
	}

	private function insertDefaultValues(){
		$sqlQueries = array(
			"INSERT IGNORE INTO `website`.`user_types`
			SET `ID` = 1,
			`type_title` = 'editor',
			`type_description` = 'Can only edit events on the website'",

			"INSERT IGNORE INTO `website`.`user_types`
			SET `ID` = 2,
			`type_title` = 'admin',
			`type_description` = 'Can edit almost everything on the website'",

			"INSERT IGNORE INTO `website`.`users`
			SET `ID` = 1,
			`email` = 'hong_gildong@hanmail.net',
			`password` = '".password_hash("k0ng34Ho^G12", PASSWORD_DEFAULT)."',
			`type_id` = 2",

			"INSERT IGNORE INTO `website`.`users`
			SET `ID` = 2,
			`email` = 'dooman@hanmail.net',
			`password` = '".password_hash("cabB@ge46pIg", PASSWORD_DEFAULT)."',
			`type_id` = 1",

			"INSERT IGNORE INTO `website`.`categories`
			SET `ID` = 1,
			`category_title` = 'rodem fellowship',
			`category_description` = 'Enjoy a meal, friendship, and learn more about Christianity every Tuesday at 6pm.',
			`address_id` = 1",

			"INSERT IGNORE INTO `website`.`categories`
			SET `ID` = 2,
			`category_title` = 'bible study',
			`category_description` = \"Study the Bible and find out why it's the world's best seller.\",
			`address_id` = 2",

			"INSERT IGNORE INTO `website`.`categories`
			SET `ID` = 3,
			`category_title` = 'social events'",

			"INSERT IGNORE INTO `website`.`events`
			SET `ID` = 1,
			`event_title` = 'Ice Skating',
			`page_id` = 3,
			`category_id` = 3,
			`event_description` = 'Chill with us this weekend at the Alpine Ice sports center.',
			`datetime` = UNIX_TIMESTAMP(),
			`address_id` = 3,
			`edited_by` = 2,
			`image_id` = 2,
			`featured` = 1 ",

			"INSERT IGNORE INTO `website`.`events`
			SET `ID` = 2,
			`event_title` = 'Guest speaker: Hanako Yamada',
			`page_id` = 3,
			`category_id` = 1,
			`event_description` = 'Hanako will share about her life struggles and how God helped her.',
			`datetime` = UNIX_TIMESTAMP(),
			`edited_by` = 1,
			`image_id` = 1,
			`featured` = 1 ",

			"INSERT IGNORE INTO `website`.`images`
			SET `ID` = 1,
			`image_title` = 'guest speaker',
			`image_description` = 'an abstract image of a woman speaking into a microphone in front of a projector',
			`image_location` = './images/events/guest_speaker.png'",

			"INSERT IGNORE INTO `website`.`images`
			SET `ID` = 2,
			`image_title` = 'ice skating',
			`image_description` = 'a dramatic image of a man and a woman figure skating',
			`image_location` = './images/events/ice_skating.jpg'",

			"INSERT IGNORE INTO `website`.`pages`
			SET `ID` = 1,
			`page_title` = 'home',
			`body` = 'Come to Rodem fellowship to:<br>
          practice your <strong>English,</strong>
          make <strong>international friends</strong>,<br>
          and find out about <strong>Christianity</strong>',
			`edited_by` = 1",

			"INSERT IGNORE INTO `website`.`pages`
			SET `ID` = 2,
			`page_title` = 'about us',
			`body` = '<h2>who we are</h2>
        <p>Rodem House is a charitable trust organization <small>(Registration No: CC10913)</small> to support missionaries
          and pastors who need rest and refreshment. Also we support international people who come to
          Christchurch. Rodem house is a faith mission operated by prayer and the support of Christians.</p>',
			`edited_by` = 1",

			"INSERT IGNORE INTO `website`.`pages`
			SET `ID` = 3,
			`page_title` = 'meetings',
			`edited_by` = 1",

			"INSERT IGNORE INTO `website`.`pages`
			SET `ID` = 4,
			`page_title` = 'contact',
			`contacts_id` = 1,
			`edited_by` = 1",

			"INSERT IGNORE INTO `website`.`pages`
			SET `ID` = 5,
			`page_title` = 'english lessons',
			`body` = '<h2>There are free classes every second Tuesday at 4:30pm</h2>
      <p>Classes are relaxed and fun. Our tutor Nancy will help you practice and improve your <strong>speaking</strong>,
      <strong>vocabulary</strong> and <strong>grammar</strong> skills.</p>
      <p>English learners of all abilities are always welcome.</p>',
			`edited_by` = 1",

			"INSERT IGNORE INTO `website`.`contacts`
			SET `ID` = 1,
			`cellphone` = '022 333 4444',
			`phone` = '03 444 5556',
			`email` = 'person@rodemhouse.org',
			`address_id` =1",

			"INSERT IGNORE INTO `website`.`addresses`
			SET `ID` = 1,
			`address_title` = 'rodem fellowship',
			`address` = '344 Manchester St, Christchurch',
			`coordinates` = '-43.521959, 172.639917'"
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
