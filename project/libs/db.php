<?php
  abstract class DB {
    private static $host='localhost', $name='advisor-cloud', $user='root', $password='root';
    public static $db;
/*
    function __construct( $host, $name, $user, $password ) {
      $this->host=$host;
      $this->name=$name;
      $this->user=$user;
      $this->password=$password;

      $db = new mysqli( $host, $user, $password, $name );
      if ( $db->connect_errno > 0 )
        die( 'Unable to connect to database [' . $db->connect_error . ']' );
      else 
        return $db;
    }
    */

    public function instance() {
      if ( self::$db == NULL ) 
        // self::$db = new mysqli( $self::host, $self::user, $self::password, $self::name );
        self::$db = new mysqli( 'localhost', 'root', 'root', 'advisor-cloud' );
      return self::$db;
    }

    public function run( $sql ) {
      $result = self::instance()->query( $sql );
      if ( !$result ) 
        die( "<br><br><strong class='text-error'>Invalid SQL</strong><br> " . self::instance()->error . "<br><br>( $sql )");
    }

    public function insert( $table, $entity ) {
      echo "$entity<br/>"; // TODO - remove
      $klass = get_class( $entity );
      $keys = $klass::get_properties();
      $values_array = $entity->get_values();
      $values = "";
      foreach ( $values_array as $index => $value ) {
        $values .= "'" . addslashes( $value ) . "'";
        if ( $index < count( $values_array ) -1 )
          $values .= ", ";
      }

      $sql = "INSERT INTO $table( $keys ) VALUES( $values )";
      self::run( $sql );
    }

    public function select_all( $table ) {
      $sql = "SELECT * FROM $table";
      return self::run( $sql );
    }
    /*

    public function update( $table, $update_data, $identifier ) {
      $updates = array();
      foreach( $update_data as $key => $value )
        $updates[] = "$key = '$value'";

      $updates_sql = implode( ',' $updates );
      $sql = "UPDATE $table SET $updates_sql WHERE $identifer";
      self::run( $sql );
    }

*/
    
  }
?>