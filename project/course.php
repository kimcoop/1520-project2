<?php include('templates/header.php') ?>

<?php

  if ( is_logged_in() && is_advisor() ) {
    $course = Course::find_by_id( $_GET['course_id'] );

?>


  <div class="row">
    <div class="main-content span9">
      
      <div class="hgroup">
        <h2>
          <span class="icon-stack">
            <i class="icon-circle icon-stack-base"></i>
            <i class="icon-pencil icon-light"></i>
          </span>
          <?php echo $course ?>
          <small>Course details</small>
        </h2>
        <?php include('templates/notice.php') ?>

      </div><!-- .hgroup -->

      <table class="table table-hover">
        <?php 
          $user_courses = $course->user_courses();
          if ( $user_courses ): ?>
            <thead>
              <th></th>
              <th>Term</th>
              <th>PeopleSoft #</th>
              <th>Student ID</th>
              <th>Grade</th>
              <th></th>
            </thead>
          <?php usort( $user_courses, 'sort_by_term' );
            foreach( $user_courses as $index => $user_course ): 
          ?>
            <tr>
              <td class="muted"><?php echo $index +1 ?></td>
              <td><?php echo $user_course->term ?></td>
              <td><?php echo $user_course->psid ?></td>
              <?php if ( $user = $user_course->user() ): ?> 
                <td><?php echo $user->get_user_id() ?></td>
              <?php else: ?>
                <td>(user not in system)</td>
              <?php endif; ?>
              <td><?php echo $user_course->grade ?></td>
              <td class="text-right">
                <?php if ( $user ): ?>
                  <a href="student.php?user_id=<?php echo $user->get_user_id() ?>">
                    <i class="icon-eye-open"></i>&nbsp;View student
                  </a>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <p>No student records found.</p>
        <?php endif; ?>
      </table>

    </div><!-- .main-content-->

    <div class="span3 side-content">
        <?php include('templates/course_sidebar.php'); ?>
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

<?php include('templates/footer.php') ?>


