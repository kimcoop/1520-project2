<?php

  class Course extends Model implements Storable {

    public $department, $course_number;
    public  $term='TODO', $psid='TODO', $grade='TODO';

    function __construct() {
      parent::__construct();
    }

    public function print_with_grade() {
      echo $this->get_with_grade();
    }

    public function get_with_grade() {
      $format = "%s %s (grade %s)";
      return sprintf( $format, $this->department, $this->course_number, $this->grade );
    }

    public function titleize() {
      $format = "%s %s (term %s, grade %s)";
      return sprintf( $format, $this->department, $this->course_number, $this->term, $this->grade );
    }

    public function is_passing_grade() {
      $passing_grades = array("A+", "A", "A-", "B+", "B", "B-", "C+", "C");
      return in_array( $this->grade, $passing_grades ); 
    }

    public function get_values() {
      return array( $this->department, $this->course_number);
    }

    public function __toString() {
      return "$this->department, $this->course_number";
    }

    public function set_all( $department, $course_number ) {
      $this->department = $department;
      $this->course_number = $course_number;
    }

    /*
    *
    * CLASS METHODS
    *
    */

    public static function get_properties() {
      return "department, course_number";
    }

    public static function load_record( $record ) {
      $course = new Course();
      $course->set_all( $record[ "department" ], $record[ "course_number" ] );
    }

    public static function load_from_file( $line ) {
      $pieces = explode( ":", $line );
      $course = new Course();
      $course->set_all( $pieces[0], $pieces[1] );
      return $course;
    }

    public static function get_courses_for_user( $psid ) {
      // collect which courses map to the passed-in psid
      $courses = parent::find_all( 'Course' );

      $user_courses = array();

      foreach( $courses as $course ) {
        if ( $course->psid == $psid ) {
          $user_courses[] = $course;
        }
      }
      
      return $user_courses;
    }

    public static function get_courses_by( $grouping, $psid ) {
      $all_courses = parent::find_all( 'Course' );
      $courses = array();
      foreach( $all_courses as $course ) {
        if ( $course->psid == $psid ) {
          if ( $grouping == 'term' )
            $courses[ $course->term ][] = $course; // TODO - better?
          else
            $courses[ $course->department ][] = $course;
        }
      }
      return $courses;
    }
  }


?>