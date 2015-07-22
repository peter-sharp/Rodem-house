<?php
require("class.database.php");

class DatabaseTest extends PHPUnit_Framework_Testcase {
  public $server = "localhost";
  public $username = "root";
  public $password = "Ch4ng3m3#";
  public $database = "website";

  private $rows;
  /**
    * setup mysqli to test with
    */
  public function DatabaseTest(){
    $this->mysqli = new mysqli($this->server, $this->username, $this->password, $this->database);
  }

  public function testCanConnectTODatabase(){
    $databaseHelper = new DatabaseHelper();

    $this->assertInstanceOf('DatabaseHelper' ,$databaseHelper);
  }

  public function testCanBuildJoinQuery(){
    $databaseHelper = new DatabaseHelper();

    $query = $databaseHelper->buildJoinQuery("events");
    $this->assertEquals( " INNER JOIN `pages` ON `pages`.ID = `events`.page_id INNER JOIN `categories` ON `categories`.ID = `events`.category_id INNER JOIN `addresses` ON `addresses`.ID = `events`.address_id INNER JOIN `users` ON `users`.ID = `events`.edited_by INNER JOIN `images` ON `images`.ID = `events`.image_id", $query, "return value from buildJoinQuery did not match expected query string!");
  }

  public function testCanBuildSearchQuery(){
    $databaseHelper = new DatabaseHelper();

    $query = $databaseHelper->buildSearchQuery(array( 'page_title'=> 'contact', 'contacts_id'=> 1, 'edited_by' => 1,));
    $this->assertEquals( " WHERE `page_title`=contact && `contacts_id`=1 && `edited_by`=1", $query, "return value from buildSearchQuery did not match expected query string!");
  }

  public function testCanBuildSelectQuery(){
    $databaseHelper = new DatabaseHelper();

    $query = $databaseHelper->buildSelectQuery('events',array('event_description','address_title', 'category_title', 'image_description'), array( 'event_title'=> 'Ice Skating', 'address_id'=> 2));
    $this->assertEquals( " asdf", $query, "return value from buildSearchQuery did not match expected query string!");
  }

  public function testCanPerformNontemplateSecureQuery(){
    $sql = "SELECT password FROM `users` WHERE `email` =?";

    $databaseHelper = new DatabaseHelper();

    $chosenRow = $databaseHelper->secureQuery($sql,array('email' => "dooman@hanmail.net"));
    $this->assertTrue(password_verify("cabB@ge46pIg", $chosenRow[0]["password"]), "Unexpected result: ".print_r($chosenRow[0]["password"],TRUE));
  }

  public function testCanInsertIntoDatabase(){
    $databaseHelper = new DatabaseHelper();

    $message = $databaseHelper->insertInTable("pages", array("page_title" => "contact", "body" => "parking can be found around the back.", "contacts_id" => 3, "edited_by" => 1));
    //print_r("\n$message\n");
    $result = $this->mysqli->query("SELECT page_title, body, contacts_id, edited_by FROM `pages` WHERE `page_title` = 'contact'");
    $contact_page = $result->fetch_assoc();
    $this->assertEquals( "contact", $contact_page['page_title']);
    $this->assertEquals( "parking can be found around the back.", $contact_page['body']);
    $this->assertEquals( 3, $contact_page['contacts_id']);
    $this->assertEquals(1, $contact_page['edited_by'] );
  }

  public function testCanGetRowsFromTable(){
    $databaseHelper = new DatabaseHelper();

    $this->rows = $databaseHelper->getRowsFromTable('pages',array('ID', 'page_title' ,'body' ,'contacts_id','edited_by'));

    $this->assertGreaterThan(0,count($this->rows), "getRowsFromTable returned an empty array! :" . print_r($this->rows, TRUE));
    foreach ($this->rows as $index => $row) {
      $this->assertArrayhasKey('ID' ,$row, "Could not find 'ID' in row.$index: ". print_r($row, TRUE));
      $this->assertArrayhasKey('page_title' ,$row, "Could not find 'title' in row.$index: ". print_r($row, TRUE));
      $this->assertArrayhasKey('body' ,$row, "Could not find 'body' in row.$index: ". print_r($row, TRUE));
      $this->assertArrayhasKey('contacts_id' ,$row, "Could not find 'contacts_id' in row.$index: ". print_r($row, TRUE));
      $this->assertArrayhasKey('edited_by' ,$row, "Could not find 'edited_by' in row.$index: ". print_r($row, TRUE));
    }
  }

  public function testCanupdateTable(){
    $databaseHelper = new DatabaseHelper();
    $this->rows = $databaseHelper->getRowsFromTable('pages', array('ID'));

    $message = $databaseHelper->updateInTable("pages",$this->rows[0]['ID'], array("page_title" => "test", "body" => "This page demostrates that I can update stuff.", "edited_by" => 45));
    //print_r("\n$message\n");
    $result = $this->mysqli->query("SELECT page_title, body, contacts_id, edited_by FROM `pages` WHERE `page_title` = 'test'");
    $contact_page = $result->fetch_assoc();
    $this->assertEquals($contact_page['page_title'] , "test");
    $this->assertEquals($contact_page['body'] , "This page demostrates that I can update stuff.");
    $this->assertEquals($contact_page['contacts_id'] , 3);
    $this->assertEquals($contact_page['edited_by'] , 45);
  }



  public function testCanRemoveFromTable(){

    $this->mysqli->query("INSERT INTO `pages`(page_title, body, contacts_id, edited_by) VALUES ('about', 'At website we like to test to make sure our database is working.', 5, 12)");

    $databaseHelper = new DatabaseHelper();
    $this->rows = $databaseHelper->getRowsFromTable('pages');
    foreach ($this->rows as $index => $row) {
      $rowId = $row['ID'];
      $message = $databaseHelper->removeFromTable('pages', 'ID' ,$rowId );
      //print_r("\n$message\n");
      $result = $this->mysqli->query("SELECT ID FROM `pages` WHERE ID = $rowId");
      $contact_page = $result->fetch_assoc();
      $this->assertEquals($contact_page, NULL, "Unexpected result, contains: ". print_r($contact_page, TRUE));
    }

  }


}
?>
