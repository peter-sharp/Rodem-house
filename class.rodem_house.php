<?php
require_once('class.database.php');

class RodemHouseException extends Exception {};

class RodemHouse {
    private $database;
    public $currentPage; #@TODO needed for router-like functionality of index page
    public $pageNames = array('home','about us','meetings','contact', 'english lessons');

    public function RodemHouse(){
      $this->database = new DatabaseHelper();
    }

    /**
 	 * returns the body contents of a page with a given name
 	 *
 	 * @param string $pageName The name of the page to get
 	 * @return body contents of the page @TODO could store the whole page
	 */
    public function getPageContent($pageName){
      if (in_array($pageName, $this->pageNames)){
        return $this->database->queryRow("SELECT `body` FROM `pages` WHERE page_title= '$pageName'");
      }
      else {
        throw new RodemHouseException("Error: $pageName is not a known page!");
      }
    }

    public function getPageNames(){
      return $this->pageNames;
    }
}
