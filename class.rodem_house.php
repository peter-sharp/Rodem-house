<?php
require_once('class.database.php');

class RodemHouseException extends Exception {};

class RodemHouse {
    private $database;
    public $currentPage; #@TODO needed for router-like functionality of index page
    public $pageNames = array('home','about us','meetings','contact', 'english lessons');

    private $eventsSqlParams;

    public function RodemHouse(){
      $this->database = new DatabaseHelper();

      $this->eventsSqlParams = array(
        'columns' =>  array('ID','event_title','page_title','category_title','event_description',
        'datetime','address_title','address','coordinates','image_title','image_description',
        'image_location','featured'),

        'joins' => "INNER JOIN `pages` ON `pages`.ID = `events`.page_id
        INNER JOIN `categories` ON `categories`.ID = `events`.category_id
        INNER JOIN `addresses` ON `addresses`.ID = `events`.address_id
        INNER JOIN `images` ON `images`.ID = `events`.image_id"
      );
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

  /**
 	 * returns the current featured events of a given category or all featured events
   * if no category is given
 	 *
 	 * @param string $category the category
   * @return multidimensional array of events
   *
   */
    public function getFeaturedEvents($category = null){
      $columns = $this->eventsSqlParams['columns'];

      $sql = $this->eventsSqlParams['joins']." WHERE `events`.featured = 1";

      if (isset($category)){
        $events = $database->getRowsFromTable('events',
          $columns,
          $sql." AND WHERE `categories`.category_title = $category");
      }
      else {
        $events = $database->getRowsFromTable('events', $columns, $sql);
      }
    }

    /**
 	 * return a category of a given title or all categories if none supplied
 	 *
 	 * @param string $title the title of the category name to return
 	 * @return mixed associative array if given a title or a multi dimensional array if not
	 */

    public function getCategories($title = null){
      $columns = array('ID','category_title','category_description',
      'address_title','address','coordinates');

      $sql = " INNER JOIN `addresses` ON `addresses`.ID = `categories`.address_id";

      if (isset($title)){
        $events = $database->getRowsFromTable('categories',
          $columns,
          $sql." WHERE `categories`.category_title = $title");
      }
      else{
        $events = $database->getRowsFromTable('events', $columns, $sql);
      }
    }

    public function getPageNames(){
      return $this->pageNames;
    }
}
