<?php 
  include "validate_session.php";
  include "db.php";
  
  $orderId = $_GET['orderId'];
  
  $username = $_SESSION['user']['name'];
  $movieId = $_POST['movieId'];
  $theaterId = $_POST['theaterId'];
  $time = $_POST['time'];
  $date = $_POST['date'];
  $datetime = $date . ' ' . $time . ':00';
  $qtyAdult = $_POST['qtyAdult'];
  $qtySenior = $_POST['qtySenior'];
  $qtyChild = $_POST['qtyChild'];
  $cost = $_POST['cost'];

  $movie = fetchMovieById($movieId);
  $genres = fetchGenresByMovieId($movieId);
  $theater = fetchTheaterById($theaterId);
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
        <div class="container max-width-lg">
          <div class="align-ctr">
            <a href="./logout.php" class="btn btn-link font-sz-md">Logout</a>
          </div>
          <div class="row">
            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"> 
              <h2><?php echo $movie['Title'] ?></h2>
              <p>
                <?php 
                  echo $movie['Content_rating']
                    . ', '
                    . movieLengthToString($movie['Length'])
                    . '<br>';
                  array_map(function ($genre) {
                    echo $genre['Genre'], '/';
                  }, $genres)
                ?>
              </p>
              <h4>
                <?php
                  echo datetimeToString($datetime);
                ?>
              </h4>
            </div>
            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8"> 
              <h2><?php echo $theater['Theater_name'] ?></h2>
              <p>
                <?php
                  echo $theater['Street_number']
                    . ' ' 
                    . $theater['Street_name']
                    . '<br>'
                    . $theater['City']
                    . ', '
                    . $theater['State']
                    . ' ' 
                    . $theater['Zip'];
                ?> 
              </p>
              <br>
              <p><?php echo "{$qtyAdult} Adult Tickets, {$qtySenior} Senior Tickets, {$qtyChild} Child Tickets" ?> </p>
              <br>
              <h4>Total Cost is <?php echo $cost ?></h4>
            </div>
          </div>
          <div class="horizontal-line-sm margin-tb-lg"></div>
          <h2>Your Order ID is <?php echo $orderId ?></h2>
          <div class="align-ctr">
            <a href="./nowplaying.php" class="btn btn-default btn-lg">
              Done
            </a>
          </div>
        </div>
      </body>

    </html>

