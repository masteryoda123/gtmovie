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
        <div class="container max-width-lg">
          <div class="align-ctr">
            <a href="./logout.php" class="btn btn-link font-sz-md">Logout</a>
          </div>
          <?php // put your HTML stuff here
            include 'db.php';

            $movieId = $_GET['movieId'];
            $movie = fetchMovieById($movieId);
            $reviews = fetchReviewsByMovieId($movieId);

            if (is_null($movie)) {
              RedirectJS('./nowplaying.php');
            }

            echo '
              <h1>' . $movie['Title'] . '</h1>
              <div class="align-ctr">
                Avg. rating: ' . $movie['Average_rating'] . '
              </div>
              <span onClick="window.location = \'./givereview.php?movieId=' . $movieId . '\';" class="margin-tb-lg btn btn-default col-xs-12 col-sm-12 col-md-12 col-lg-12">
                Give Review
              </span>
            ';

            echo '<ul class="list-group">';
              array_map(function($review) {
                echo '
                <li class="list-group-item col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <p>Title: ' . $review['Review_title'] . '</p>
                  <p>Rating: ' . $review['Rating'] . '</p>
                  <p>Comment: ' . $review['Comment'] . '</p>
                </li>
              '; }, $reviews);
            echo '</ul>';


          ?>
          <div class="row margin-tb-md align-ctr">
            <a href="./movie.php?movieId=<?php echo $movieId; ?>" class="btn btn-default btn-lg">
              Back
            </a>
          </div>
        </div>
      </body>

    </html>

