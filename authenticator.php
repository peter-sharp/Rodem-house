<?php
session_start();
require_once('database.php');
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
       $username = $_POST['login']['username'];
       $password = $_POST['login']['password'];

       if($user = $this->login($username, $password) ){
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
    $sql = "SELECT password FROM `users` WHERE email = ?";

    //run query to find specific user
    if($result = $this->database->secureQuery($sql,array('email' => $email)) ){
        if ( password_verify( $password, $result[0]['password'] ) ){
          $_SESSION['username'] = $username;
          $_SESSION['loggedIn'] = TRUE;
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
    return $_SESSION['loggedIn'];
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
