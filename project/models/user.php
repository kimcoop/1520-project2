<?php

  class User extends DAO_Base {
    private $user_id, $email, $last_name, $first_name, $psid, $password, $access_level;
    public $table;

    function __construct() {
      parent::__construct( 'users' );
      $this->table = 'users';// TODO - can i do this here? what's the point?
    }


    public function set_password( $new_password ) {
      $hashed_password = hash( 'sha256', $new_password );
      $this->password = $hashed_password;
      $this->save(); //TODO
    }

    public function get_user_id() {
      return $this->user_id;
    }

    public function get_email() {
      return $this->email;
    }

    public function get_last_name() {
      return $this->last_name;
    }
    public function get_first_name() {
      return $this->first_name();
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


    /*
    *
    * CLASS METHODS
    *
    */

    public static function signin( $user_id, $password ) {
      if ( self::password_is_correct( $user_id, $password ) || true ) { // TODO - correct pw
        $user = self::find_by_id( $user_id );
        return $user;
      } else {
        return NULL;
      }

    }

    public static password_is_correct( $user_id, $password ) {
      $hashed_password = hash( 'sha256', $password );
      $user = self::find_by_id( $user_id );
      return $hashed_password == $user->password;
    }

    public static function find_by_id( $user_id ) {
      // TODO - where does this method belong? parent class?
      $user = new User();
      $user->password = $password;
      $user->user_id = $user_id;
      $user->psid = 1234567;
      $user->email = "kac162@pitt.edu";
      $user->first_name = "Inigo";
      $user->last_name = "Montoya";
      $user->access_level = 0;
      // TODO  - restore from db
      return $user;
    }

    public static function find_by( $field, $value ) {
      parent::find_by( $this->table, $field, $value );

    }

    public static function get_courses_for_user( $psid ) {
      $all_courses = Course::populate_courses( COURSES_FILE );
    }

    public static function find_by_full_name( $full_name ) {
       // TODO - where does this method belong? parent class?
      $user = new User();
      $user->password = $password;
      $user->user_id = $user_id;
      $user->psid = 1234567;
      $user->email = "kac162@pitt.edu";
      $user->first_name = "Inigo";
      $user->last_name = "Montoya";
      $user->access_level = 0;
      // TODO  - restore from db
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