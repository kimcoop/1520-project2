<?php

session_start();
include 'models/user_course.php';
include 'models/requirement_course.php';

function __autoload($class) {
  $file = 'models/' . $class . '.php';
  if ( file_exists( $file ))
    include $file;
  elseif ( file_exists( 'libs/'. $class . '.php' ))
    include 'libs/'. $class . '.php';
}

date_default_timezone_set( 'America/New_York' );

define( "STUDENT_ACCESS_LEVEL", 0 );
define( "ADVISOR_ACCESS_LEVEL", 1 );

define( "MAILER_SUBJECT", "Your AdvisorCloud Credentials" );
define( "MAILER_SENDER", "kac162@pitt.edu" );

function clear_search() {
  $name = $_SESSION['student']['full_name'];
  unset( $_SESSION['student'] );
  unset( $_SESSION['viewing_psid'] );
  unset( $_SESSION['should_show_notes'] );
}

function current_user() {
  $user = $_SESSION['user'];
  return $user;
}

function is_logged_in() {
  return isset( $_SESSION['user'] );
}

function is_student() {
  return current_user()->get_access_level() == STUDENT_ACCESS_LEVEL;
}

function is_advisor() {
  return current_user()->get_access_level() == ADVISOR_ACCESS_LEVEL;
}

function is_viewing_student() {
 return isset( $_SESSION['student'] ); 
}

function is_logging_session() {
 return isset( $_SESSION['logging_session'] ); 
}

function should_show_notice() {
  return isset( $_SESSION['notice'] );
}

function get_root_url() {
  // used in the nav bar, to correctly link the brand href
  if ( is_student() ) 
    return 'student.php'; 
  else
    return 'advisor.php';
}

  /* 
  *

  UTILITY FUNCTIONS 

  *
  */

  function display_notice( $message, $type ) {
    // used to display a message onscreen if there is a notice for the user (from a function)
    $_SESSION['notice']['message'] = $message;
    $_SESSION['notice']['type'] = $type;
  }

  function is_active_tab( $tab_id ) {
    // used to set which tab is actively showing onscreen
    if ( $tab_id=='courses' && empty($_GET['tab']) )
      return true;
    else
      return $_GET['tab'] == $tab_id;
  }

  /* 
  *

  STUDENT FUNCTIONS 

  *
  */


  /* 
  *

  ADVISOR FUNCTIONS 

  *
  */


  function set_viewing_student( $student_user ) {
    $_SESSION['student'] = $student_user;
    $_SESSION['viewing_psid'] = $student_user->get_psid();
  }

  function log_advising_session( $psid ) {
    // TODO - insert into db
    /*
    $session_timestamp = get_formatted_timestamp();
    $log_timestamp = sprintf( "%d:%s", $psid, $session_timestamp );

    if ( file_put_contents( SESSIONS_FILE, "\n" . $log_timestamp, FILE_APPEND | LOCK_EX ) ) {
      $_SESSION['logging_session'] = true;
      $_SESSION['logging_session_timestamp'] = $log_timestamp;
      display_notice( 'Advising session logged.', 'success' );
    } else {
      display_notice( 'Error logging advising session.', 'error' );
    }*/

  }

  function add_notes( $psid, $notes ) {
    // TODO OOOO
    /*
    $timestamp = get_formatted_timestamp();
    $note_timestamp = sprintf( "%d:%s", $psid, $timestamp );
    $filename = sprintf( "files/notes/%s.txt", $note_timestamp );

    if ( file_put_contents( NOTES_FILE, "\n" . $note_timestamp , FILE_APPEND | LOCK_EX ) && file_put_contents( $filename, $notes, FILE_APPEND | LOCK_EX ) ) {
      display_notice( 'Advising session notes added.', 'success' );
    } else {
      display_notice( 'Error logging advising notes.', 'error' );
    }
    */
  }

?>