<?php 
  include "validate_session.php";
  include 'db.php';

  $username = $_SESSION['user']['name'];
  $movieId = $_POST['movieId'];
  $theaterId = $_POST['theaterId'];
  $time = $_POST['time'];
  $date = $_POST['date'];
  $datetime = $date . ' ' . $time . ':00';

  $movie = fetchMovieById($movieId);
  $genres = fetchGenresByMovieId($movieId);
  $theater = fetchTheaterById($theaterId);

  $systemInfo = fetchFirstSystemInfo();
  $childDiscountRate = $systemInfo['Child_discount'];
  $seniorDiscountRate = $systemInfo['Senior_discount'];
  $childPayRate = 1 - $childDiscountRate;
  $seniorPayRate = 1 - $seniorDiscountRate;
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
        <script type="text/javascript" src="static/js/jquery-2.0.0.min.js"></script>
        <script>
          $(document).ready(function() {
            updateAdult = function () {
              $('#totalAdult').html(($('#qtyAdult').val() * <?php echo $TICKET_PRICE ?>).toFixed(2));
            }
            updateSenior = function () {
              $('#totalSenior')
                .html(($('#qtySenior').val() * <?php echo $TICKET_PRICE * $seniorPayRate ?>).toFixed(2));
            }
            updateChild = function () {
              $('#totalChild')
                .html(($('#qtyChild').val() * <?php echo $TICKET_PRICE * $childPayRate ?>).toFixed(2));
            }

            updateAdult();
            updateSenior();
            updateChild();

            $('#qtyAdult').change(updateAdult);
            $('#qtySenior').change(updateSenior);
            $('#qtyChild').change(updateChild);
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
            </div>
          </div>
          <div class="horizontal-line-sm margin-tb-lg">
          </div>
          <h1>How many tickets?</h1>
          <form class="margin-tb-lg" method="post" id="form">
            <div class="align-ctr">
              <input type="hidden" name="movieId" value="<?php echo $movieId ?>">
              <input type="hidden" name="theaterId" value="<?php echo $theaterId ?>">
              <input type="hidden" name="time" value="<?php echo $time ?>">
              <input type="hidden" name="date" value="<?php echo $date ?>">
              <input type="hidden" name="datetime" value="<?php echo $datetime ?>">
            </div>
            <div class="row">
              <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"> 
                <h4 class="text-right">Adult</h4>
              </div>
              <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"> 
                <div class="form-group">
                  <select name="qtyAdult" class="form-control max-width-xs" id="qtyAdult">
                    <option value="0">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                  </select>
                </div>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"> 
                <p>
                  * 
                  <?php
                      echo $TICKET_PRICE;
                  ?>
                  = 
                  <span id="totalAdult"></span>
                </p>
              </div>
            </div>
            <div class="row">
              <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"> 
                <h4 class="text-right">Senior</h4>
              </div>
              <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"> 
                <div class="form-group">
                  <select name="qtySenior" class="form-control max-width-xs" id="qtySenior">
                    <option value="0">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                  </select>
                </div>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"> 
                <p>
                  * 
                  <?php
                      echo $TICKET_PRICE;
                      echo ' * ';
                      echo $seniorPayRate * 100 . '%';
                  ?>
                  = 
                  <span id="totalSenior"></span>
                </p>
              </div>
            </div>
            <div class="row">
              <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"> 
                <h4 class="text-right">Child</h4>
              </div>
              <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2"> 
                <div class="form-group">
                  <select name="qtyChild" class="form-control max-width-xs" id="qtyChild">
                    <option value="0">0</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                  </select>
                </div>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"> 
                <p>
                  * 
                  <?php
                      echo $TICKET_PRICE;
                      echo ' * ';
                      echo $childPayRate * 100 . '%';
                  ?>
                  = 
                  <span id="totalChild"></span>
                </p>
              </div>
            </div>
            <div class="row margin-tb-sm">
              <input formaction="paymentinfo.php" name="submit" value="Next" type="submit" class="btn btn-default btn-md">
            </div>
            <div class="row margin-tb-sm">
              <input formaction="nowplaying.php" name="submit" value="Cancel" type="submit" class="btn btn-default btn-md">
            </div>
          </form>
          <?php // put your HTML stuff here ?>
        </div>
      </body>

    </html>

