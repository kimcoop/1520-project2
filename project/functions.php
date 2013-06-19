<?php

require_once('models/user.php');
require_once('models/course.php');
require_once('models/requirement.php');

date_default_timezone_set( 'America/New_York' );

define( "STUDENT_ACCESS_LEVEL", 0 );
define( "ADVISOR_ACCESS_LEVEL", 1 );
define( "USERS_FILE", 'files/users.txt' );
define( "COURSES_FILE", 'files/courses.txt' );
define( "REQS_FILE", 'files/reqs.txt' );
define( "SESSIONS_FILE", 'files/sessions.txt' );
define( "NOTES_FILE", 'files/notes.txt' );

define( "MAILER_SUBJECT", "Your AdvisorCloud Credentials" );
define( "MAILER_SENDER", "kac162@pitt.edu" );

function signin( $user_id, $password ) {
  $user = User::signin( $user_id, $password );

  if ( $user ) {
    $_SESSION[ 'user' ] = $user;
    $_SESSION[ 'viewing_psid' ] = $user->psid; // so we can use one variable for both roles. overwrite if/when advisor looks up student

    if ( is_student() )
      $_SESSION['user_courses'] = get_courses_for_user( $_SESSION['psid'], $_SESSION['all_courses'] );
  }
  // $expire = time() + 60 * 60 * 24 * 30;
  // setcookie( "user_id", $user_id, $expire ); // set cookie to what user passed in

  return $user;
}

function clear_search() {
  $name = $_SESSION['student']['full_name'];
  unset( $_SESSION['student'] );
  unset( $_SESSION['viewing_psid'] );
  unset( $_SESSION['should_show_notes'] );
}

function is_logged_in() {
  return isset( $_SESSION['user'] );
}

function is_student() {
  return $_SESSION['user']->get_access_level() == STUDENT_ACCESS_LEVEL;
}

function is_advisor() {
  return $_SESSION['user']->get_access_level() == ADVISOR_ACCESS_LEVEL;
}

function is_viewing_student() {
 return isset( $_SESSION['student'] ); 
}

