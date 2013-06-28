<?php

  abstract class DB {
    public static $db;

    public function instance() {
      if ( self::$db == NULL ) 
        // self::$db = new mysqli( $self::host, $self::user, $self::password, $self::name );
        // self::$db = new mysqli( 'localhost', 'root', 'root', 'advisor-cloud' );
        self::$db = new mysqli( 'localhost', 'CooperriderK', 'mac.limp', 'CooperriderK' );
      return self::$db;
    }

    public function run( $sql ) {
      $result = self::instance()->query( $sql );
      if ( !$result ) 
        die( "<br><br><strong class='text-error'>Invalid SQL</strong><br> " . self::instance()->error . "<br><br>( $sql )");
      else
        return $result;
    }

    public function insert( $table, $entity ) {
      $klass = get_class( $entity );
      $keys = $klass::get_properties();
      $values_array = $entity->get_values();
      $values = "";
      foreach ( $values_array as $index => $value ) {
        $values .= "'" . addslashes( $value ) . "'";
        if ( $index < count( $values_array ) -1 )
          $values .= ", ";
      }

      $sql = "INSERT IGNORE INTO $table( $keys ) VALUES( $values )";
      $result = self::run( $sql );
      
      if ( $result && $table != 'users' ) // users PK is not auto-increment, so insert_id fails
        return self::$db->insert_id; // return ID of this (last) insertion
      elseif ( $result && $table == 'users' )
        return true;
      else 
        return NULL;
    }

    public function update( $table, $updates, $conditions ) {
      $sql = "UPDATE $table SET $updates WHERE $conditions";
      return self::run( $sql );
    }

    public function select_all( $table, $klass ) {
      $sql = "SELECT * FROM $table";
      $result = self::run( $sql );

      if ( $result->num_rows == 0 )
        return NULL;

      $return_object = self::parse_array_to_objects( $result, $klass );
      $result->free();
      return $return_object;

    }

    public function where( $table, $conditions, $one_or_many, $klass ) {

      $sql = "SELECT * FROM $table WHERE $conditions";
      $result = self::run( $sql );
      $return_object = NULL;
      
      if ( $result->num_rows == 0 )
        return NULL;

      if ( $one_or_many == 'one' )
        $return_object = $klass::load_record( $result->fetch_assoc() );
      else
        $return_object = self::parse_array_to_objects( $result, $klass );

      $result->free();
      return $return_object;

    }

    public function delete_where( $table, $conditions ) {
      $sql = "DELETE FROM $table WHERE $conditions";
      return self::run( $sql );
    }

    public function parse_array_to_objects( $result, $klass ) {
      $collection = array();
      while ( $row = $result->fetch_assoc() ) {
        $object = $klass::load_record( $row );
        $collection[] = $object;
      }
      return $collection;
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