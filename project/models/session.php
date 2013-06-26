<?php

  class Session extends Model {
    public $id, $psid, $dashed_timestamp;

    public function __construct() {
      parent::__construct();
    }

    public function set_all( $id, $psid, $timestamp ) {
      $this->id = $id;
      $this->psid = $psid;
      $this->dashed_timestamp = $timestamp;
    }

    public function get_values() {
      return array( $this->psid, $this->dashed_timestamp );
    }

    public function __toString() {
      $date = parent::make_date( $this->dashed_timestamp );
      return $date;
    }
  

  /*
  *
  * CLASS METHODS
  *
  */

  public static function load_from_file( $line ) {
    $pieces = explode( ":", $line );
    $session = new Session();
    $session->set_all( -1, $pieces[0], $pieces[1] ); // new entities have no ID
    return $session;
  }

  public static function get_properties() {
    return "psid, dashed_timestamp";
  }

  public static function load_record( $record ) {
    $session = new Session();
    $session->set_all( $record['id'], $record[ "psid" ], $record[ "timestamp" ] );
    return $session;
  }

  public static function find_all_by_psid( $psid ) {
    return parent::where_many( 'sessions', "psid='$psid'" );
  }
}

?>