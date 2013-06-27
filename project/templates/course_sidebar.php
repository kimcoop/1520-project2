<?php if ( is_viewing_course() ): ?>

  <aside class="well">
    <h4 class="title">Current Report</h4>

      <p>
        <strong>Title:</strong>
        <?php echo $course; ?></p>
      <p>
        <strong>Average GPA:</strong>
        <?php echo $course->get_average_gpa(); ?>
      </p>
      <p>
        <strong>Total Students:</strong>
        <?php echo $course->get_total_students(); ?>
      </p>

    <a href="advisor.php" class="btn btn-block btn-primary">Back to Search</a>

  </aside>

<?php endif; ?>