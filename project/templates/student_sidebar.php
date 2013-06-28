<?php if ( is_viewing_student() ): ?>
  
  <aside class="well">
    <h4 class="title">Current Report</h4>

    <div class="media">
      <a class="pull-left" href="#">
        <img class="media-object img-circle" src="<?php echo $student->get_gravatar() ?>" />
      </a>
      <div class="media-body">
        <h4 class="media-heading"><?php echo $student->get_full_name(); ?></h4>
        <?php echo $student->get_user_id(); ?>
      </div>
    </div>

    <br>

    <p>
      <strong>PeopleSoft #:</strong>
      <?php echo $student->get_psid(); ?>
    </p>
    <p>
      <strong>Email:</strong>
      <?php echo $student->get_email(); ?>
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
        <button class="btn btn-block btn-primary" type="submit" name="log_advising_session_form_submit">
          <i class="icon icon-edit"></i>&nbsp;
          Log advising session
        </button>
      </form>
    <?php else: ?>
      <p class="text-success">Logging current advising session</p>
      <a href="routes.php?action=end_session_log" class="btn btn-block btn-primary">
        <i class="icon icon-remove-sign"></i>&nbsp;
        Stop logging session
      </a>
    <?php endif; ?>


    <a href="advisor.php" class="btn btn-block btn-primary">
      <i class="icon icon-chevron-left"></i>&nbsp;
      Back to search
    </a>

  </aside>
  <aside class="well">
    <h4 class="title">Session Notes</h4>
    <?php 

      if ( !current_user()->is_logging_session() )
        echo "<p>Please log your session (above) to add notes.</p>";

    ?> 
    <form action="routes.php" method="post" name="advising_notes_form">
      <input type="hidden" value="<?php echo current_user()->get_logging_session_id() ?>" name="session_id" />
      <textarea <?php if ( !current_user()->is_logging_session() ) echo 'disabled'; ?> class="input-block-level" name="note_content" rows="11" placeholder="Notes"></textarea>
      <button <?php if ( !current_user()->is_logging_session() ) echo 'disabled'; ?> class="btn btn-block btn-primary" type="submit" name="advising_notes_form_submit">
        <i class="icon icon-plus-sign"></i>&nbsp;
        Add notes to current session
      </button>
    </form>
  </aside>

  <?php endif; ?>