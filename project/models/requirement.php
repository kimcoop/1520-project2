<?php

  class Requirement extends Model {
    public $title, $category;

    function __construct() {
      parent::__construct();
    }

    public function get_is_elective() {
      $pattern = '/Elec/';
      preg_match( $pattern, $this->title, $matches );
      return count( $matches ) > 0;
    }

    public function get_elective_number() {
      if ( $this->is_elective ) {
        $chars = strlen( $this->title );
        $elective_number = (int) $this->title[ $chars -1];
        return $elective_number;
      }
    }

    public function is_satisfied( $psid, $user_courses ) {
      return !is_null( $this->get_satisfying_course( $psid, $user_courses ) );
    }

    public function print_satisfying_course( $psid, $user_courses ) {
      $course = $this->get_satisfying_course( $psid, $user_courses );
      echo $course->titleize();
    }

    public function get_satisfying_course( $psid, $user_courses ) {

      $elective_index = 1;
      $course = NULL;

      foreach( $this->course_options as $course_option ) {
        $pieces = explode( ",", $course_option );
        $req_course_department = $pieces[0];
        $req_course_number = (int) $pieces[1];

        if ( $this->is_elective && $elective_index <= $this->get_elective_number() ) { // effectively skip this course_record since it will satisfy other electives that preceeded it
          
          if ( !is_null(get_user_course_record( $psid, $req_course_department, $req_course_number)) ) { // if the user has taken the course that would satisfy
            $elective_index = $elective_index + 1;
            continue; // skip it
          }

        } else {
          $course = get_user_course_record( $psid, $req_course_department, $req_course_number);
        }

        if ( !is_null( $course ) ) {
          return $course;
        }
      }
      return NULL;
    }

    public function print_requirements() {
      foreach( $this->course_options as $index => $req ) {
        $pieces = explode( ",", $req );
        $department = $pieces[0];
        $number = (int) $pieces[1];
        echo $department . "" . $number; // strip comma
        if ( $index != count($this->course_options) -1 )
          echo ", ";
      }
    }

    public function get_values() {
      return "$this->title, $this->category";
    }

    /*
    *
    * CLASS METHODS
    *
    */

    public static function get_properties() {
      return "$title, $category";
    }

    public static function load_record( $record ) {
      // TODO
    }

    public static function load_from_file( $line ) {
      $pieces = explode( ":", $line );
      $requirement = new Requirement();
      $requirement->title = $pieces[0];
      $requirement->course_options = explode( "|", $pieces[1] );
      return $requirement;

      // TODO - make sure this works with db format
    }

    public static function find_all() {
      // TODO
      return parent::find_all( 'Requirement' );
    }

    public static function populate_requirements( $filename ) {
      // read in and parse the REQS_FILE to collect the list
      $reqs = array();
      $file_handle = fopen( $filename, "r" );
      
      while ( !feof($file_handle) ) {
        $line = fgets( $file_handle );
        $req = new Requirement( $line );
        $reqs[] = $req;
      }

      fclose( $file_handle );
      return $reqs;
    }

  }

?>