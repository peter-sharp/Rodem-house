<?php
session_start();
require_once('class.database.php');
#TODO require_once('logger.php');

class AuthenticatorException extends Exception { };
/**
  * Authenticator helper class
  **/

class AuthenticatorHelper {
  private $database;
  #TODO private $logger;

  function AuthenticatorHelper(){
    $this->database = new DatabaseHelper();
    //$this->logger = new Logger();

    if($_POST['login']){
       $email = $_POST['login']['email'];

       $password = $_POST['login']['password'];


       if($user = $this->login($email, $password) ){
           // $user being a users database row
           $_SESSION['user'] = $user;
       }
       else {
           //$this->logger->setLog('notification', "Attempted login failed, user name:<strong>$username</strong> password:<strong>$password</strong>");
           //$this->logger->sendEmail();
           $this->logout();
       }
    }
    if( $_GET['logout'] == 'yes' ) {
           $this->logout();
    }
  }

  /**
     * Authentication functions
     **/
    /**
     * attempts to log in to the database.
     * @param $username string User name of database user
     * @param $passowrd string Password of that user
     * @return boolean True if successfully logged in otherwise false.
     **/
  public function login($email, $password) {

    //build query to find all users
    $sql = "SELECT password, type_title FROM `users`
    INNER JOIN `user_types` ON `user_types`.ID = `users`. type_id
    WHERE `users`.email = ? ";

    //run query to find specific user
    if($result = $this->database->secureQuery($sql,array('email' => $email)) ){
        if ( password_verify( $password, $result[0]['password'] ) ){
          $_SESSION['email'] = $email;
          $_SESSION['loggedIn'] = TRUE;
          $_SESSION['usertype'] = strtoupper($result[0]['type_title']);
        }
        else {
          $result = FALSE;
        }
    }
    return $result;
  }

  /**
     * Destroys the user session and redirects to the home page.
     **/
  public function logout(){
    session_destroy();
    header('Location: editor.php');#TODO handle with redirect.php
  }

  /**
    * Checks if the user is logged in
    * @return boolean True if logged in otherwise false.
    */
  public function isAuthenticated(){

    return  $_SESSION['loggedIn'];
  }

  /**
    * Checks if the user is logged in and calls
    * the logout() function to kick out the user if false.
    */
  public function redirectUnauthenticatedUser(){
    if(!$this->isAuthenticated() ){
      $this->logout();
    }
  }

}
?>
