<?php

  class User extends Model {

    private $access_level, 
      $email, 
      $first_name, 
      $last_name, 
      $password, 
      $psid, 
      $user_id,
      $secret_question,
      $secret_answer;

    function __construct() {
      parent::__construct();
    }

    public function change_password( $old_password, $new_password, $new_password_confirm ) {
      // TODO: sanitize
      // ensure presence of all parameters and ensure new password + confirmation match
      if ( !$old_password || !$new_password || !$new_password_confirm || (( $new_password != $new_password_confirm )))
        return false;

      $hash_old = hash( 'sha256', $old_password );

      // ensure user input is valid
      if ( $this->get_password() != $hash_old ) {
        return false;
      }

      $hash_new = hash( 'sha256', $new_password );
      $hash_new_confirm = hash( 'sha256', $new_password_confirm );

      $this->password = $hash_new;

      return User::update( 'users', $this, "password='$hash_new'" );
    }

    public function set_secret_question( $question, $answer ) {
      // TODO: sanitize
      $this->secret_question = $question;
      $this->secret_answer = $answer;
      return User::update( 'users', $this, "secret_question='$question', secret_answer='$answer'" );
    }

    public function get_values() {
      return array( $this->psid, $this->access_level, $this->user_id, $this->email, $this->first_name, $this->last_name, $this->password, $this->secret_question, $this->secret_answer );
    }

    public function get( $property ) {
      return $this->$property;
    }

    public function get_user_id() {
      return $this->user_id;
    }

    public function get_email() {
      return $this->email;
    }

    public function get_password() {
      return $this->password;
    }

    public function get_last_name() {
      return $this->last_name;
    }

    public function get_first_name() {
      return $this->first_name;
    }

    public function get_psid() {
      return $this->psid;
    }

    public function get_full_name() {
      return "$this->first_name $this->last_name";
    }

    public function get_access_level() {
      return $this->access_level;
    }

    public function get_secret_question() {
      return $this->secret_question;
    }

    public function get_secret_answer() {
      return $this->secret_answer;
    }

    public function set_all( $access_level, $email, $first_name, $last_name, $password, $psid, $user_id ) {
      $this->access_level = $access_level;
      $this->email = $email;
      $this->first_name = $first_name;
      $this->last_name = $last_name;
      $this->password = $password;
      $this->psid = $psid;
      $this->user_id = $user_id;
    }

    public function __toString() {
      return "$this->psid, $this->access_level, $this->user_id, $this->email, $this->first_name, $this->last_name, $this->password, $this->secret_question, $this->secret_answer";
    }


    /*
    *
    * CLASS METHODS
    *
    */

    public static function load_record( $record ) {
      $user = new User();
      $user->set_all( 
        stripslashes(rtrim( $record[ "access_level" ])),
        stripslashes(rtrim( $record[ "email" ])),
        stripslashes(rtrim( $record[ "first_name" ])),
        stripslashes(rtrim( $record[ "last_name" ])),
        stripslashes(rtrim( $record[ "password" ])),
        stripslashes(rtrim( $record[ "psid" ])),
        stripslashes(rtrim( $record[ "user_id" ]))
      );
      return $user;
    }

    public static function load_from_file( $line ) {
      $pieces = explode( ":", $line );
      $user = new User();
      $user->set_all( 
        rtrim( $pieces[6] ), // access
        rtrim( $pieces[3] ), // email
        rtrim( $pieces[5] ), // first_name
        rtrim( $pieces[4] ), // last_name
        rtrim( hash( 'sha256', $pieces[1] ) ), // password
        rtrim( $pieces[2] ), // psid
        rtrim( $pieces[0] ) // user_id
      );
      return $user;
    }

    public static function get_properties() {
      return "psid, access_level, user_id, email, first_name, last_name, password, secret_question, secret_answer";
    }

    public static function signin( $user_id, $password ) {
      $hashed_password = hash( 'sha256', $password );
      if ( self::password_is_correct( $user_id, $hashed_password ) ) {
        $user = self::find_by_user_id( $user_id );
        session_start();
        $_SESSION[ 'user' ] = $user;
        $_SESSION[ 'viewing_psid' ]= $user->get_psid();  // so we can use one variable for both roles. overwrite if/when advisor looks up student
        
        // if ( is_student() )
        //   echo "is student";
        // else
        //   echo "is advisor";
          // $_SESSION['user_courses'] = Course::get_courses_for_user( $_SESSION['psid'], $_SESSION['all_courses'] );
        // $expire = time() + 60 * 60 * 24 * 30;
        // setcookie( "user_id", $user_id, $expire ); // set cookie to what user passed in

        return $user;
      } else {
        return NULL;
      }

    }

    public static function password_is_correct( $user_id, $password ) {
      $user = self::find_by_user_id( $user_id );
      if ( !$user ) 
        return false;
      else
        return $password == $user->get_password();
    }

    public static function find_by_user_id( $user_id ) {
      return parent::where_one( 'users', "user_id='$user_id'" );
    }

    public static function find_by_psid( $psid ) {
      return parent::where_one( 'users', "psid='$psid'" );
    }

    public static function find_by_full_name( $full_name ) {
      $names = explode( " ", $full_name );
      $first_name = $names[0];
      $last_name = $names[1];
      $user = parent::where_one( 'users', "first_name='$first_name' AND last_name='$last_name'" );
      return $user;
    }

    public static function find_user_by_psid_or_name( $search_term ) {
      $user = User::find_by_psid( $search_term );
      if ( !$user )
        $user = User::find_by_full_name( $search_term );
      return $user;
    }


    public static function send_password( $user_id ) {
      // $this->set_password( "reset" ); // TODO: will be hashed and saved
      
      $email = $this->email;
      $password = $this->password;
      $format = "Your password reset token is %s. Thanks! -- The Advisor Cloud Team";

      $to      = $email;
      $subject = MAILER_SUBJECT;
      $message = sprintf( $format, $password );
      $headers = 'From: ' .MAILER_SENDER . '' . "\r\n" .
          'Reply-To: ' .MAILER_SENDER . '' . "\r\n" .
          'X-Mailer: PHP/' . phpversion();

      mail( $to, $subject, $message, $headers );
      return true;


    }

  }
?>