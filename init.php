<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Advisor Cloud v2.0</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <link href="http://netdna.bootstrapcdn.com/twitter-bootstrap/2.3.2/css/bootstrap-combined.min.css" rel="stylesheet">

    <style>
    .container-narrow {
      margin: 0 auto;
      max-width: 700px;
    }

    .table-info {
      width: 60%;
    }

     .table-info tr td:first-child {
        min-width: 45%;
        width: 45%;
        text-align: left;
     }

     .table-info tr td {
        vertical-align: middle;
        border: none;
     }
    
    </style>
    
  </head>

<body>

  <br>
  <br>

  <div class="container-narrow">

    <div class="row-fluid">
      <div class="span12">
        <h2>
          Database Init Script
        </h2>
      </div>
    </div>

    <hr>

  <?php

    require( 'project/libs/seeds.php' );

  ?>


  </div> <!-- .container-narrow -->

  </body>
</html>
