<?php include('templates/header.php') ?>

<?php

  if ( is_logged_in() && is_student() ):
    $student = current_user();

?>
  
  <div class="hgroup">
    
    <h2>
      <?php echo current_user()->get_first_name(); ?>'s
      <span class="light"><?php echo current_user()->get_role() ?> Dashboard</span>
    </h2>

    <p>
      Welcome to your <?php echo current_user()->get_role() ?> dashboard. Here you'll find records of courses you've taken.
    </p>

  </div><!-- .hgroup -->

  <hr>

<?php include('templates/courses.php') ?>

<?php else: ?>

  <br>
  <div class="alert alert-error">
    <strong>Sorry</strong> You must be logged in as a student to view this page.
  </div>

  <a class="btn btn-primary" href="index.php">Login</a>


<?php endif; ?>

<?php include('templates/footer.php') ?>


