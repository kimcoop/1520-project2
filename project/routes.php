<?php
  
  require_once('functions.php');
  session_start();

  if ( isset($_POST['signin_form_submit']) ) {

    if ( $_POST['forgot_password'] == 'on' && isset($_POST['user_id']) ) {

      if ( send_password( $_POST['user_id'] ) ) {
        display_notice( 'Please check your email for the password and then try again.', 'success' );
      } else {
        display_notice( 'User ID not recognized. Please try again.', 'error' );
      }

      header( 'Location: index.php' );

    } elseif ( signin( $_POST['user_id'], $_POST['password'] ) ) {

      if ( is_student() )
        header('Location: student.php');
      else
        header('Location: advisor.php');
      
    } else {
      display_notice( 'Error logging in.', 'error' );
      header( 'Location: index.php' );
    }

    exit();

  }

  if ( isset($_POST['log_advising_session_form_submit']) ) {
    log_advising_session( $_SESSION['viewing_psid'] );
    header('Location: advisor.php') ;
    exit();
  }

  if ( isset($_POST['advising_notes_form_submit']) ) {
    add_notes( $_SESSION['viewing_psid'], $_POST['note_content'] );
    header('Location: advisor.php?tab=advising_notes') ;
    exit();
  }

  if ( isset($_POST['display_notes_form_submit']) ) {
    set_should_show_notes( $_SESSION['viewing_psid'], $_POST['display_notes_form_submit'], true );
    header('Location: advisor.php?tab=advising_notes');
    exit();
  }

  if ( $_GET['action'] == 'logout' ) {

    session_destroy();
    header('Location: index.php') ;
    exit();

  } elseif ( isset($_GET['student_search_term']) ) {

    if ( find_user_by_psid_or_name( $_GET['student_search_term'] )) {
      $name = $_SESSION['student']['full_name'];
      display_notice( "Viewing report for $name.", 'success' );
      $user_id = $_SESSION['student']['user_id'];
      header( "Location: advisor.php?student_id=$user_id" );
      exit();
    } else {
      $search = $_GET['student_search_term'];
      display_notice( "User '$search' not found.", 'error' );
      header( 'Location: advisor.php' );
      exit();
    }

  } elseif ( $_GET['action'] == 'new_search' ) {

    clear_search();
    display_notice( "Advising session for $name ended.", 'success' );
    header( 'Location: advisor.php' );

  } else {
    $str = 'Route '. $_GET['action'] .' not recognized.';
    display_notice( $str, 'error' );
    header('Location: index.php') ;
    exit();

  }

?>