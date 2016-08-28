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
        <div class="container" style="overflow-y:scroll; width:100%; height:100%;">
          <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
          </div>
          <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            <h1><b>   My Payment Information</b></h1>
            <h5>Select the card you wish to delete:</h5>
            <br><br>
            <?php
               include "db.php";
               $username = $_SESSION['user']['name'];
               $cards = fetchSavedCardsForCustomer($username);
               array_map(function ($card) {
                 echo '<div class="card-button" >
                        <a href="./deletecard.php?cardnumber='. $card['Card_number'] .'" class="btn btn-default btn-lg" style="width:62.5%; text-align:left;">'
                          . '<b>Card Number</b>: ' . $card['Card_number'] . '<br>'
                          . '<b>Name on Card</b>: ' . $card['Owner_name'] . '<br>'
                          . '<b>Expiry Date</b>: ' . $card['Exp_date'] . '<br>'
                          . '</a>
                      </div>';
                 }, $cards);
            ?>
            <br><br><br>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
            </div>
              <div class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
                  <div class="back-button">
                      <a href="./me.php" class="btn btn-default btn-lg">
                          Back
                      </a>
                  </div>
              </div>
              <br><br><br>
          </div>
        </div>
      </body>

    </html>