function is_logging_session() {
 return isset( $_SESSION['student']['logging_session'] ); 
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

session_start();
$_SESSION['all_courses'] = populate_courses(); // populate onload for faster recall. TODO: make global not session

function populate_courses() {
  // read in and parse the COURSES_FILE to collect the list
  $courses = array();
  $file_handle = fopen( COURSES_FILE , "r" );
  
  while ( !feof($file_handle) ) {
    $line = fgets( $file_handle );
    $course = new Course( $line );
    $courses[] = $course;
  }

  fclose( $file_handle );
  return $courses;

}

function populate_reqs() {
  // read in and parse the REQS_FILE to collect the list
  $reqs = array();
  $file_handle = fopen( REQS_FILE , "r" );
  
  while ( !feof($file_handle) ) {
    $line = fgets( $file_handle );
    $req = new Requirement( $line );
    $reqs[] = $req;
  }

  fclose( $file_handle );
  return $reqs;

}


function get_courses_for_user( $psid, $courses ) {
  // collect which courses from the $courses array map to the passed-in people soft id
  $user_courses = array();

  foreach( $courses as $course ) {
    if ( $course->psid == $psid ) {
      $user_courses[] = $course;
    }
  }
  
  return $user_courses;
}

function get_courses_by_term( $psid, $courses ) {
  
  foreach( $courses as $course ) {
    if ( $course->psid == $psid ) {
      $courses_by_term[ $course->term ][] = $course;
    }
  }
  return $courses_by_term;
}

function get_courses_by_department( $psid, $courses ) {
  
  $courses_by_department = array();

  foreach( $courses as $course ) {
    if ( $course->psid == $psid ) {
      $courses_by_department[ $course->department ][] = $course;
    }
  }
  
  return $courses_by_department;
}

function get_requirements( $psid ) {
  // populate a list of graduation requirements for the given $psid
  $graduation_reqs = populate_reqs();
  return $graduation_reqs;
}


function get_user_course_record( $psid, $department, $number ) {

  foreach( $_SESSION['user_courses'] as $user_course ) {

    // ensure course grade is passing, course matches req department and number
    if ( $user_course->is_passing_grade() && $user_course->department == $department && $user_course->number == $number ) {
      return $user_course;
    }

  }

  return NULL;

}

function requirements_met( $psid, $requirement ) {
  
  $course_options = $requirement->course_options;

  // determine which satisfying courses (if any) for the given $requirement have been taken by the user
  // with the given $psid

  foreach( $course_options as $index => $req ) {

    $pieces = explode( ",", $req );
    $req_course_department = $pieces[0];
    $req_course_number = (int) $pieces[1];

    $user_course = get_user_course_record( $psid, $req_course_department, $req_course_number);
    // if the user has a course_record for this course, he has satisfied the $requirement
    if ( isset($user_course) ) {
      return true;
    }

  }
  // if we reach this point, we've exhausted the satisfying course options and therefore the user has not
  // satisfied this $requirement
  return false;
}


  /* 
  *

  ADVISOR FUNCTIONS 

  *
  */

  function find_user_by_psid_or_name( $search_term ) {
    $valid = false;
    if ( $search_term ) {

      $file_handle = fopen( USERS_FILE , "r");
      
      while ( !feof($file_handle) ) {
        $line = fgets( $file_handle );
        $pieces = explode( ":", $line );
        $psid = $pieces[2];
        $full_name = "$pieces[5] $pieces[4]"; // the advisor may search by people soft ID or first name - last name, so search for both matches
        if ( $psid == $search_term || $full_name == $search_term ) {

          $valid = true;
          $_SESSION['student']['user_id'] = $pieces[0];
          $_SESSION['student']['psid'] = $pieces[2];
          $_SESSION['student']['email'] = $pieces[3];
          $_SESSION['student']['last_name'] = $pieces[4];
          $_SESSION['student']['first_name'] = $pieces[5];
          $_SESSION['student']['full_name'] = $full_name;
          $_SESSION['student']['access_level'] = $pieces[6];

          $_SESSION['viewing_psid'] = $_SESSION['student']['psid']; // one variable to key off for both user roles (student & advisor)
          $_SESSION['user_courses'] = get_courses_for_user( $_SESSION['viewing_psid'], $_SESSION['all_courses'] );

          break;
        }
      }

      fclose( $file_handle );
      
    }

    return $valid;

  }

  function log_advising_session( $psid ) {

    $session_timestamp = get_formatted_timestamp();
    $log_timestamp = sprintf( "%d:%s", $psid, $session_timestamp );

    if ( file_put_contents( SESSIONS_FILE, "\n" . $log_timestamp, FILE_APPEND | LOCK_EX ) ) {
      $_SESSION['student']['logging_session'] = true;
      $_SESSION['student']['logging_session_timestamp'] = $log_timestamp;
      display_notice( 'Advising session logged.', 'success' );
    } else {
      display_notice( 'Error logging advising session.', 'error' );
    }

  }

  function get_formatted_timestamp() {
    $date = new DateTime();
    return $date->format('Y-m-d-H-i-s');
  }

  function add_notes( $psid, $notes ) {

    $timestamp = get_formatted_timestamp();
    $note_timestamp = sprintf( "%d:%s", $psid, $timestamp );
    $filename = sprintf( "files/notes/%s.txt", $note_timestamp );

    if ( file_put_contents( NOTES_FILE, "\n" . $note_timestamp , FILE_APPEND | LOCK_EX ) && file_put_contents( $filename, $notes, FILE_APPEND | LOCK_EX ) ) {
      display_notice( 'Advising session notes added.', 'success' );
    } else {
      display_notice( 'Error logging advising notes.', 'error' );
    }
  }


  function get_advising_notes( $psid ) {

    $advising_notes = array();
    $file_handle = fopen( NOTES_FILE, "r" );

    while ( !feof($file_handle) ) {
      $line = fgets( $file_handle );
      
      $pieces = explode( ":", $line );
      if ( $pieces[0] == $psid ) {
        $timestamp = clean( $pieces[1] );
        $advising_note = array( "timestamp" => $timestamp, "formatted_timestamp" => make_date( $timestamp) );
        $advising_notes[] = $advising_note;
      }

    }

    fclose( $file_handle );
    return $advising_notes;

  }

  function should_show_notes( $session_timestamp ) {
    if ( !isset( $_SESSION['should_show_notes'] ) || !isset( $_SESSION['should_show_notes'][ $session_timestamp ] ) )
      return false;
    else 
      return $_SESSION['should_show_notes'][ $session_timestamp ];
  }

  function set_should_show_notes( $psid, $session_timestamp, $should_show ) {
    // set this to display or hide particular advising session notes
    $_SESSION['should_show_notes'][ $session_timestamp ] = $should_show;
  }

  function get_notes( $psid, $timestamp ) {
    
    $filename = sprintf( "files/notes/%d:%s.txt", $psid, $timestamp );
    $notes = file_get_contents( $filename );

    return $notes;

  }

  function make_date( $timestamp ) {
    $format = 'l F jS, Y \a\t g:ia';

    $pieces = explode( "-", $timestamp );
    $year = $pieces[0];
    $month = $pieces[1];
    $day = $pieces[2];
    $hour = $pieces[3];
    $minute = $pieces[4];
    $second = $pieces[5];

    // return a nicely-formatted date timestamp for display
    return date( $format, mktime( $hour, $minute, $second, $month, $day, $year ));
  }

  function clean( $str ) {
    // ensure we don't have any weird characters from reading in text files
    return preg_replace( '/[^(\x20-\x7F)]*/','', $str );
  }

  function get_advising_sessions( $psid ) {
    
    $advising_sessions = array();
    $file_handle = fopen( SESSIONS_FILE , "r" );

    while ( !feof($file_handle) ) {
      $line = fgets( $file_handle );
      
      $pieces = explode( ":", $line );
      if ( $pieces[0] == $psid ) {
        $timestamp = clean( $pieces[1] );
        $advising_session = array( "timestamp" => $timestamp, "formatted_timestamp" => make_date( $timestamp) );
        $advising_sessions[] = $advising_session;
      }

    }

    fclose( $file_handle );
    return $advising_sessions;
  }


?>