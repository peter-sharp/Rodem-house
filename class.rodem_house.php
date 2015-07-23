<?php
require_once('class.database.php');

class RodemHouseException extends Exception {};

class RodemHouse {
    public $database;
    public $currentPage; #@TODO needed for router-like functionality of index page
    public $pageNames = array('home','about us','meetings','contact', 'english lessons');

    private $eventsSqlParams;

    public function RodemHouse(){
      $this->database = new DatabaseHelper();

      $this->eventsSqlParams = array(
        'columns' =>  array('ID','event_title','page_title','category_title','event_description',
        'datetime','address_title','address','coordinates','image_title','image_description',
        'image_location','featured'));
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

      if (isset($category)){
        $events = $database->getRowsFromTable('events', $columns, array("category_title" => $category, 'featured' => 1));
      }
      else {
        $events = $database->getRowsFromTable('events', $columns, array('featured' => 1));
      }
      return $events;
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


      if (isset($title)){
        $categories = $database->getRowsFromTable('categories', $columns, array('category_title' => $title));
      }
      else{
        $categories = $database->getRowsFromTable('events', $columns );
      }
      return $categories;
    }

    public function getPageNames(){
      return $this->pageNames;
    }
}
