<?php
  include "validate_session.php";
  include "db.php";

  $username = $_SESSION['user']['name'];
  $movieId = $_POST['movieId'];
  $theaterId = $_POST['theaterId'];
  $time = $_POST['time'];
  $date = $_POST['date'];
  $datetime = $date . ' ' . $time . ':00';
  $qtyAdult = $_POST['qtyAdult'];
  $qtySenior = $_POST['qtySenior'];
  $qtyChild = $_POST['qtyChild'];

  $movie = fetchMovieById($movieId);
  $genres = fetchGenresByMovieId($movieId);
  $theater = fetchTheaterById($theaterId);

  $savedCards = fetchSavedCardsForCustomer($username);

  $systemInfo = fetchFirstSystemInfo();
  $childDiscountRate = $systemInfo['Child_discount'];
  $seniorDiscountRate = $systemInfo['Senior_discount'];
  $childPayRate = 1 - $childDiscountRate;
  $seniorPayRate = 1 - $seniorDiscountRate;

  $cost = round($TICKET_PRICE*($qtyAdult + $childPayRate*$qtyChild + $seniorPayRate*$qtySenior), 2);
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
        <div class="container max-width-lg" style="overflow-y:scroll; height:100%;">
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
          <h1 class="text-center">Payment Information</h1>
          <form class="margin-tb-lg" method="post" id="form">
            <div class="align-ctr">
              <input type="hidden" name="movieId" value="<?php echo $movieId ?>">
              <input type="hidden" name="theaterId" value="<?php echo $theaterId ?>">
              <input type="hidden" name="time" value="<?php echo $time ?>">
              <input type="hidden" name="date" value="<?php echo $date ?>">
              <input type="hidden" name="datetime" value="<?php echo $datetime ?>">
              <input type="hidden" name="qtyAdult" value="<?php echo $qtyAdult ?>">
              <input type="hidden" name="qtyChild" value="<?php echo $qtyChild ?>">
              <input type="hidden" name="qtySenior" value="<?php echo $qtySenior ?>">
              <input type="hidden" name="cost" value="<?php echo $cost ?>">
            </div>
            <div class="row margin-tb-sm">
              <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                <h3>Use a saved card</h3>
              </div>

              <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                <select name="cardNum" class="form-control">
                  <?php
                  array_map(function($savedCard){
                    echo <<<OPT
                    <option value="{$savedCard['Card_number']}">{$savedCard['lastdigits']}</option>
OPT;
                  }, $savedCards)
                  ?>
                </select>
              </div>
              <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                <input formaction="placeorder.php" name="submit" value="Place Order" type="submit" class="btn btn-default btn-md">
              </div>
            </div>
            <div class="row margin-tb-sm">
              <h3>Use a new card</h3>
            </div>
            <div class="row margin-tb-sm">
              <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                <h4>Name on Card</h4>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <input type="text" name="ownerName" class="form-control"></input>
              </div>
            </div>
            <div class="row margin-tb-sm">
              <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                <h4>Card Number</h4>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <input type="text" name="cardNumber" class="form-control"></input>
              </div>
            </div>
            <div class="row margin-tb-sm">
              <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                <h4>CVV</h4>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <input type="text" name="CVV" class="form-control"></input>
              </div>
            </div>
            <div class="row margin-tb-sm">
              <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                <h4>Expiration Date (yyyy-mm)</h4>
              </div>
              <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <input type="text" name="expDate" class="form-control"></input>
              </div>
            </div>
            <label class="checkbox"><input name="saveCard" type="checkbox" value="1">Save this Payment Information</label>
            <div class="row margin-tb-sm">
              <input formaction="newpaymentmethod.php" name="submit" value="Place Order" type="submit" class="btn btn-default btn-md">
            </div>


          <?php // put your HTML stuff here ?>
            <div class="row margin-tb-sm">
              <input formaction="nowplaying.php" name="submit" value="Cancel" type="submit" class="btn btn-default btn-md">
            </div>
          </form>
        </div>
      </body>

    </html>
