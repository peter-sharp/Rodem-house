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
    $events = $this->database->getRowsFromTable('events', array('event_title','datetime','category_title','featured','`events`.ID'), array('categories'));
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
    if (in_array($pageName, $this->pageTitles)){
      $sql = $this->database->buildSelectQuery("pages", array("`pages`.ID","page_title"),null , array( 'page_title' => $pageName));
      $id = $this->database->queryRow($sql)['ID'];
      //die(var_dump($id));
      return $id;
    }
    else {
      throw new RodemHouseException("Error: $pageName is not a known page!");
    }
  }

  /**
 	 * updates a page with given parameters
 	 *
 	 * @param string $pageName of page to update
   * @param associative array $changes changes to be made column => value
 	 * @return void
	 */
  public function updatePage($pageName,$changes){

    if($_POST['submit']){
      $id = $this->getPageID($pageName);
      $this->database->updateInTable('pages', $id, $changes);
      $this->gotToPage($pageName);
    }elseif($_POST){
      #debug to an email address
      mail('peter@petersharp.co.nz', 'Debugging from RodemHouse Form ', print_r($_REQUEST, true));
      # etc/usr/local/php php.ini "smtp" set it to you isps smtp addr smtp.clearnet. ... check headers php 'mail' page
    }
  }

  /**
 	 * performs appropriate action on a given ID
 	 *
 	 * @param array $ids The ids to perform the action on
   * @param string $action the type of action to perform
 	 * @return array
	 */

  public function selectEventEditAction($ids,$action){
    $id = array_keys($ids);
    $action = array_keys($action)[0];
    switch($action){
      case 'add':
        return array(
          'type' => $action
        );
        break;
      case 'edit': //similar to view
      case 'view':
        $data = $this->database->getRowsFromTable(
          'events',
          array('event_title','event_description','datetime','category_title','image_title','featured','`events`.ID','address'),
          array('categories','images','addresses'),
          array('events.ID' => $id[0])
        );

        return array(
          'type' => $action,
          'data' => $data
        );
        break;
      case 'delete':
        return array(
          'type' => $action
        );
      default:
      #log an error
      #send message to user
    }
  }

  /**
 	 * adds a given event array to the database
 	 *
 	 * @param associative array $event event data to store in the database
 	 * @return string $message to inform the user whether their action was successful or not
	 */
	public function addEvent($event){
    #TODO query database to get IDs for page_id, category_id, address_id, edited_by, image_id
    $pageID = $this->database->getRowsFromTable('pages', array("ID","page_title"), null, array('page_title' => 'meetings'));
    $categoryID = $this->database->getRowsFromTable('categories', array('ID','category_title'), null, array('category_title' => $event['category']));
    $addressID = $this->database->getRowsFromTable('addresses', array('ID','address'), null, array('address' => $event['address']));
    $userID = $this->database->getRowsFromTable('users', array('ID','email'), null, array('email' => $_SESSION['email']));
    $imageID = $this->database->getRowsFromTable('images', array('ID','image_title'), null, array('image_title' => $event['image']));
    $data = array(
      'event_title' => $event['title'],
      'page_id' => $pageID[0]['ID'],
      'category_id' => $categoryID[0]['ID'],
      'event_description' => $event['description'],
      'datetime' => strtotime($event['datetime']),
      'address_id' => $addressID[0]['ID'],
      'edited_by' => $userID[0]['ID'],
      'image_id' => $imageID[0]['ID'],
      'featured' => isset($event['featured'])
    );

	  $message = $this->database->insertInTable('events',$data);
    return $message;
	}



}
