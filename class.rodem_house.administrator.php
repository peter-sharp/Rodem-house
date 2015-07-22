<?php require_once("class.rodem_house.php");

class RodemHouseAdmin extends RodemHouse {
  public function RodemHouseAdmin(){

  }

  /**
 	 * gets a concise list of all events
 	 *
 	 * @return a multi-dimensional array containing all events
	 */

  public function getEventList(){
    $events = $this->database->getRowsFromTable('events', array('event_title','datetime','category_title','featured'), "INNER JOIN `categories` ON `categories`.ID = `events`. category_id");
    return $events;
  }

  /**
 	 *
 	 *
 	 * @param type
 	 * @return void
	 */

  public function getEvent( $column, $searchPropery){
    if(isset($column) && isset($searchProperty))
      $event = $this->database->queryRow("SELECT ");
  }

}
