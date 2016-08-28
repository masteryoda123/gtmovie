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
          <?php
          include "db.php";
          $orderid = $_GET['orderid'];
          $order = fetchOrderByID($orderid);
          $movie = fetchMovieById($order['Movie_id']);
          $theater = fetchTheaterById($order['Theater_id']);

          if (is_null($orderid)) {
              echo "Error: Order not found";
              Redirect("./orderhistory.php");
          }
          if($orderid == -1) {
              echo '
              <h1>Error: This was not your order.</h1>
              <h2>Go back and try again</h2>
              ';

          } else {
              echo '
                    <h1 class="align-ctr"> Order ID: ' . $orderid . '</h1>
                     <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                            <h5><b>Movie</b>: '. $movie['Title'] .'</h5><br>
                            <h5><b>Movie Rating</b>: '. $movie['Content_rating'] .'</h5><br>
                            <h5><b>Movie Length</b>: '. movieLengthToString($movie['Length']) .'</h5><br>
                            <h5><b>Screening Time and Date</b>: '. $order['View_TimeAndDate'] .'</h5><br>
                            <h5><b>Theater</b>: '. $theater['Theater_name'] .'</h5><br>
                            <h5><b>Theater Address</b>: '. $theater['Street_number'] . ' ' . $theater['Street_name']. ', '. $theater['City']. ', '. $theater['State']. ', '. $theater['Zip'] .'</h5><br>
                            <h5><b>Adult Tickets</b>: '. $order['Adults'] .'</h5><br>
                            <h5><b>Children Tickets</b>: '. $order['Children'] .'</h5><br>
                            <h5><b>Senior Tickets</b>: '. $order['Seniors'] .'</h5><br>
                            <h5><b>Cost</b>: $'. $order['Cost'] .'</h5><br>
                        </div>
                     </div>
              ';
          }
          echo '
          <br><br><br>
          <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
              <div class="back-button">
                  <a href="./orderhistory.php" class="btn btn-default btn-lg">
                      Back
                  </a>
              </div>
          </div>
          ';
          if($order['Status'] == "unused") {
              echo '
              <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                  <div class="cancel-button">
                      <a href="./cancelorder.php?orderid='. $orderid .'" class="btn btn-default btn-lg">
                          Cancel Order
                      </a>
                  </div>
              </div>
              ';
          }

          ?>
        </div>
      </body>

    </html>
