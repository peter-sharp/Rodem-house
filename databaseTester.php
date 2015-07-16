<?php
require("database.php");

class DatabaseTest extends PHPUnit_Framework_Testcase {

  public function testCanConnectTODatabase(){
    $databaseHelper = new DatabaseHelper();

    $this->assertInstanceOf('DatabaseHelper' ,$databaseHelper);
  }

  public function testCanInsertIntoDatabase(){
    $databaseHelper = new DatabaseHelper();

    $databaseHelper->insert("pages", array("contact", "parking can be found around the back.", 3, 1));:

    $result = $mysqli->query("SELECT title, body, contacts_id, edited_by FROM `pages` WHERE `title` = 'contact'");
    $contact_page = $result->fetch_assoc();
    $this->assertEquals($contact_page['title'] , "contact");
  }
}
?>
