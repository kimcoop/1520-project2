<?php

  class Model {

    function __construct() {
      // $this->db = DB::instance();
    }

    public static function insert( $table, $entity ) {
      return DB::insert( $table, $entity );
    }

    public static function class_for_table( $table ) {
      // this could be optimized. hard-coding strings is a ghetto hack ><
      switch ( $table ) {
        case "users":
          return "User";
        case "courses":
          return "Course";
        case "requirements":
          return "Requirement";
        case "user_courses":
          return "UserCourse";
        case "requirement_courses":
          return "RequirementCourses";
        default:
          return "User";
      }
    }

    public static function where_one( $table, $conditions ) {
      $klass = self::class_for_table( $table );
      return DB::where( $table, $conditions, 'one', $klass );
    }

    public static function where_many( $table, $conditions ) {
      $klass = self::class_for_table( $table );
      $collection =  DB::where( $table, $conditions, 'many', $klass );
      return $collection;
    }

    public static function find_all( $table ) {
      $collection = DB::select_all( $table );
      // TODO - parse to object format
      return $collection;
    }

  }


?>