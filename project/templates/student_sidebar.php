<?php if ( is_viewing_student() ): ?>
  
  <aside class="well">
    <h4 class="title">Current Report</h4>

    <p>
      <?php

      $format = "%s, user ID %u, PeopleSoft #%u";
      $student_summary = sprintf( $format, $student->get_full_name(), $student->get_user_id(), $student->get_psid() );

      echo $student_summary; 

      ?>
    </p>

    <?php if ( !current_user()->is_logging_session() ): ?>
      <form action="routes.php" method="post" name="log_advising_session_form">
        <button class="btn btn-block btn-primary" type="submit" name="log_advising_session_form_submit">Log advising session</button>
      </form>
    <?php else: ?>
      <p class="text-success">Logging current advising session</p>
    <?php endif; ?>

    <a href="advisor.php" class="btn btn-block btn-primary">Back to Search</a>

  </aside>
  <aside class="well">
    <h4 class="title">Session Notes</h4>
    <?php 

      if ( current_user()->is_logging_session() )
        echo "<div class='text-info'>Please log your session (above) to add notes.</div><br>";

    ?> 
    <form action="routes.php" method="post" name="advising_notes_form">
      <textarea <?php if ( current_user()->is_logging_session() ) echo 'disabled'; ?> class="input-block-level" name="note_content" rows="11" placeholder="Notes"></textarea>
      <button <?php if ( current_user()->is_logging_session() ) echo 'disabled'; ?> class="btn btn-block btn-primary" type="submit" name="advising_notes_form_submit">Add notes to current session</button>
    </form>
  </aside>

  <?php endif; ?>