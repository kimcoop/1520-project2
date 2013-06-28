<?php

  class User extends Model {

    public $STUDENT_ACCESS_LEVEL = 0, 
      $ADVISOR_ACCESS_LEVEL = 1,
      $ADMIN_ACCESS_LEVEL = 2;

    public $is_logging_session = FALSE, $logging_session_id; // (advisor only)
    public $courses; // (student only)

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

    public function courses() {
      if ( !$this->courses )
        $this->courses = UserCourse::find_all_by_psid( $this->get_psid() );
      return $this->courses;
    }

    public function total_courses_taken() {
      return count( $this->courses() );
    }

    public function get_gpa() {
      $total_points = 0;
      $user_courses = $this->courses();
      $total_user_courses = count( $user_courses );
      if ( $total_user_courses == 0 ) return "--";

      foreach( $user_courses as $user_course )
        $total_points += parent::grade_points( $user_course->grade );

      return round($total_points / $total_user_courses, 2);
    }

      /**
     * Get either a Gravatar URL or complete image tag for a specified email address.
     *
     * @param string $s Size in pixels, defaults to 80px [ 1 - 2048 ]
     * @param string $d Default imageset to use [ 404 | mm | identicon | monsterid | wavatar ]
     * @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
     * @param array $atts Optional, additional key/value attributes to include in the IMG tag
     * @return String containing either just a URL or a complete image tag
     * @source http://gravatar.com/site/implement/images/php/
     */
    function get_gravatar( $s = 80, $d = 'mm', $r = 'g', $atts = array() ) {
      $email = $this->get_email();
      $url = 'http://www.gravatar.com/avatar/';
      $url .= md5( strtolower( trim( $email ) ) );
      $url .= "?s=$s&d=$d&r=$r";
      return $url;
    }


    function is_logging_session() {
      return $this->is_logging_session;
    }

    function set_is_logging_session( $is_logging_session ) {
      $this->is_logging_session = $is_logging_session;
    }

    function get_logging_session_id() {
      return $this->logging_session_id;
    }

    function set_logging_session_id( $logging_session_id ) {
      $this->logging_session_id = $logging_session_id;
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

      $question = addslashes( $question );
      $answer = hash( 'sha256', addslashes( $answer ) );
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

    public function is_student() {
      return $this->get_access_level() == $this->STUDENT_ACCESS_LEVEL;
    }

    public function is_advisor() {
      // Admins selfdvisor privileges and more
      return $this->get_access_level() == $this->ADVISOR_ACCESS_LEVEL || $this->get_access_level() == $this->ADMIN_ACCESS_LEVEL;
    }

    public function is_admin() {
      return $this->get_access_level() == $this->ADMIN_ACCESS_LEVEL;
    }


    public function get_role() {
      switch ( $this->get_access_level() ) {
        case 0:
          return "Student";
        case 1:
          return "Advisor";
        default:
          return "Admin";
      }
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

    public function set_all( $access_level, $email, $first_name, $last_name, $password, $psid, $user_id, $question=NULL, $answer=NULL ) {
      $this->access_level = $access_level;
      $this->email = $email;
      $this->first_name = $first_name;
      $this->last_name = $last_name;
      $this->password = $password;
      $this->psid = $psid;
      $this->user_id = $user_id;
      $this->secret_question = $question;
      $this->secret_answer = $answer;
    }

    public function __toString() {
      return "$this->psid, $this->access_level, $this->user_id, $this->email, $this->first_name, $this->last_name, $this->password, $this->secret_question, $this->secret_answer";
    }

    public function get_reset_password() {
      $new_pass = uniqid( $this->get_user_id() ); // to email user
      $hash_new = hash( 'sha256', $new_pass ); // to store in DB

      if ( User::update( 'users', $this, "password='$hash_new'" ) )
        return $new_pass;
      else
        return NULL;
    }


    /*
    *
    * CLASS METHODS
    *
    */

    public static function create( $access_level, $email, $first_name, $last_name, $password, $psid, $user_id ) {
      $user = new User();
      $hashed_password = hash( 'sha256', $password );
      $user->set_all( 
        addslashes( $access_level ),
        addslashes( $email ),
        addslashes( $first_name ),
        addslashes( $last_name ),
        addslashes( $hashed_password ),
        addslashes( $psid ),
        addslashes( $user_id )
      );
      return DB::insert( 'users', $user );
    }
    


    public static function load_record( $record ) {
      $user = new User();
      $user->set_all( 
        stripslashes(rtrim( $record[ "access_level" ])),
        stripslashes(rtrim( $record[ "email" ])),
        stripslashes(rtrim( $record[ "first_name" ])),
        stripslashes(rtrim( $record[ "last_name" ])),
        stripslashes(rtrim( $record[ "password" ])),
        stripslashes(rtrim( $record[ "psid" ])),
        stripslashes(rtrim( $record[ "user_id" ])),
        stripslashes(rtrim( $record[ "secret_question" ])),
        stripslashes(rtrim( $record[ "secret_answer" ]))
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
        rtrim( $pieces[0] ), // user_id
        NULL, // users from file won't have secret question
        NULL // users from file won't have secret answer
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
        
        $expire = time() + 60 * 60 * 24 * 30;
        setcookie( "user_id", $user_id, $expire ); // set cookie to what user passed in

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

    public static function find_all() {
      return parent::find_all( 'users' );
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

    public static function find_by_psid_or_name( $search_term ) {
      $user = User::find_by_psid( $search_term );
      if ( !$user )
        $user = User::find_by_full_name( $search_term );
      return $user;
    }

    public static function delete_by_psid( $psid ) {
      return parent::delete_where( 'users', "psid='$psid'" );
    }

    public static function reset_and_send_password( $user_id ) {
      
      $user = User::find_by_user_id( $user_id );

      if ( !$user )
        return FALSE;

      $email = $user->get_email();
      $new_password = $user->get_reset_password();

      if ( !$new_password )
        return FALSE;

      $format = "Your password has been reset to %s. Thanks! -- The Advisor Cloud Team";

      $to      = $email;
      $subject = MAILER_SUBJECT;
      $message = sprintf( $format, $new_password );
      $headers = 'From: ' .MAILER_SENDER . '' . "\r\n" .
          'Reply-To: ' .MAILER_SENDER . '' . "\r\n" .
          'X-Mailer: PHP/' . phpversion();

      return mail( $to, $subject, $message, $headers );

    }

  }
?>