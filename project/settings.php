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

  <h3>Secret Question</h3>
  <form action="routes.php" method="post" name="secret_question_form">

    <fieldset>
      <label>Secret question</label>
      <input type="text" placeholder="Mother's maiden name..." name="secret_question" value="<?php echo current_user()->get_secret_question()?>">

      <label>Secret answer</label>
      <input type="text" placeholder="Secret answer here" name="secret_answer" value="<?php echo current_user()->get_secret_answer()?>">
      
      <br>
      <br>

      <button name="secret_question_form_submit" type="submit" class="btn">Submit</button>
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


