<?php require_once("class.rodem_house.php");

class RodemHouseAdmin extends RodemHouse {

  public function RodemHouseAdmin(){
    parent::RodemHouse();
  }

  /**
 	 * gets a concise list of all events
 	 *
 	 * @return a multi-dimensional array containing all events
	 */

  public function getEventList(){
    $events = $this->database->getRowsFromTable('events', array('event_title','datetime','category_title','featured'));
    return $events;
  }

  /**
 	 * gets the values of given columns of the first event that matches the given conditions
 	 *
 	 * @param array $columns the columns to get values from
   * @param associative array $conditions the conditions check rows against
 	 * @return associative array of columns and their values.
	 */
  public function getEvent( array $columns, array $conditions){
    $event = $this->database->queryRow($database->buildSelectQuery('events', $columns, $conditions));
    return $event;
  }

  /**
 	 * gets the values of given columns of the fisrt event that matches the given conditions
 	 *
 	 * @param string $pageName of page to get id from
 	 * @return string ID of page
	 */
  public function getPageID($pageName){
    if (in_array($pageName, $this->pageNames)){
      $sql = $this->database->buildSelectQuery("pages", array("`pages`.ID","page_title"), array( 'page_title' => $pageName));
      $id = $this->database->queryRow($sql)['ID'];
      //die(var_dump($id));
      return $id;
    }
    else {
      throw new RodemHouseException("Error: $pageName is not a known page!");
    }
  }

}
