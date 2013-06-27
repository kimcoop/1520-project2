<?php include('templates/header.php'); ?>

<?php

  if ( is_logged_in() && is_advisor() ):
    clear_browsing_session(); // clear out old search session (student or course)
    echo 'cleared!<br>****';


?>

  <div class="row">
    <div class="main-content span9">
      
      <div class="hgroup">
        <h2>
          <?php echo current_user()->get_first_name(); ?>'s 
          <span class="light">Advisor Dashboard</span>
        </h2>
        <?php include('templates/notice.php') ?>
      </div><!-- .hgroup -->

      <p>Welcome to your advisor dashboard. Use the inputs below to look up a student or course.</p>

      <div class="row row-search">
        <div class="span4 search-student">
          <h3>Search for a Student</h3>
          <form action="routes.php" method="get" name="search_student_form">
            <input class="input-block-level" autofocus placeholder="<PeopleSoft #> or <FirstName LastName>" type="text" name="student_search_term">
            <button type="submit" class="btn search-button" name="search_student_form_submit">
              <i class="icon-search"></i>&nbsp;
              Search students
            </button>
          </form>
        </div><!-- .search-student -->

        <div class="span5 search-course">
          <h3>Search for a Course</h3>
          <form action="routes.php" method="get" name="search_course_form">
            <input placeholder="Department" type="text" name="department">
            <input placeholder="Course number" type="text" name="course_number">
            <button type="submit" class="btn search-button" name="search_course_form_submit">
              <i class="icon-search"></i>&nbsp;
              Search courses
            </button>
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