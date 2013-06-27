<?php include('templates/header.php') ?>

<?php

  if ( is_logged_in() ) {

?>
  
  <div class="hgroup">
    <h2>Settings</h2>
    <?php include('templates/notice.php') ?>
    
  </div><!-- .hgroup -->

  <hr>


  <h3>Change Password</h3>
  <form action="routes.php" method="post" name="change_password_form">

    <fieldset>
      <label>Current password</label>
      <input type="password" placeholder="Old password" name="old_password">

      <label>New password</label>
      <input type="password" placeholder="New password" name="new_password">

      <label>Confirm new password</label>
      <input type="password" placeholder="New password again" name="new_password_confirm">
      
      <br>
      <br>

      <button name="change_password_form_submit" type="submit" class="btn">Submit</button>
    </fieldset>
  </form>

<?php

  } else {

?>

  <br>
  <div class="alert alert-error">
    <strong>Sorry</strong> You must be logged in to view this page.
  </div>

  <a class="btn btn-primary" href="index.php">Login</a>


<?php 

  }

?>

<?php include('templates/footer.php') ?>


