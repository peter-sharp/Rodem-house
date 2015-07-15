<?php
#TODO require_once('logger.php');

class RedirectMessageHelperException extends Exception{ };

class RedirectMessageHelper {
  public $sections;
  /**
    *constructor function for RedirectHelper: sets the sections attribute to a given array
    *
    * @param array $sections an associative array of table names and their editor pages
    */
  function RedirectHelper($sections = null){
    $this->sections = ($sections)? $sections: array(
      "home_page" => "edit_homepage",
      "about_page" => "edit_aboutpage",
      "meetings_page" => "edit_meetingspage",
      "contact_page" => "edit_contactpage",
      "english_page" => "edit_englishpage",
      "events" => "edit_events"
    );

  }

  /**
    *
    * @param string $userStatusMessage message to send to the user
    */
  

}
?>
