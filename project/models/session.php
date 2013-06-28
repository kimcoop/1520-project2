<?php

  class Session extends Model {
    public $id, $psid, $dashed_timestamp, $author_id;

    public function __construct() {
      parent::__construct();
    }

    public function set_all( $id, $psid, $timestamp, $author_id ) {
      $this->id = $id;
      $this->psid = $psid;
      $this->dashed_timestamp = $timestamp;
      $this->author_id = $author_id;
    }

    public function get_values() {
      return array( $this->psid, $this->dashed_timestamp, $this->author_id );
    }

    public function __toString() {
      return parent::make_date( $this->dashed_timestamp );
    }

    public function get_author_full_name() {
      $author = User::find_by_user_id( $this->author_id );
      if ( $author )
        return $author->get_full_name();
      else
        return "Author not found";
    }

    public function notes() {
      return Note::find_by_session_id( $this->id );
    }
  

  /*
  *
  * CLASS METHODS
  *
  */

  public static function log_advising_session( $psid ) {
    $dashed_timestamp = parent::get_dashed_timestamp();
    $session = new Session();
    $author_id = current_user()->get_user_id();
    $session->set_all( -1, $psid, $dashed_timestamp, $author_id );
    return parent::insert( 'sessions', $session );
  }


  public static function load_from_file( $line ) {
    $pieces = explode( ":", $line );
    $session = new Session();
    $session->set_all( -1, $pieces[0], $pieces[1], -1 ); // new entities have no ID or author_id
    return $session;
  }

  public static function get_properties() {
    return "psid, dashed_timestamp, author_id";
  }

  public static function load_record( $record ) {
    $session = new Session();
    $session->set_all( $record['id'], $record[ "psid" ], $record[ "dashed_timestamp" ], $record['author_id'] );
    return $session;
  }

  public static function find_all_by_psid( $psid ) {
    return parent::where_many( 'sessions', "psid='$psid'" );
  }
}

?>