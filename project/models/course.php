<?php

  class Course {
    public $department, $number, $term, $psid, $grade;

    function __construct( $line ) {
      $pieces = explode( ":", $line );
      $this->department = $pieces[0];
      $this->number = $pieces[1];
      $this->term = $pieces[2];
      $this->psid = $pieces[3];
      $this->grade = preg_replace( '/[^(\x20-\x7F)]*/','', $pieces[4] );
    }

    public function print_with_grade() {
      echo $this->get_with_grade();
    }

    public function get_with_grade() {
      $format = "%s %s (grade %s)";
      return sprintf( $format, $this->department, $this->number, $this->grade );
    }

    public function titleize() {
      $format = "%s %s (term %s, grade %s)";
      return sprintf( $format, $this->department, $this->number, $this->term, $this->grade );
    }

    public function is_passing_grade() {
      $passing_grades = array("A+", "A", "A-", "B+", "B", "B-", "C+", "C");
      return in_array( $this->grade, $passing_grades ); 
    }

    public function print_course() {
      echo "<strong>$this->department $this->number</strong> 
            $this->term
            $this->psid
            $this->grade";
    }

    public static function populate_courses() {
      $courses = array();

      // TODO: pull from db
      $file_handle = fopen( $filename, "r" );
      
      while ( !feof($file_handle) ) {
        $line = fgets( $file_handle );
        $course = new Course( $line );
        $courses[] = $course;
      }

      fclose( $file_handle );
      return $courses;
    }

    public static function get_courses_for_user( $psid ) {
      // collect which courses map to the passed-in psid
      $courses = self::populate_courses();
      $user_courses = array();

      foreach( $courses as $course ) {
        if ( $course->psid == $psid ) {
          $user_courses[] = $course;
        }
      }
      
      return $user_courses;
    }

    public static function get_courses_by( $grouping, $psid ) {
      $all_courses = self::populate_courses();
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