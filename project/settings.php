<?php include('templates/header.php') ?>

<?php

  if ( is_logged_in() ) {

?>
  
  <div class="hgroup">
    <h2><i class="icon icon-cog"></i>&nbsp;Settings</h2>
    <?php include('templates/notice.php') ?>

  </div><!-- .hgroup -->


  <div class="row">
    <div class="span3 well">
      <h3>Change Password</h3>
      <form action="routes.php" method="post" name="change_password_form">

        <fieldset>
          <label>Current password</label>
          <input class="input-block-level" type="password" placeholder="Old password" name="old_password">

          <label>New password</label>
          <input class="input-block-level" type="password" placeholder="New password" name="new_password">

          <label>Confirm new password</label>
          <input class="input-block-level" type="password" placeholder="New password again" name="new_password_confirm">
          
          <br>
          <br>

          <button name="change_password_form_submit" type="submit" class="btn btn-block btn-primary">Change password</button>
        </fieldset>
      </form>
    </div>

    <div class="span5 well">
      <h3>Secret Question</h3>
      <form action="routes.php" method="post" name="secret_question_form">

        <fieldset>
          <label>Secret question</label>
          <input class="input-block-level" type="text" placeholder="Mother's maiden name..." name="secret_question" value="<?php echo current_user()->get_secret_question()?>">

          <label>Secret answer</label>
          <input class="input-block-level" type="text" placeholder="Secret answer here" name="secret_answer" value="<?php echo current_user()->get_secret_answer()?>">
          
          <br>
          <br>

          <button name="secret_question_form_submit" type="submit" class="btn btn-block btn-primary">Save secret question</button>
        </fieldset>
      </form>
    </div>
  </div>



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


