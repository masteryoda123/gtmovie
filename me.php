<?php
    include "validate_session.php";
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
          <div class="align-ctr">
            <a href="./logout.php" class="btn btn-link font-sz-md">Logout</a>
          </div>
          <h1 class="align-ctr">Me</h1>
          <h3 class="align-ctr">
            <a href="./orderhistory.php" class="btn btn-link font-sz-lg font-bold">My Order History</a>
          </h3>
          <h3 class="align-ctr">
            <a href="./mypaymentinfo.php" class="btn btn-link font-sz-lg font-bold">My Payment Information</a>
          </h3>
          <h3 class="align-ctr">

            <a href="./my_preferred_theaters.php" class="btn btn-link font-sz-lg font-bold">My Preferred Theaters</a>
          </h3>
          <div class="align-ctr">
            <a href="./nowplaying.php" class="btn btn-default btn-lg">
              Back
            </a>
          </div>
        </div>
      </body>

    </html>
