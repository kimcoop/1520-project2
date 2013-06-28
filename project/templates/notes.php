<h3>Advising Notes</h3>

<table class="table table-hover">

<?php
    $notes = Note::find_all_by_psid( $student->get_psid() );
    if ( count($notes) > 0 ) { ?>
    
      <thead>
        <th></th>
        <th>Date</th>
        <th>Author</th>
      </thead>

      <?php foreach( $notes as $index => $note ) { ?>

        <tr>
          <td class="muted"><?php echo $index + 1 ?></td>
          <td><?php echo $note; ?></td>
          <td><?php echo $note->get_author_full_name() ?></td>
          <td>
            <?php

              if ( $note->should_show() ) {
                echo $note->get_contents();
              } else {

            ?>

            <form class="pull-right" action="routes.php" method="post" name="display_notes_form">
              <button value="<?php echo $note->id; ?>" class="btn" type="submit" name="display_notes_form_submit">
                <i class="icon-eye-open"></i>&nbsp;View Note
              </button>
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
