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
            <a href="./me.php" class="btn btn-link">
              <span class="glyphicon glyphicon-user"></span>
              <span class="glyphicon-class font-sz-md">Me</span>
            </a>
          </div>
          <h1 class="align-ctr"><?php echo "Hello " . $_SESSION['user']['name']; ?></h1>
          <h2 class="align-ctr">Now Playing</h2>

          <div class="grid-wrapper">
<?php

  // fetch data
  include "db.php";

  $movies = fetchAllMovies();

  echo '<div class="row">';
  array_map(function($movie) {
    echo '
        <a href="./movie.php?movieId=' . $movie['Movie_id'] . '">
          <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 grid-cell">
            ' . $movie['Title'] . '
          </div>
        </a>
    ';
  }, $movies);
  echo '</div>';

?>
          </div>
        </div>
      </body>

    </html>
