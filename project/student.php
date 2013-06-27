<?php include('templates/header.php') ?>

<?php

  if ( is_logged_in() && is_advisor() && isset( $_GET['user_id'] )):
    $student = User::find_by_user_id( $_GET['user_id'] );
    if ( $student ):
      set_viewing_student( $student ); // store to session


?>

    <div class="row">
      <div class="main-content span9">
        
        <div class="hgroup">
          <h2>Details for Student: <?php echo $student->get_full_name() ?></h2>
          <?php include('templates/notice.php') ?>

        </div><!-- .hgroup -->
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


      </div><!-- .main-content-->

      <div class="span3 side-content">
        <?php include('templates/student_sidebar.php'); ?>
      </div><!-- .side-content -->

    </div><!-- .row -->

  <?php else: ?>
   <div class="alert alert-error">
    User not found.&nbsp;
    <a href="advisor.php">Back</a>
  </div>
  <?php endif; ?>

<?php else: ?>

  <br>
  <div class="alert alert-error">
    <strong>Sorry</strong> You must be logged in to view this page.
  </div>

  <a class="btn btn-primary" href="index.php">Login</a>


<?php endif; ?>

<?php include('templates/footer.php') ?>


