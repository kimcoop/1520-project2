<?php

  class Model {

    function __construct() {
      // TODO - move utilty functions into file and include it here
    }

    public static function grade_points( $grade ) {
      switch ( $grade ) {
        case "A+": return 4;
        case "A": return 4;
        case "A-": return 3.75;
        case "B+": return 3.25;
        case "B": return 3;
        case "B-": return 2.75;
        case "C+": return 2.25;
        case "C": return 2;
        case "C-": return 1.75;
        case "D+": return 1.25;
        case "D": return 1;
        case "D-": return 0.75;
        case "F": return 0;
        default:
          return 0;
      }
    }

    public static function make_date( $timestamp ) {

      $format = 'l F jS, Y \a\t g:ia';
      $pieces = explode( "-", $timestamp );
      $year = (int) $pieces[0];
      $month = (int) $pieces[1];
      $day = (int) $pieces[2];
      $hour = (int) $pieces[3];
      $minute = (int) $pieces[4];
      $second = (int) $pieces[5];

      // return a nicely-formatted date timestamp for display
      return date( $format, mktime( $hour, $minute, $second, $month, $day, $year ));
    }

    public static function get_dashed_timestamp() {
      $date = new DateTime();
      return $date->format('Y-m-d-H-i-s');
    }

    public static function update( $table, $entity, $updates ) {
      $pk = self::pk_for_table( $table );
      $where = "$pk='" . $entity->get( $pk ) . "'";
      return DB::update( $table, $updates, $where );
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
          return "RequirementCourse";
        case "notes":
          return "Note";
        case "sessions":
          return "Session";
        default:
          return "User";
      }
    }

    public static function pk_for_table( $table ) {
      // determine the primary key for table to be used in UPDATE statement
      // btw this is SUPER ugly. find a better way
      switch ( $table ) {
        case "users":
          return "psid";
        default:
          return "id";
      } 
    }

    public static function where_one( $table, $conditions ) {
      $klass = self::class_for_table( $table );
      $result = DB::where( $table, $conditions, 'one', $klass );
      return $result;
    }

    public static function where_many( $table, $conditions ) {
      $klass = self::class_for_table( $table );
      $collection =  DB::where( $table, $conditions, 'many', $klass );
      return $collection;
    }

    public static function find_by_id( $table, $id ) {
      $klass = self::class_for_table( $table );
      $conditions = "id='$id'";
      return DB::where( $table, $conditions, 'one', $klass );
    }

    public static function find_all( $table ) {
      $klass = self::class_for_table( $table );
      return DB::select_all( $table, $klass );
    }

    public static function delete_where( $table, $conditions ) {
      return DB::delete_where( $table, $conditions );
    }

  }


?>