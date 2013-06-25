<?php

  class UserCourse extends Model implements Storable {

    public $id, $course_id, $psid, $term, $grade;

    public function set_all( $id, $course_id, $psid, $term, $grade ) {
      $this->id = $id;
      $this->course_id = $course_id;
      $this->psid = $psid;
      $this->term = $term;
      $this->grade = $grade;
    }

    public function get_values() {
      return array( $this->id, $this->course_id, $this->psid, $this->term, $this->grade );
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

  }

?>