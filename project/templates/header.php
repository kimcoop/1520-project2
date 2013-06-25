<?php 

  require_once('functions.php');

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Advisor Cloud</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <link href="//netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    
  </head>

  <body>

    <?php

      if ( is_logged_in() ):

    ?>

      <header>
        <div class="container nav-container">
          <ul class="nav nav-pills pull-right">
            <li><a href="<?php echo get_root_url(); ?>">
              Welcome, <?php echo current_user()->get_first_name(); ?>
            </a></li>
            <li>
              <a href="routes.php?action=logout">
                Logout
              </a>
            </li>
          </ul>
          <h3 class="title muted">
            <a href="<?php echo get_root_url(); ?>">
            Advisor Cloud
            </a>
          </h3>
        </div><!-- .container -->
      </header>


    <?php

      endif;

    ?>

    <div class="container main">

