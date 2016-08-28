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

            if (is_null($movie)) {
              RedirectJS('./nowplaying.php');
            }

            echo '
              <h1>' . $movie['Title'] . '</h1>
              <div class="align-ctr">
                Avg. rating: ' . $movie['Average_rating'] . '
              </div>
            ';
          ?>
          <form method="post" action="./givereview_post.php" id="form">
            <div class="row margin-tb-xs">
              <input type="hidden" name="movieId" value=<?php echo $movieId; ?> />
              <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                Rating 
              </div>
              <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                <select name="rating" class="form-control">
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                </select>
              </div>
            </div>
            <div class="row margin-tb-xs">
              <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                Title
              </div>
              <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                <input type="text" name="title" class="form-control" />
              </div>
            </div>
            <div class="row margin-tb-xs">
              <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
                Comment
              </div>
              <div class="col-xs-10 col-sm-10 col-md-10 col-lg-10">
                <textarea name="comment" form="form" class="form-control"></textarea>
              </div>
            </div>
            <div class="row margin-tb-md align-ctr">
              <button type="submit" class="btn btn-lg btn-primary">Submit</button>
              <a href="./review.php?movieId=<?php echo $movieId; ?>" class="btn btn-default btn-lg">
                Back
              </a>
            </div>

          </form>
          
        </div>
      </body>

    </html>

