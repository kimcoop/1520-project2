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
  }

?>