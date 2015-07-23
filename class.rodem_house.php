<?php
require_once('class.database.php');

class RodemHouseException extends Exception {};

class RodemHouse {
    public $database;
    public $currentPage; #@TODO needed for router-like functionality of index page
    public $pageTitles = array('home','about us','meetings','contact', 'english lessons');
    public $navItems = array('editorPages' => array(
            'editor' => 'editor home',
            'edit_events' => 'events',
            'edit_homepage' => 'home page',
            'edit_aboutpage' => 'about us page',
            'edit_meetingspage' => 'meetings page',
            'edit_contactpage' => 'contact page',
            'edit_englishpage' => 'English lessons page'
          ),
     'pages' => array(
          'index' => 'home',
          'about' => 'about us',
          'meetings' => 'meetings',
          'contact' => 'contact',
          'english' => '<small>free</small></br>English lessons'
        ) );

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
      if (in_array($pageName, $this->pageTitles)){
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

  public function getPageTitles(){
    return $this->pageTitles;
  }

  /**
   * redirects to a page with a given page name
   *
   * @param string $pageName name of page to redirect to
   * @return void
   */
  public function gotToPage($pageName){
    $allPages = array_merge($this->navItems['editorPages'],$this->navItems['pages']);
    $location = array_search($pageName, $allPages);
    header("location: ./$location.php");
  }

}
