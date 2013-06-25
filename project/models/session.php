<?php

  class Session extends Model {
    // $advising_note = array( "timestamp" => $timestamp, "formatted_timestamp" => make_date( $timestamp) );
    public $psid, $timestamp;

    public function __construct() {
      parent::__construct();
    }

    public function get_formatted_timestamp() {
      return make_date( $this->timestamp );
    }

    function make_date( $timestamp ) {
      $format = 'l F jS, Y \a\t g:ia';

      $pieces = explode( "-", $timestamp );
      $year = $pieces[0];
      $month = $pieces[1];
      $day = $pieces[2];
      $hour = $pieces[3];
      $minute = $pieces[4];
      $second = $pieces[5];

      // return a nicely-formatted date timestamp for display
      return date( $format, mktime( $hour, $minute, $second, $month, $day, $year ));
    }


  }

?>