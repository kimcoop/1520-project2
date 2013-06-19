<?php

  class DAO_Base {
    private $db;
    private $table = NULL;
    private $db_host;
    private $db_name;
    private $db_user;
    private $db_password;

    function __construct( $db_host, $db_name, $db_user, $db_password ) {
      $this->db_host=$db_host;
      $this->db_name=$db_name;
      $this->db_user=$db_user;
      $this->db_password=$db_password;
    }

    function __construct( $db, $table ) {
      $this->db = $db;
      $this->table = $table;
    }

    function db_connect() {
      $db = new mysqli( $db_host, $db_user, $db_password, $db_name );
      if ( $db->connect_errno > 0 )
        die( 'Unable to connect to database [' . $db->connect_error . ']' );
      else 
        return $db;
    }

    function record_exists( $record_identifier, $field ) {
      $db = $this->db_connect();
      // return $result[ "COUNT(*)" ] > 0;

      // TODO

    }

    function execute( $sql ) {
      // execute SQL commands
      // TODO
    }

    function next_row( $result ) {
      $row = NULL;
      return $row;

      // TODO
    }

    function check_errors( $sql ) {
      // TODO
    }

    function get_one( ) {
       $sql = "SELECT * FROM mydbname WHERE (id = ".$valueObject->getColor().") "; 

        // if ($this->singleQuery(&$conn, $sql, &$valueObject))
        //      return true;
        // else
        //      return false;

      // TODO


    }

    function save() {
      // if record isn't in database,
      // insert it.
      // else
      // update it.
      
      // TODO
    }

    function insert() {
      /*
       $sql = "INSERT INTO mydbname ( id, integer) VALUES (".$valueObject->getColor().", ";
          $sql = $sql."'".$valueObject->getString()."') ";
          $result = $this->databaseUpdate(&$conn, $sql);


          return true;
      */
    }

    function update() {
      /*
        $sql = "UPDATE mydbname SET integer = '".$valueObject->getString()."'";
          $sql = $sql." WHERE (id = ".$valueObject->getColor().") ";
          $result = $this->databaseUpdate(&$conn, $sql);

          if ($result != 1) {
               //print "PrimaryKey Error when updating DB!";
               return false;
          }

          return true;
      */
    }

    function delete() {
      /*
      $sql = "DELETE FROM mydbname WHERE (id = ".$valueObject->getColor().") ";
          $result = $this->databaseUpdate(&$conn, $sql);

          if ($result != 1) {
               //print "PrimaryKey Error when updating DB!";
               return false;
          }
          return true;
      */
    }



  }
?>