<?php 

    include "validate_session.php";
    
    // Redirect("./nowplaying.php");
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
        <link rel="stylesheet" href="static/css/style.css">
        <link rel="stylesheet" href="static/css/react-bootstrap-switch.min.css">
        <link href="http://fonts.googleapis.com/css?family=Indie+Flower" rel="stylesheet" type="text/css">
      </head>
      <body>
        <!--[if lt IE 8]>
          <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browserhappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <div class="container max-width-md">
          <div class="align-ctr">
            <a href="./logout.php" class="btn btn-link font-sz-md">Logout</a>
          </div>
          <h1 class="align-ctr"></h1>
          <?php // put your HTML stuff here
            include 'db.php';

            $movieId = $_GET['movieId'];
            
            $movie = fetchMovieById($movieId);    
            $movieGenres = fetchGenresByMovieId($movieId);
            $movieGenres = array_map(function ($genre) {
              return $genre['Genre'];
            }, $movieGenres);
            $reviews = fetchReviewsByMovieId($movieId);
            // $ratingCount = fetchRatingCountByMovieId($movieId);
            // Workaround to get just the count, instead of array
            // $ratingCount = reset($ratingCount);
            $ratingCount = count($reviews);

            if (is_null($movie)) {
              echo "Error: Movie not found";
              RedirectJS("./nowplaying.php");
            }

            echo '
              <h1 class="align-ctr"> ' . $movie['Title'] . '</h1>
              <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                  <h3 class="text-center"><em>Released</em></h3>
                  <h1 class="text-center">
                    ' . $movie['Release_year'] . '
                  </h1>
                  <h2 class="text-center">
                    ' . $movie['Content_rating'] 
                    . ', ' 
                    . movieLengthToString($movie['Length'])
                    . '
                  </h2>
                  <h3 class="text-center">';
            
                    array_map(function($genre) {
                      echo $genre . '/'; 
                    }, $movieGenres);

                  echo '
                  </h3>
                  <h3 class="text-center">
                    Rating: 
                    ' . $movie['Average_rating'] . '
                    / 5
                  </h3>
                  <h3 class="text-center">
                    ' . $ratingCount . '
                    Fan Ratings
                  </h3>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                  <div class="align-ctr padding-sm">
                    <a href="./overview.php?movieId=' . $movieId . '" class="btn btn-default btn-lg">
                      Overview
                    </a>
                  </div>
                  <div class="align-ctr padding-sm">
                    <a href="./review.php?movieId=' . $movieId . '" class="btn btn-default btn-lg">
                      Movie Review
                    </a>
                  </div>
                  <div class="align-ctr padding-sm">
                    <a href="./choosetheater.php?movieId=' . $movieId . '" class="btn btn-default btn-lg">
                      Buy Ticket
                    </a>
                  </div>
                  <div class="align-ctr padding-sm">
                    <a href="./nowplaying.php" class="btn btn-default btn-lg">
                      Back
                    </a>
                  </div>
                </div>
              </div>
              ';
            
          ?>
        </div>
      </body>
    </html>

