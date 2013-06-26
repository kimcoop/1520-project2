<?php


  class Requirement extends Model {
    public $title, $category;

    function __construct() {
      parent::__construct();
    }

    public function is_elective() {
      return $this->category == 'elective';
    }

    public function set_all( $id, $title, $category ) {
      $this->id = $id;
      $this->title = $title;
      $this->category = $category;
    }

    public function get_elective_number() {
      // big hack - may be a better way to do this.
      // if a course is an elective, get its elective number last char.
      // ASSUMES elective number is last char in string
      if ( $this->is_elective() ) {
        $chars = strlen( $this->title );
        $elective_number = (int) $this->title[ $chars -1];
        return $elective_number;
      }
    }

    public function get_course_options() {
      return RequirementCourse::find_all_by_requirement_id( $this->id );
    }

    public function get_satisfying_course( $psid ) {

      $course_options = $this->get_course_options();
      $elective_index = 1;

      foreach( $course_options as $course_option ) {
        $option_course_department = $course_option->get_department();
        $option_course_number = $course_option->get_course_number();

        $course = Course::where_one( "department='$option_course_department' AND course_number='$option_course_number'" );
        $user_course = UserCourse::where_one( "psid='$psid' AND course_id='$course->id'" );

        if ( !is_null( $user_course ) && !$user_course->is_passing_grade() )
          continue;

        if ( $this->is_elective() && $elective_index <= $this->get_elective_number() ) { 
          // effectively skip this course_record since it will satisfy other electives that preceeded it
          if ( !is_null( $user_course ) ) { // if the user has taken the course that would satisfy
            $elective_index = $elective_index + 1;
            continue; // skip it
          }
        }

        if ( !is_null( $user_course ) )
          return $user_course;
      }

      return NULL;
    }

    public function get_requirements() {

      $course_options = $this->get_course_options();
      $reqs = '';

      foreach( $course_options as $index => $course_option ) {
        $reqs .= $course_option;
        if ( $index != count($course_options) -1 )
          $reqs .= ", ";
      }
      return $reqs;
    }

    public function get_values() {
      return array( $this->title, $this->category );
    }

    public function __toString() {
      return "$this->title";
    }

    /*
    *
    * CLASS METHODS
    *
    */

    public static function get_properties() {
      return "title, category";
    }

    public static function where_one( $conditions ) {
      return parent::where_one( 'requirements', $conditions );
    }

    public static function find_by_title( $title ) {
      $requirement = self::where_one( "title='$title'" );
      return $requirement;
    }

    public static function load_record( $record ) {
      $requirement = new Requirement();
      $requirement->set_all( $record['id'], $record['title'], $record['category'] );
      return $requirement;
    }

    public static function load_from_file( $line ) {
      $pieces = explode( ":", $line );
      $requirement = new Requirement();
      $requirement->title = $pieces[0];

      // determine category
      $pattern = '/Elec/';
      if ( preg_match( $pattern, $requirement->title ) )
        $requirement->category = 'elective';
      else
        $requirement->category = 'core';

      return $requirement;
    }

    public static function find_all() {
      return parent::find_all( 'requirements' );
    }

  }

?>