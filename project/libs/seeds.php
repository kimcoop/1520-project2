<?php


  include( 'project/libs/db.php' );
  include( 'project/libs/model.php' );

  include( 'project/models/user.php' );
  include( 'project/models/course.php' );
  include( 'project/models/requirement.php' );
  
  define( "SAMPLE_FILE_ROOT", 'project/files/sample_' );

  function clean() {
    echo "Cleaning out notes directory<br/>";
    $notes = glob( 'project/files/notes/*' ); // get all file names
    foreach( $notes as $note ){ // iterate files
      if ( is_file( $note ) )
        unlink( $note ); // delete file
    }

    echo "Resetting tables in database<br/>";

    DB::run( "DROP TABLE IF EXISTS users" );
    DB::run( "DROP TABLE IF EXISTS courses" );
    DB::run( "DROP TABLE IF EXISTS user_courses" );
    DB::run( "DROP TABLE IF EXISTS requirements" );
    DB::run( "DROP TABLE IF EXISTS requirement_courses" );
    DB::run( "DROP TABLE IF EXISTS notes" );
    DB::run( "DROP TABLE IF EXISTS sessions" );
    
  }

  function create_tables() {

    $users_sql = "CREATE TABLE users(
      psid int PRIMARY KEY NOT NULL,
      access_level int(1) NOT NULL,
      user_id varchar(255) NOT NULL,
      email varchar(255) NOT NULL,
      first_name varchar(255) NOT NULL,
      last_name varchar(255) NOT NULL,
      password varchar(255) NOT NULL,
      secret_question varchar(255),
      secret_answer varchar(255)
      )";

    $courses_sql = "CREATE TABLE courses(
      id int PRIMARY KEY NOT NULL AUTO_INCREMENT,
      department varchar(255) NOT NULL,
      course_number int NOT NULL
      )";
  
    $user_courses_sql = "CREATE TABLE user_courses(
      id int PRIMARY KEY NOT NULL AUTO_INCREMENT,
      course_id int NOT NULL,
      psid int NOT NULL,
      term varchar(255) NOT NULL,
      grade varchar(5) NOT NULL
      )";

    $requirements_sql = "CREATE TABLE requirements(
      id int PRIMARY KEY NOT NULL AUTO_INCREMENT,
      title varchar(255) NOT NULL,
      category varchar(255)
      )";
    
    $requirement_courses_sql = "CREATE TABLE requirement_courses(
      id int PRIMARY KEY NOT NULL AUTO_INCREMENT,
      requirement_id int NOT NULL,
      course_id int NOT NULL
      )";

    $notes_sql = "CREATE TABLE notes(
      id int PRIMARY KEY NOT NULL AUTO_INCREMENT,
      psid varchar(255) NOT NULL,
      dashed_timestamp varchar(255) NOT NULL
      )";
    
    $sessions_sql = "CREATE TABLE sessions(
      id int PRIMARY KEY NOT NULL AUTO_INCREMENT,
      psid varchar(255) NOT NULL,
      dashed_timestamp varchar(255) NOT NULL
      )";
    
    DB::run( $users_sql );
    DB::run( $courses_sql );
    DB::run( $user_courses_sql );
    DB::run( $requirements_sql );
    DB::run( $requirement_courses_sql );
    DB::run( $notes_sql );
    DB::run( $sessions_sql );
    
  }

  function populate_table( $table ) {
    $file = SAMPLE_FILE_ROOT . $table . ".txt";
    if ( !file_exists( $file )) 
      return;
    echo "<li>$table</li>";
    $objects = file( $file );
    foreach( $objects as $line ) {
      if ( $table == 'users' )
        $object = User::load_from_file( $line );
      elseif ( $table == 'courses' )
        $object = Course::load_from_file( $line );
      elseif ( $table == 'requirements' )
        $object = Requirement::load_from_file( $line );
      DB::insert( $table, $object );
    }
  }

  function populate_tables() {

    echo "<strong>Populating tables from files</strong><br/>";
    echo "<ul>";
    populate_table( "users" );
    populate_table( "courses" );
    populate_table( "requirements" );
    echo "</ul>";
  }

  clean();
  create_tables();
  populate_tables();


?>