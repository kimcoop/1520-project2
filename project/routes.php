<?php
  
  require_once('functions.php'); // includes session_start()

  if ( isset($_POST['signin_form_submit']) ) {

    if ( $_POST['forgot_password'] == 'on' && isset($_POST['user_id']) ) {

      if ( send_password( $_POST['user_id'] ) ) {
        display_notice( 'Please check your email for the password and then try again.', 'success' );
      } else {
        display_notice( 'User ID not recognized. Please try again.', 'error' );
      }

      header( 'Location: index.php' );
      exit();

    } 

    $user = User::signin( $_POST['user_id'], $_POST['password'] );
        
    if ( is_logged_in() ) {
      $url = get_root_url();
      header( "Location: $url" );
    } else {
      display_notice( 'Error logging in.', 'error' );
      header( 'Location: index.php' );
    }

    exit();

  }



  if ( isset( $_POST['change_password_form_submit'] ) ) {
    if ( current_user()->change_password( $_POST['old_password'], $_POST['new_password'], $_POST['new_password_confirm'] ))
      display_notice( 'Password changed.', 'success' );
    else
      display_notice( '<strong>Error changing password.</strong> Please ensure you\'ve properly entered your current password and that new passwords match.', 'error' );
    header( "Location: settings.php" );
    exit();

  }

  if ( isset( $_POST['secret_question_form_submit'] ) ) {
    if ( current_user()->set_secret_question( $_POST['secret_question'], $_POST['secret_answer'] ))
      display_notice( 'Secret question saved.', 'success' );
    else
      display_notice( 'Error saving secret question.', 'error' );
    header( "Location: settings.php" );
    exit();

  }

  if ( isset($_POST['log_advising_session_form_submit']) ) {
    if ( Session::log_advising_session( $_SESSION['viewing_psid'] )) {
      $_SESSION['logging_session'] = true;
      display_notice( 'Advising session logged.', 'success' );
    } else {
      display_notice( 'Error logging advising session.', 'error' );
    }
    header('Location: advisor.php');
    exit();
  }

  if ( isset($_POST['advising_notes_form_submit']) ) {
    if ( Note::add_note( $_SESSION['viewing_psid'], $_POST['note_content'] )) 
      display_notice( 'Note saved.', 'success' );
    else
      display_notice( 'Error saving note.', 'error' );
    header('Location: advisor.php?tab=advising_notes') ;
    exit();
  }

  if ( isset($_POST['display_notes_form_submit']) ) {
    Note::set_should_show_notes( $_POST['display_notes_form_submit'], true );
    header('Location: advisor.php?tab=advising_notes');
    exit();
  }

  if ( $_GET['action'] == 'logout' ) {

    session_destroy();
    header('Location: index.php') ;
    exit();

  } elseif ( isset($_GET['student_search_term']) ) {

    if ( $user = User::find_user_by_psid_or_name( $_GET['student_search_term'] )) {
      set_viewing_student( $user );
      display_notice( "Viewing report for " . $user->get_full_name(), 'success' );
      header( "Location: advisor.php?student_id=$user->get_user_id()" );
      exit();
    } else {
      $search = $_GET['student_search_term'];
      display_notice( "User '$search' not found.", 'error' );
      header( 'Location: advisor.php' );
      exit();
    }

  } elseif ( $_GET['action'] == 'new_search' ) {
    $name = $_SESSION['student']->get_full_name();
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