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
                <h1><b>Order History</b></h1>
                <div class="row margin-tb-sm">
                <form action="./searchorder.php" method="post" class="search">
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <input type="text" name="orderid" id="orderhistory-orderid" class="form-control" placeholder="Enter Your OrderID" autofocus/>
                        <input type="submit" class="btn btn-lg btn-primary btn-block order-button">
                    </div>
                </form>
                </div>
              <?php
              include "db.php";
             $username = $_SESSION['user']['name'];
             $orders = fetchOrderHistory($username);
             array_map(function ($order) {
                 $movie = fetchMovieById($order['Movie_id']);
               echo '<div class="order-button" >
                        <a href="./orderdetail.php?orderid='. $order['Order_id'] .'" class="btn btn-default btn-lg" style="width:60%; text-align:left;">'
                             . '<b>Order ID</b>:     ' . $order['Order_id'] . '<br>'
                             . '<b>Movie Title</b>:  ' . $movie['Title'] . '<br>'
                             . '<b>Order Status</b>: ' . $order['Status'] . '<br>'
                             . '<b>Total Cost</b>: $' . $order['Cost']
                        . '</a>
                     </div>';
             }, $orders);

              ?>
              <br><br><br>
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
