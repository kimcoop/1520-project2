<?php

  class RequirementCourse extends Model {

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
      return array( $this->requirement_id, $this->course_id );
    }

    public function __toString() {
      $course = $this->get_course();
      return "$course->department $course->course_number";
    }

    public function get_course() {
      if ( !$this->course )
        $this->course = Course::find_by_id( $this->course_id );
      return $this->course;
      
    }

    public function get_department() {
      return $this->get_course()->department;
    }

    public function get_course_number() {
      return $this->get_course()->course_number;
    }

    /*
    *
    * CLASS METHODS
    *
    */

    public static function get_properties() {
      return "requirement_id, course_id";
    }


    public static function load_record( $record ) {
      $req_course = new RequirementCourse();
      $req_course->set_all( $record['id'], $record['requirement_id'], $record['course_id'] );
      return $req_course;
    }

    public static function find_all_by_requirement_id( $req_id ) {
      return parent::where_many( 'requirement_courses', "requirement_id='$req_id'" );
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

        if ( !$course ) {
          // a course option that satisfies this requirement is not yet in the db. insert it
          $course = new Course();
          $course->department = $course_department;
          $course->course_number = $course_number;
          $course->id = parent::insert( 'courses', $course ); // returns ID
        }

        $req_course->course_id = $course->id;
        parent::insert( 'requirement_courses', $req_course );
      }
      
    }

  }

?>