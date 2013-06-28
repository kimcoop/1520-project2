<?php include('templates/header.php'); ?>

<?php

  if ( is_logged_in() && is_advisor() ):
    clear_browsing_session(); // clear out old search session (student or course)

?>

  <div class="row">
    <div class="main-content span10">
      
      <div class="hgroup">
        <h2>
          <i class="icon-dashboard"></i>&nbsp;
          <?php echo current_user()->get_role() ?> Dashboard
        </h2>
        <?php include('templates/notice.php') ?>
      </div><!-- .hgroup -->

      <p>Welcome to your <?php echo current_user()->get_role() ?> dashboard! Use the inputs below to look up a student or course.</p>

      <?php if ( current_user()->is_admin() )?>
        <p>This is the <strong>Advisor</strong> view. Use the <strong>Admin</strong> tab in the nav bar to access additional functionality, such as adding and deleting users.</p>

      <br>
      <div class="row row-search">
        <div class="span5 search-student well well-padded text-center">
          <h3><i class="icon-2x icon-user"></i></h3>
          <h3>Search for a Student</h3>
          <form action="routes.php" method="get" name="search_student_form">
            <input class="input-block-level" autofocus placeholder="<PeopleSoft #> or <FirstName LastName>" type="text" name="student_search_term">
            
            <button type="submit" class="btn-block btn-large btn-primary btn" name="search_student_form_submit">
              <i class="icon-search"></i>&nbsp;
              Search students
            </button>
            <br>
          </form>
        </div><!-- .search-student -->

        <div class="span5 search-course well well-padded text-center">
          <h3><i class="icon-2x icon-pencil"></i></h3>
          <h3>Search for a Course</h3>
          <form action="routes.php" method="get" name="search_course_form">
            <input class="input-small" placeholder="Department" type="text" name="department">
            <input placeholder="Course number" type="text" name="course_number">
            
            <button type="submit" class="btn-block btn-large btn-primary btn" name="search_course_form_submit">
              <i class="icon-search"></i>&nbsp;
              Search courses
            </button>
            <br>
          </form>
        </div><!-- .search-course -->
      

    </div><!-- .row-search -->
  </div><!-- .main-content-->

</div><!-- .row -->


<?php else: ?>

  <br>
  <div class="alert alert-error">
    <strong>Sorry</strong> You must be logged in to view this page.
  </div>

  <a class="btn btn-primary" href="index.php">Login</a>


<?php endif; ?>

<?php include('templates/footer.php'); ?>