<?php include('templates/header.php') ?>

  <?php
    if ( !is_logged_in() ):
  ?>

  <form class="form-signin" action="routes.php" name="signin_form" method="post">

    <h2 class="text-center form-signin-heading">Welcome to Advisor Cloud</h2>

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

    <?php
      if (isset($_COOKIE['user_id'])):
    ?>

    <input type="text" class="input-block-level" placeholder="User ID" name="user_id" value="<?php echo $_COOKIE['user_id']; ?>" />
    <input autofocus type="password" class="input-block-level" placeholder="Password" name="password" />

    <?php
    else:
    ?>

    <input autofocus type="text" class="input-block-level" placeholder="User ID" name="user_id" />
    <input type="password" class="input-block-level" placeholder="Password" name="password" />

    <?php
    endif;
    ?>

    
    <button type="submit" class="btn btn-block btn-large btn-primary" name="signin_form_submit">Sign in</button>

    <br>
    <br>
    <span class="pull-right">
      <label class="checkbox">
        <input type="checkbox" name="forgot_password"> Forgot password
      </label>
    </span>
    
  </form>

  <?php
    else:
  ?>

  <h2>Hello</h2>
  <a href="<?php echo get_root_url(); ?>" class="btn btn-primary">Home</a>

  <?php
    endif;
  ?>


<?php include('templates/footer.php') ?>