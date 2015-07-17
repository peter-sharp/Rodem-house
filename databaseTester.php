<?php
require("database.php");

class DatabaseTest extends PHPUnit_Framework_Testcase {
  public $server = "localhost";
  public $username = "root";
  public $password = "";
  public $database = "website";
  public function testCanConnectTODatabase(){
    $databaseHelper = new DatabaseHelper();

    $this->assertInstanceOf('DatabaseHelper' ,$databaseHelper);
  }

  public function testCanInsertIntoDatabase(){
    $databaseHelper = new DatabaseHelper();
    $mysqli = new mysqli($this->server, $this->username, $this->password, $this->database);
    $databaseHelper->insert("pages", array("title" => "contact", "body" => "parking can be found around the back.", "contacts_id" => 3, "edited_by" => 1));

    $result = $mysqli->query("SELECT title, body, contacts_id, edited_by FROM `pages` WHERE `title` = 'contact'");
    $contact_page = $result->fetch_assoc();
    $this->assertEquals($contact_page['title'] , "contact");
  }
}
?>
