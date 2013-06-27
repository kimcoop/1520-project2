<?php

  class UserCourse extends Model {

    public $id, $course_id, $psid, $department, $course_number, $term, $grade;
    public $user;

    public function set_all( $id, $course_id, $psid, $department, $course_number, $term, $grade ) {
      $this->id = $id;
      $this->course_id = $course_id;
      $this->psid = $psid;
      $this->department = $department;
      $this->course_number = $course_number;
      $this->term = $term;
      $this->grade = $grade;
    }

    public function is_passing_grade() {
      $passing_grades = array("A+", "A", "A-", "B+", "B", "B-", "C+", "C");
      return in_array( $this->grade, $passing_grades ); 
    }

    public function get_values() {
      return array( $this->course_id, $this->psid, $this->department, $this->course_number, $this->term, $this->grade );
    }

    public function course() {
      return Course::find_by_id( $this->course_id );
    }

    public function __toString() {
      return "$this->department $this->course_number $this->grade";
    }

    public function user() {
      if ( !$this->user )
        $this->user = User::find_by_psid( $this->psid );
      return $this->user;
    }


    /*
    *
    * CLASS METHODS
    *
    */

    public static function find_all_by_course_id( $course_id ) {
      return parent::where_many( 'user_courses', "course_id='$course_id'" );
    }

    public static function get_properties() {
      return "course_id, psid, department, course_number, term, grade";
    }

    public static function load_record( $record ) {
      $user_course = new UserCourse();
      $user_course->set_all( $record['id'], $record['course_id'], $record['psid'], $record['department'], $record['course_number'], $record['term'], $record['grade'] );
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
        
      // text files will not include the ID, so default to -1
      $user_course->set_all( -1, $course->id, $pieces[3], $department, $course_number, $pieces[2], trim( $pieces[4] ));

      return $user_course;
    }

    public static function where_one( $conditions ) {
      return parent::where_one( 'user_courses', $conditions );
    }

    public static function where_many( $conditions ) {
     return parent::where_many( 'user_courses', $conditions ); 
    }

    public static function find_all_by_psid( $psid ) {
      return parent::where_many( 'user_courses', "psid='$psid'" );
    }

    public static function find_by( $grouping, $psid ) {
      $all = self::find_all_by_psid( $psid );
      if ( !$all )
        return;
      $courses = array();
      foreach( $all as $course ) {
        if ( $course->psid == $psid ) {
          if ( $grouping == 'term' )
            $courses[ $course->term ][] = $course;
          else
            $courses[ $course->department ][] = $course;
        }
      }
      return $courses;
    }

  }

?>