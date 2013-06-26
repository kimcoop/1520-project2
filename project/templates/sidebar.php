<?php 
    if ( is_viewing_student() ) {

      $format = "%s, user ID %u, PeopleSoft #%u";
      $student_summary = sprintf( $format, $_SESSION['student']->get_full_name(), $_SESSION['student']->get_user_id(), $_SESSION['student']->get_psid() );

  ?>
  <aside class="well">
    <h4 class="title">Current Report</h4>

      <p>
        <?php echo $student_summary; ?>
      </p>

        <?php
          if ( !is_logging_session() ) {
        ?>

        <form action="routes.php" method="post" name="log_advising_session_form">
          <button class="btn btn-block btn-primary" type="submit" name="log_advising_session_form_submit">Log advising session</button>
        </form>

        <?php
          } else {
        ?>
        <p class="text-success">
          Logging current advising session
        </p>

    <?php
      }
    ?>
    <a href="routes.php?action=new_search" class="btn btn-block btn-primary">View another student record</a>

  </aside>
  <aside class="well">
    <h4 class="title">Session Notes</h4>
    <?php 

      if ( !is_logging_session() ) {
        echo "<div class='text-info'>Please log your session (above) to add notes.</div><br>";
      }

    ?> 
    <form action="routes.php" method="post" name="advising_notes_form">
      <textarea <?php if ( !is_logging_session() ) echo 'disabled'; ?> class="input-block-level" name="note_content" rows="11" placeholder="Notes"></textarea>
      <button <?php if ( !is_logging_session() ) echo 'disabled'; ?> class="btn btn-block btn-primary" type="submit" name="advising_notes_form_submit">Add notes to current session</button>
    </form>
  </aside>

  <?php
    }
  ?>