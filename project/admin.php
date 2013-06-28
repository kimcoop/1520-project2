<?php include('templates/header.php') ?>

<?php

  if ( is_logged_in() && current_user()->is_admin() ) {

?>
  
  <div class="hgroup">
    <h2>Admin</h2>
    <?php include('templates/notice.php') ?>

  </div><!-- .hgroup -->

  <hr>

  <div class="span12">
    <div class="span3">
      <h3>Add user</h3>
      <form action="routes.php" method="post" name="add_user_form">

        <fieldset>
          <label>Email</label>
          <input type="text" placeholder="Email" name="email">
          <label>First name</label>
          <input type="text" placeholder="First name" name="first_name">
          <label>Last name</label>
          <input type="text" placeholder="Last name" name="last_name">
          <label>Password</label>
          <input type="text" placeholder="Password" name="password">
          <label>PeopleSoft #</label>
          <input type="text" placeholder="PeopleSoft #" name="psid">
          <label>User ID</label>
          <input type="text" placeholder="User ID" name="user_id">
          <label>Access level</label>
          <select name="access_level">
            <option value="0">0 - Student</option>
            <option value="1">1 - Advisor</option>
            <option value="2">2 - Admin</option>
          </select>
          <br>
          <br>
          <button name="add_user_form_submit" type="submit" class="btn btn-large">Create user</button>
        </fieldset>
      </form>
    </div>

    <div class="span3">
      <h3>Delete user</h3>
      <form action="routes.php" method="post" name="delete_user_form">

        <fieldset>
          <label>User</label>
          <select name="psid">
            <?php foreach( User::find_all() as $user ): ?>
              <option value="<?php echo $user->get_psid()?>"><?php echo $user->get_full_name() ?></option>
            <?php endforeach; ?>
          </select>
          <br>
          <br>
          <button name="delete_user_form_submit" type="submit" class="btn btn-large">Delete user</button>
        </fieldset>
      </form>
    </div>
    
    <div class="span3">
      <h3>Load courses from file</h3>
      <form action="routes.php" method="post" name="add_course_form">

        <fieldset>
          <label>Filename</label>
          <input type="text" placeholder="Filename" name="filename">
          <br>
          <br>
          <button name="add_course_form_submit" type="submit" class="btn btn-large">Load file</button>
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

  <a class="btn btn-large btn btn-large-primary" href="index.php">Login</a>


<?php 

  }

?>

<?php include('templates/footer.php') ?>


