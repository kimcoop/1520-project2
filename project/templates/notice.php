<?php
  if ( should_show_notice() ) {
?>

  <div class="alert alert-<?php echo $_SESSION['notice']['type'] ?>">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <?php echo $_SESSION['notice']['message'] ?>
  </div>

<?php
  unset( $_SESSION['notice'] );
  }
?>