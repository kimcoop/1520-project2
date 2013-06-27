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
      $filename = sprintf( "files/notes/%d:%s.txt", $this->psid, $this->dashed_timestamp );
      if ( file_exists($filename) )
        return file_get_contents( $filename );
      else
        return "file not found";
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

  public static function add_note( $psid, $contents ) {
    $dashed_timestamp = parent::get_dashed_timestamp();
    $note_timestamp = sprintf( "%d:%s", $psid, $dashed_timestamp );
    $note = new Note();
    $note->set_all( -1, $psid, $dashed_timestamp );

    $filename = sprintf( "files/notes/%s.txt", $note_timestamp );
    $append_success = file_put_contents( $filename, $contents, FILE_APPEND | LOCK_EX );

    if ( $append_success )
      $db_success = parent::insert( 'notes', $note );
    
    return $append_success && $db_success;
  }

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