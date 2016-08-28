<?php 
  include "validate_session.php";
  include 'db.php';
  
  $username = $_SESSION['user']['name'];
  $theaterId = $_POST['theaterId'];

  $theaterPreferenceDeleted = deleteTheaterPreference($username, $theaterId);
?>

<!DOCTYPE html>
    <html>
      <head>
        <meta charset="UTF-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>GTMovie</title>
        <link rel="stylesheet" href="static/css/bootstrap.min.css">
        <link rel="stylesheet" href="static/css/font-awesome.min.css">
        <link rel="stylesheet" href="static/css/react-bootstrap-switch.min.css">
        <link href="http://fonts.googleapis.com/css?family=Indie+Flower" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="static/css/style.css">
      </head>
      <body>
        <!--[if lt IE 8]>
          <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browserhappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <div class="container">
          <?php
  if ($theaterPreferenceDeleted) {
    echo '<h2>Theater Deleted Successfully</h2>';
  } else {
    echo '<h2>Theater NOT Deleted</h2>';
  }
          ?>
              <a href="./me.php" class="btn btn-default btn-lg">
                Back
              </a>
        </div>
      </body>

    </html>

