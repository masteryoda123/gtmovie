<?php 
  include "validate_session.php";
  include 'db.php';

  $movieId = $_POST['movieId'];

  // Check if theater is chosen
  if (!isset($_POST['theaterId'])) {
    executeJS('alert("Please choose your theater");');
    RedirectJS('./choosetheater.php?movieId=' . $movieId);
    exit();
  }

  $username = $_SESSION['user']['name'];
  $theaterId = $_POST['theaterId'];

  // Save theater preference if necessary
  if (isset($_POST['saveTheater'])
    && $_POST['saveTheater'] == 1) {

    $theaterId = $_POST['theaterId'];
    $theaterPreference
      = fetchTheaterPreferenceByUsernameAndTheaterId($username, $theaterId);

    if (is_null($theaterPreference)) {
      insertTheaterPreference($username, $theaterId);
    }
  }

  $date = date('Y-m-d');
  if (isset($_POST['date'])) {
    $date = $_POST['date'];
  }

  $movie = fetchMovieById($movieId);
  $genres = fetchGenresByMovieId($movieId);
  $screeningsOnDate = fetchScreeningsByTheaterIdAndMovieIdAndDate($theaterId, $movieId, $date);

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
        <link rel="stylesheet" href="static/css/datepicker.css">
        <link href="http://fonts.googleapis.com/css?family=Indie+Flower" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="static/css/style.css">
        <script type="text/javascript" src="static/js/jquery-2.0.0.min.js"></script>
        <script type="text/javascript" src="static/js/bootstrap.js"></script>
        <script type="text/javascript" src="static/js/bootstrap-datepicker.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#dp4').datepicker({
                    format: "yyyy-mm-dd"
                });

                $('#dp4').keypress(function (e) {
                  e.preventDefault();
                });
                $('#dp4').keyup(function (e) {
                  e.preventDefault();
                });
                $('#dp4').keydown(function (e) {
                  e.preventDefault();
                });
            });
        </script>
      </head>
      <body>
        <!--[if lt IE 8]>
          <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browserhappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <div class="container max-width-lg">
          <div class="align-ctr">
            <a href="./logout.php" class="btn btn-link font-sz-md">Logout</a>
          </div>
          <h1 class="text-center">Select Time</h1>
          <form class="margin-tb-lg" method="post" id="form">
            <div class="align-ctr">
              <input class="" id="dp4" type="text" name="date" value="<?php echo $date; ?>">
              <input type="hidden" name="theaterId" value="<?php echo $theaterId ?>">
              <input type="hidden" name="movieId" value="<?php echo $movieId ?>">
              <input class="btn btn-default" type="submit" value="Update Show Times" formaction="./selecttime.php">
            </div>
            <div class="row">
              <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"> 
                <h2><?php echo $movie['Title'] ?></h2>
                <p class="margin-tb-lg">
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
              </div>
              <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8"> 
                <h3><em>Select a movie time to buy tickets</em></h3>
                <div class="margin-tb-xl">
                  <?php
                      if (is_null($screeningsOnDate)) {
                        echo '<p class="alert alert-danger">There are no showings today</p>';
                      } else {
                        array_map(function ($screening) {
                          echo '
                            <input class="btn btn-primary" formaction="./buytickets_qty.php" type="submit" name="time" value="'
                            . datetimeToTime($screening['Time_and_date'])
                            . '">';
                        }, $screeningsOnDate);
                      }
                  ?>
                </div>
              </div>
            </div>
            <div class="row margin-tb-sm">
              <input formaction="nowplaying.php" name="submit" value="Cancel" type="submit" class="btn btn-default btn-md">
            </div>
          </form>
          <?php // put your HTML stuff here ?>
        </div>
      </body>

    </html>

