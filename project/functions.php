<?php

session_start();

function __autoload($class) {
  $class = strtolower($class);
  if ( $class == 'usercourse' ) 
    $class = 'user_course';
  elseif ( $class == 'requirementcourse' ) 
    $class = 'requirement_course';
  
  $file = 'models/' . $class . '.php';
  if ( file_exists( $file ))
    include $file;
  elseif ( file_exists( 'libs/'. $class . '.php' ))
    include 'libs/'. $class . '.php';
}

date_default_timezone_set( 'America/New_York' );

define( "MAILER_SUBJECT", "Your AdvisorCloud Credentials" );
define( "MAILER_SENDER", "kac162@pitt.edu" );


function was_posted( $name ) {
  return isset( $_POST[$name] );
}

function get_current_url() {
  return $_SERVER[ "REQUEST_URI" ];
}

function is_active_nav( $nav ) {
  $url = explode( "/", get_current_url() );
  $slug = array_pop( $url );
  if ( "$nav.php" == $slug )
    return true;
  else {
    if (( $slug == "advisor.php" || $slug == "student.php" ) && ( $nav == "home" ))
      return true;
  }
  return false;
}

function clear_browsing_session() {
  unset( $_SESSION['viewing_psid'] );
  unset( $_SESSION['viewing_user_id'] );
  unset( $_SESSION['should_show_notes'] );
  current_user()->set_is_logging_session( FALSE );
}

function current_user() {
  return $_SESSION['user'];
}

function is_logged_in() {
  return isset( $_SESSION['user'] );
}

function is_student() {
  return current_user()->is_student();
}

function is_advisor() { // Admins have advisor privileges and more
  return current_user()->is_advisor() || current_user()->is_admin();
}

function is_admin() {
  return current_user()->is_admin();
}

// function current_student() {
//   if ( is_viewing_student() )
//     return $_GET['user_id'];
//   else
//     return current_user()->get_user_id(); // student viewing his own profile
// }

function is_viewing_student() {
 return isset( $_GET['user_id'] ); 
}

function is_viewing_course() {
  return isset( $_GET['course_id'] );
}

function should_show_notice() {
  return isset( $_SESSION['notice'] );
}

function get_root_url() {
  // used in the nav bar, to correctly link the brand href
  if ( is_student() ) 
    return 'student_dashboard.php'; 
  else
    return 'advisor.php';
}

function sort_by_last_name( $a, $b ) {
  if ( $a->get_last_name() == $b->get_last_name() )
    return 0;
  else
    return ( $a->get_last_name() < $b->get_last_name() ? -1 : 1 );
}

function sort_by_term( $a, $b ) {
  if ( $a->term == $b->term )
    return 0;
  else
    return ( $a->term < $b->term ? -1 : 1 );
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
    $_SESSION['viewing_psid'] = $student_user->get_psid();
    $_SESSION['viewing_user_id'] = $student_user->get_user_id();
  }


?>