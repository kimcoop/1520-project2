<h3>Advising Sessions</h3>

<table class="table table-hover">
  <?php
    $sessions = Session::find_all_by_psid( $_SESSION['viewing_psid'] );
    if ( count($sessions) > 0 ) {
      foreach( $sessions as $index => $session ) {
      ?>
      
        <tr>
          <td>Session <?php echo $index + 1 ?></td>
          <td><?php echo $session ?></td>
        </tr>

      <?php
      } // foreach
    } else {
  ?>

    No advising sessions found.

  <?php } ?>

</table>
