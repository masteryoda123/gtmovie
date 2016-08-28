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
  $cost = $_POST['cost'];
  
  if (!isset($_POST['cardNum'])) {
    executeJS('alert("Please select a saved card or provide all the requested information for a new card.");');
    redirectJS('./choosetheater.php?movieId=' . $movieId);
    exit();
  } else {
    $cardNum = $_POST['cardNum'];
  }


  //insertTicketOrder($username, $movieID, $theaterID, $timedate, $adults, $seniors, $children, $cost,  $cardNum)
  
  $newOrderID = insertTicketOrder($username, $movieId, $theaterId, $datetime, $qtyAdult, $qtySenior, $qtyChild, $cost, $cardNum);
  if (!$newOrderID) {
    executeJS('alert("Your ticket order was not accepted, please try again.");');
    RedirectJS('./choosetheater.php?movieId=' . $movieId);
    exit();
  }
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
      </head>
      <body>
        <!--[if lt IE 8]>
          <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browserhappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <div class="container">
          <form class="margin-tb-lg" action="<?php echo 'orderconfirmation.php?orderId=' . $newOrderID ?>" method="post" id="form">
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
          </form>
          <?php executeJS('$("#form").submit()'); ?>
        </div>
      </body>

    </html>

