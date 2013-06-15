<?php include('templates/header.php'); ?>

<?php

  if ( is_logged_in() && is_advisor() ) {

?>

  <div class="row">
    <div class="main-content span9">
      
      <div class="hgroup">

        <?php
          if ( should_show_notice() ) {
        ?>

          <div class="alert alert-<?php echo $_SESSION['notice']['type']; ?>">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <?php echo $_SESSION['notice']['message']; ?>
          </div>

        <?php
          unset( $_SESSION['notice'] );
          }
        ?>

        <h2>
          <?php echo $_SESSION['first_name']; ?>'s 
          <span class="light">Advisor Dashboard</span>
        </h2>

      </div><!-- .hgroup -->


      <?php
        if ( is_viewing_student() ) {
      ?>

        <ul class="nav nav-tabs">
          <li <?php if (is_active_tab('courses')) echo 'class="active"'; ?>><a href="#courses" data-toggle="tab">Courses</a></li>
          <li <?php if (is_active_tab('advising_sessions')) echo 'class="active"'; ?>><a href="#advising_sessions" data-toggle="tab">Advising Sessions</a></li>
          <li <?php if (is_active_tab('advising_notes')) echo 'class="active"'; ?>><a href="#advising_notes" data-toggle="tab">Advising Notes</a></li>
        </ul>

        <div class="tab-content">

          <div class="tab-pane <?php if (is_active_tab('courses')) echo 'active'; ?>" id="courses">
            <?php include('templates/courses.php'); ?>
          </div><!-- #courses -->

          <div class="tab-pane <?php if (is_active_tab('advising_sessions')) echo 'active'; ?>" id="advising_sessions">
            <?php include('templates/sessions.php'); ?>
          </div><!-- #advising -->

          <div class="tab-pane <?php if (is_active_tab('advising_notes')) echo 'active'; ?>" id="advising_notes">
            <?php include('templates/notes.php'); ?>
          </div><!-- #notes -->

        </div><!-- .tab-content -->


      <?php
          
        } else { // not viewing student

      ?>

      <p>Welcome to your advisor dashboard. Use the search form below to look up a student by student's PeopleSoft ID or first name/last name.</p>

      <form class="navbar-search pull-left" action="routes.php" method="get" name="search_student_form">
        <div class="input-prepend">
            <span class="add-on"><i class="icon-search"></i></span>
            <input autofocus placeholder="Search term" type="text" name="student_search_term">
        </div>
        <button type="submit" class="btn search-button" name="search_student_form_submit">Search</button>
      </form>
      <br>

    <?php

      } // viewing student

    ?>

    
    </div><!-- .main-content-->

    <div class="span3 side-content">
        <?php include('templates/sidebar.php'); ?>
    </div><!-- .side-content -->

  </div><!-- .row -->


<?php

} else {
    
?>

  

  <br>
  <div class="alert alert-error">
    <strong>Sorry</strong> You must be logged in to view this page.
  </div>

  <a class="btn btn-primary" href="index.php">Login</a>


<?php 

  }

?>

<?php include('templates/footer.php'); ?>