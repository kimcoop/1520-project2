<?php if ( is_viewing_student() ): ?>
  
  <aside class="well">
    <h4 class="title">Current Report</h4>

    <p>
      <strong>Name:</strong>
      <?php echo $student->get_full_name(); ?>
    </p>
    <p>
      <strong>User ID:</strong>
      <?php echo $student->get_user_id(); ?>
    </p>
    <p>
      <strong>PeopleSoft #:</strong>
      <?php echo $student->get_psid(); ?>
    </p>
    <p>
      <strong>Courses Taken:</strong>
      <?php echo $student->total_courses_taken(); ?>
    </p>
    <p>
      <strong>GPA:</strong>
      <?php echo $student->get_gpa();?>
    </p>

    <?php if ( !current_user()->is_logging_session() ): ?>
      <form action="routes.php" method="post" name="log_advising_session_form">
        <button class="btn btn-block btn-primary" type="submit" name="log_advising_session_form_submit">Log advising session</button>
      </form>
    <?php else: ?>
      <p class="text-success">Logging current advising session</p>
      <a href="routes.php?action=end_session_log" class="btn btn-block btn-primary">Stop logging session</a>
    <?php endif; ?>

    <a href="advisor.php" class="btn btn-block btn-primary">Back to search</a>

  </aside>
  <aside class="well">
    <h4 class="title">Session Notes</h4>
    <?php 

      if ( !current_user()->is_logging_session() )
        echo "<p>Please log your session (above) to add notes.</p>";

    ?> 
    <form action="routes.php" method="post" name="advising_notes_form">
      <textarea <?php if ( !current_user()->is_logging_session() ) echo 'disabled'; ?> class="input-block-level" name="note_content" rows="11" placeholder="Notes"></textarea>
      <button <?php if ( !current_user()->is_logging_session() ) echo 'disabled'; ?> class="btn btn-block btn-primary" type="submit" name="advising_notes_form_submit">Add notes to current session</button>
    </form>
  </aside>

  <?php endif; ?>