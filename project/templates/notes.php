<h3>Advising Notes</h3>

<table class="table table-hover">

  <?php
    
    $notes = Note::find_all_by_psid( $_SESSION['viewing_psid'] );

    if ( count($notes) > 0 ) {

      foreach( $notes as $index => $note ) {
        ?>

        <tr>
          <td>Note <?php echo $index + 1 ?></td>
          <td><?php echo $note; ?></td>
          <td>
            <?php

              if ( $note->should_show() ) {
                echo $note->get_contents();
              } else {

            ?>

            <form class="pull-right" action="routes.php" method="post" name="display_notes_form">
              <button value="<?php echo $note->id; ?>" class="btn" type="submit" name="display_notes_form_submit">View &raquo;</button>
            </form>

            <?php
              }
            ?>
          </td>
        </tr>
      <?php
      } // foreach
    } else {
    ?>

    No advising notes found.

    <?php
    }
  ?>

</table>
