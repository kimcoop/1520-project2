<?php

  class Note extends Model {
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
      return "" . $date;
    }

    public function get_contents() {
      $filename = sprintf( "files/notes/%d:%s.txt", $psid, $timestamp );
      $notes = file_get_contents( $filename );
      return $notes;
    }
  
    public function should_show() {
      if ( !isset( $_SESSION['should_show_notes'] ) || !isset( $_SESSION['should_show_notes'][ $this->id ] ) )
        return false;
      else 
        return $_SESSION['should_show_notes'][ $this->id ];
    }

  /*
  *
  * CLASS METHODS
  *
  */

  public static function get_properties() {
    return "psid, dashed_timestamp";
  }


  public static function load_from_file( $line ) {
    $pieces = explode( ":", $line );
    $note = new Note();
    $note->set_all( -1, $pieces[0], $pieces[1] ); // new entities have no ID
    return $note;
  }

  public static function set_should_show_notes( $note_id, $should_show ) {
    // set this to display or hide particular advising session notes
    $_SESSION['should_show_notes'][ $note_id ] = $should_show;
  }

  public static function load_record( $record ) {
    $note = new Note();
    $note->set_all( $record['id'], $record[ "psid" ], $record[ "dashed_timestamp" ] );
    return $note;
  }

  public static function find_all_by_psid( $psid ) {
    return parent::where_many( 'notes', "psid='$psid'" );
  }
}

?>