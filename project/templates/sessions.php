<h3>Advising Sessions</h3>

<table class="table table-hover">
<?php
    $sessions = Session::find_all_by_psid( $student->get_psid() );
    if ( count($sessions) > 0 ): ?>
      <thead>
        <th></th>
        <th>Date</th>
        <th>Advisor</th>
        <th># Notes</th>
      </thead>
    <?php foreach( $sessions as $index => $session ): ?>
      <tr>
        <td class="muted"><?php echo $index + 1 ?></td>
        <td><?php echo $session ?></td>
        <td><?php echo $session->get_author_full_name() ?></td>
        <td>
          <?php echo count( $session->notes() ); ?>
        </td>
      </tr>
      
  <?php
    endforeach;
  else:
?>

  No advising sessions found.

<?php endif; ?>

</table>