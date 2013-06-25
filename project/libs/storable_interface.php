<?php

  interface Storable {

    public function get_values();
    public static function get_properties();
    public static function load_record( $record );
    public static function load_from_file( $record );

  }

?>