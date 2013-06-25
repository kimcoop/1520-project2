<?php

  class RequirementCourse extends Model implements Storable {

    public $id, $requirement_id, $course_id;
    // belongs_to
    public $requirement;
    public $course;

    public function set_all( $id, $requirement_id, $course_id ) {
      $this->id = $id;
      $this->requirement_id = $requirement_id;
      $this->course_id = $course_id;
    }

    public function get_values() {
      return array( $this->id, $this->requirement_id, $this->course_id );
    }

    /*
    *
    * CLASS METHODS
    *


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


      // $requirement->course_options = explode( "|", $pieces[1] );
      return $requirement;
    }

    */

    public static function get_properties() {
      return "id, requirement_id, course_id";
    }


    public static function load_record( $record ) {
      $req_course = new RequirementCourse();
      $req_course->set_all( $record['id'], $record['requirement_id'], $record['course_id'] );
    }

    public static function load_from_file( $line ) {
      $pieces = explode( ":", $line );

      // get requirement
      $title = $pieces[0];
      $requirement = Requirement::find_by_title( $title );
      $req_id = $requirement->id;

      // split requirement courses and create (iterate)
      $course_options = explode( "|", trim( $pieces[1] ) );

      foreach( $course_options as $course_option ) {
        $req_course = new RequirementCourse();
        $req_course->requirement_id = $req_id;
        $course_pieces = explode( ",", $course_option );
        $course_department = $course_pieces[ 0 ];
        $course_number = (int) $course_pieces[ 1 ];
        $course = Course::where_one( "department='$course_department' AND course_number='$course_number'" );
        echo $course;
        $req_course->course_id = $course->id;
      }


      return $req_course;
    }

  }

?>