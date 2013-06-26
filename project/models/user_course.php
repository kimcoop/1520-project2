<?php

  class UserCourse extends Model {

    public $id, $course_id, $psid, $term, $grade;

    public function set_all( $id, $course_id, $psid, $term, $grade ) {
      $this->id = $id;
      $this->course_id = $course_id;
      $this->psid = $psid;
      $this->term = $term;
      $this->grade = $grade;
    }

    // public function get_with_grade() {
    //   $format = "%s %s (grade %s)";
    //   return sprintf( $format, $this->department, $this->course_number, $this->grade );
    // }

    // public function titleize() {
    //   $format = "%s %s (term %s, grade %s)";
    //   return sprintf( $format, $this->department, $this->course_number, $this->term, $this->grade );
    // }

    public function is_passing_grade() {
      $passing_grades = array("A+", "A", "A-", "B+", "B", "B-", "C+", "C");
      return in_array( $this->grade, $passing_grades ); 
    }

    public function get_values() {
      return array( $this->id, $this->course_id, $this->psid, $this->term, $this->grade );
    }

    public function course() {
      return Course::find_by_id( $this->course_id );
    }

    public function __toString() {
      $course = $this->course();
      return "$course->department $course->course_number $this->grade";
    }

    /*
    *
    * CLASS METHODS
    *
    */

    public static function get_properties() {
      return "id, course_id, psid, term, grade";
    }

    public static function load_record( $record ) {
      $user_course = new UserCourse();
      $user_course->set_all( $record['id'], $record['course_id'], $record['psid'], $record['term'], $record['grade'] );
      return $user_course;
    }

    public static function load_from_file( $line ) {
      $pieces = explode( ":", $line );
      $user_course = new UserCourse();

      $department = $pieces[0];
      $course_number = (int) $pieces[1];

      $course = Course::where_one( "department='$department' AND course_number='$course_number'" );

      if ( !$course ) {
        $course = Course::load_from_file( $line ); // load new course into db
        $course->id = parent::insert( 'courses', $course );
      }

      $user_course->course_id = $course->id;
  
      $user_course->term = $pieces[2];
      $user_course->psid = $pieces[3];
      $user_course->grade = trim( $pieces[4] );

      return $user_course;
    }

    public static function find_all_by_psid( $psid ) {
      $all = parent::where_many( 'user_courses', "psid='$psid'" );
      return $all;
    }

    public static function find_by( $grouping, $psid ) {
      $all = self::find_all_by_psid( $psid );
      $courses = array();
      foreach( $all as $course ) {
        if ( $course->psid == $psid ) {
          if ( $grouping == 'term' )
            $courses[ $course->term ][] = $course;
          else
            $courses[ $course->course()->department ][] = $course;
        }
      }
      return $courses;
    }

  }

?>