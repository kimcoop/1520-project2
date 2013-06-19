<?php
  class DB {
    private $db_host;
    private $db_name;
    private $db_user;
    private $db_password;

    function __construct( $db_host, $db_name, $db_user, $db_password;
      $this->db_host=$db_host;
      $this->db_name=$db_name;
      $this->db_user=$db_user;
      $this->db_password=$db_password;
    }

    function open_connection() {
      $db = new mysqli( $db_host, $db_user, $db_password, $db_name );
      if ( $db->connect_errno > 0 )
        die( 'Unable to connect to database [' . $db->connect_error . ']' );
      else return db;
    }
    
  }
?>