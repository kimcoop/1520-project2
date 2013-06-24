<?php


  include( 'project/models/user.php' );
  include( 'project/models/user_factory.php' );
  
  define( "USERS_FILE", 'project/files/sample_users.txt' );
  define( "COURSES_FILE", 'project/files/sample_courses.txt' );
  define( "REQS_FILE", 'project/files/sample_reqs.txt' );
  
  function create_connection() {
    $db = new mysqli( 'localhost', 'root', "root", "advisor-cloud" );
    if ( $db->connect_error )
      die( "Could not connect to db " . $db->connect_error );    
    else
      return $db;
  }

  function clean( &$db ) {
    echo "Cleaning out notes directory<br/>";
    $notes = glob( 'project/files/notes/*' ); // get all file names
    foreach( $notes as $note ){ // iterate files
      if ( is_file( $note ) )
        unlink( $note ); // delete file
    }

    echo "Resetting tables in database<br/>";

    $db->query( "DROP TABLE users" );
    $db->query( "DROP TABLE courses" );
    $db->query( "DROP TABLE user_courses" );
    $db->query( "DROP TABLE requirements" );
    $db->query( "DROP TABLE requirement_courses" );
    $db->query( "DROP TABLE notes" );
    $db->query( "DROP TABLE sessions" );
    
  }

  function create_tables( &$db ) {

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
      course_number int NOT NULL,
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
      psid varchar NOT NULL,
      dashed_timestamp varchar NOT NULL
      )";
    
    $sessions_sql = "CREATE TABLE sessions(
      id int PRIMARY KEY NOT NULL AUTO_INCREMENT,
      psid varchar NOT NULL,
      dashed_timestamp varchar NOT NULL
      )";
    
    $db->query( $users_sql );
    $db->query( $courses_sql );
    $db->query( $user_courses_sql );
    $db->query( $requirements_sql );
    $db->query( $requirement_courses_sql );
    $db->query( $notes_sql );
    $db->query( $sessions_sql );
    
  }

  function populate_tables( &$db ) {

    echo "Populating tables from files<br/>";

    // sample_users
    $users_array = file( USERS_FILE );
    foreach( $users_array as $line ) {
      $user = UserFactory::create_from_file( $line );
      // DB::insert( $user ); // TODO
    }
    // sample_courses

    // sample_reqs
  }

  $db = create_connection();
  clean( $db );
  create_tables( $db );
  populate_tables( $db );


?>