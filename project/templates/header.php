<?php 

  require_once('functions.php');

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Advisor Cloud 2.0</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet">
    <link href="//netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Droid+Sans|Advent+Pro' rel='stylesheet' type='text/css'>
    <link href="css/style.css" rel="stylesheet">
    
  </head>

  <body>

    <?php

      if ( is_logged_in() ):
    ?>

      <header>
        <div class="container nav-container">
          <ul class="nav nav-pills pull-right">
            <li class="<?php if ( is_active_nav('home') ) echo 'active' ?>">
              <a href="<?php echo get_root_url(); ?>">
                <i class="icon icon-home"></i>&nbsp;
                Welcome, <?php echo current_user()->get_first_name(); ?>
              </a>
            </li>
            <?php if (current_user()->is_admin()) : ?>
            <li class="<?php if ( is_active_nav('admin') ) echo 'active' ?>">
              <a href="admin.php">
                <i class="icon icon-key"></i>&nbsp;
                Admin
              </a>
            </li>  
            <?php endif; ?>
            <li class="<?php if ( is_active_nav('settings') ) echo 'active' ?>">
              <a href="settings.php">
                <i class="icon icon-cog"></i>&nbsp;
                Settings
              </a>
            </li>
            <li>
              <a href="routes.php?action=logout">
                <i class="icon icon-signout"></i>&nbsp;
                Logout
              </a>
            </li>
          </ul>
          <h3 class="title muted">
            <a href="<?php echo get_root_url(); ?>">
            Advisor Cloud 2.0
            </a>
          </h3>
        </div><!-- .container -->
      </header>


    <?php

      endif;

    ?>

    <div class="container main">

