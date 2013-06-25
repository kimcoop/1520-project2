<?php

  class Course extends Model {
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

    public function print_course() {
      echo "<strong>$this->department $this->course_number</strong> 
            $this->term
            $this->psid
            $this->grade";
    }

    public function get_values() {
      return array( $this->department, $this->course_number);
    }

    public function __toString() {
      return "$this->department, $this->course_number";
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
      return new Course( 
        $record[ "department" ], 
        $record[ "course_number" ], 
        $record[ "term" ], 
        $record[ "psid" ], 
        $record[ "grade" ]
      );
    }

    public static function load_from_file( $line ) {
      $pieces = explode( ":", $line );
      $course = new Course();
      // TODO- nicer setters/getters
      $course->department = $pieces[0];
      $course->course_number = $pieces[1];
      $course->term = $pieces[2];
      $course->psid = $pieces[3];
      $course->grade = preg_replace( '/[^(\x20-\x7F)]*/','', $pieces[4] );
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