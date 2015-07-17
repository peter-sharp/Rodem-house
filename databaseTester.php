<?php
require("database.php");

class DatabaseTest extends PHPUnit_Framework_Testcase {
  public $server = "localhost";
  public $username = "root";
  public $password = "Ch4ng3m3#";
  public $database = "website";
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

  public function testCanInsertIntoDatabase(){
    $databaseHelper = new DatabaseHelper();

    $databaseHelper->insert("pages", array("title" => "contact", "body" => "parking can be found around the back.", "contacts_id" => 3, "edited_by" => 1));

    $result = $this->mysqli->query("SELECT title, body, contacts_id, edited_by FROM `pages` WHERE `title` = 'contact'");
    $contact_page = $result->fetch_assoc();
    $this->assertEquals($contact_page['title'] , "contact");
    $this->assertEquals($contact_page['body'] , "parking can be found around the back.");
    $this->assertEquals($contact_page['contacts_id'] , 3);
    $this->assertEquals($contact_page['edited_by'] , 1);
  }

  public function testCanGetRowsFromTable(){
    $databaseHelper = new DatabaseHelper();

    $rows = $databaseHelper->getRowsFromTable('pages', 'ID', 'title' ,'body' ,'contacts_id','edited_by');
    foreach ($rows as $index => $row) {
      $this->assertArrayhasKey('ID' ,$row, "Could not find 'ID' in row.$index: ". print_r($row, TRUE));
      $this->assertArrayhasKey('title' ,$row, "Could not find 'title' in row.$index: ". print_r($row, TRUE));
      $this->assertArrayhasKey('body' ,$row, "Could not find 'body' in row.$index: ". print_r($row, TRUE));
      $this->assertArrayhasKey('contacts_id' ,$row, "Could not find 'contacts_id' in row.$index: ". print_r($row, TRUE));
      $this->assertArrayhasKey('edited_by' ,$row, "Could not find 'edited_by' in row.$index: ". print_r($row, TRUE));
    }

  }

}
?>
