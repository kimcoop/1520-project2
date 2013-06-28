<?php include('templates/header.php') ?>

<?php

  if ( is_logged_in() && current_user()->is_admin() ) {

?>
  
  <div class="hgroup">
    <h2>
      <i class="icon icon-key"></i>&nbsp;
      Admin
    </h2>
    <?php include('templates/notice.php') ?>
  </div><!-- .hgroup -->


  <div class="row">
    <div class="span12">
      <ul class="nav nav-tabs">
        <li class="active"><a href="#users" data-toggle="tab">Users</a></li>
        <li><a href="#courses" data-toggle="tab">Courses</a></li>
      </ul>
    </div>
  </div>

  <div class="tab-content">
    <div class="tab-pane active" id="users">
      <div class="row">
        <div class="span3 well">
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
              <select class="input-block-level" name="access_level">
                <option value="0">0 - Student</option>
                <option value="1">1 - Advisor</option>
                <option value="2">2 - Admin</option>
              </select>
              <br>
              <button name="add_user_form_submit" type="submit" class="btn btn-large btn-primary btn-block">Create user</button>
            </fieldset>
          </form>
        </div><!-- .span -->
        <div class="span3 well">
          <h3>Delete user</h3>
          <form action="routes.php" method="post" name="delete_user_form">

            <fieldset>
              <label>User (last name, first name)</label>
              <select class="input-block-level" name="psid">
                <?php 
                  $users = User::find_all();
                  usort( $users, 'sort_by_last_name' );
                  foreach( $users as $user ): 
                ?>
                  <option value="<?php echo $user->get_psid()?>"><?php echo $user->get_last_name() .", ". $user->get_first_name() ?></option>
                <?php endforeach; ?>
              </select>
              <br>
              <button name="delete_user_form_submit" type="submit" class="btn btn-large btn-primary btn-block">Delete user</button>
            </fieldset>
          </form>
        </div><!-- .span -->
      </div><!-- .row -->
    </div><!-- #users.tab-pane -->
    <div class="tab-pane" id="courses">
      <div class="row">
        <div class="span3 well">
          <h3>Load courses from file</h3>
          <form action="routes.php" method="post" name="add_course_form">

            <fieldset>
              <label>Filename</label>
              <input type="text" placeholder="Filename" name="filename">
              <br>
              <br>
              <button name="add_course_form_submit" type="submit" class="btn btn-large btn-primary btn-block">Load file</button>
            </fieldset>
          </form>
        </div><!-- .span -->
      </div><!-- .row -->
    </div><!-- #courses.tab-pane -->
  </div>


    
  


<?php

  } else {

?>

  <br>
  <div class="alert alert-error">
    <strong>Sorry</strong> You must be logged in to view this page.
  </div>

  <a class="btn btn-large btn-primary btn-block btn btn-large-primary" href="index.php">Login</a>


<?php 

  }

?>

<?php include('templates/footer.php') ?>


