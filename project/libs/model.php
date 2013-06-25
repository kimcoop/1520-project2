<?php

  class Model {

    function __construct() {
      // $this->db = DB::instance();
    }

    public static function find_all( $klass ) {
      $table = strtolower( $klass );
      $objects = DB::select_all( $table );
    }

  }


?>