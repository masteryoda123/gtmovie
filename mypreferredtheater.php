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
          <?php // put your HTML stuff here ?>
      </div>
      <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
      </div>
      <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="row margin-tb-sm">
          <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
            <h4>City/State/Theater</h4>
          </div>
          <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <input type="text" name="search" class="form-control"></input>
          </div>
          <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
            <input formaction="searchtheater.php" name="submit" value="Search" type="submit" class="btn btn-default btn-md">
        </div>
        </div>
        <div class="row margin-tb-sm">
          <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
            <h4>Saved Theater</h4>
          </div>
          <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <select name="theaterId" class="form-control">
              <?php
                array_map(function ($theater) {
                  echo '<option value="'
                    . $theater['Theater_id']
                    . '">'
                    . $theater['Theater_name']
                    . '</option>';
                }, $theaters);
              ?>
            </select>
          </div>
          <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
            <input formaction="selecttime.php" name="submit" value="Choose" type="submit" class="btn btn-default btn-md">
          </div>
      </div>
      <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
      </div>
        <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
              <a href="./me.php" class="btn btn-default btn-lg">
                 Back
              </a>
            </div>
    </div>
      </body>

    </html>
