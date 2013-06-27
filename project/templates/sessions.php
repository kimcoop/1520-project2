<h3>Advising Sessions</h3>

<table class="table table-hover">
  <?php
    $sessions = Session::find_all_by_psid( $student->get_psid() );
    if ( count($sessions) > 0 ):
      foreach( $sessions as $index => $session ):
      ?>
      
        <tr>
          <td>Session <?php echo $index + 1 ?></td>
          <td><?php echo $session ?></td>
        </tr>

      <?php
      endforeach;
    else:
  ?>

    No advising sessions found.

  <?php endif; ?>

</table>
