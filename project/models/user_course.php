<?php

  class UserCourse extends Model implements Storable {
    /*
    *
    * CLASS METHODS
    *
    */


    public static function load_record( $record ) {
      $course = new Course();
      
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

  }

?>