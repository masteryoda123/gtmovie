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
  
  if (isset($_POST['ownerName']) && isset($_POST['cardNumber']) && isset($_POST['CVV']) && isset($_POST['expDate'])) {
    $ownerName = $_POST['ownerName'];
    $cardNumber = $_POST['cardNumber'];
    $cvv = $_POST['CVV'];
    $expirationDate = $_POST['expDate'] . '-01';
    $saved = ((isset($_POST['saveCard'])&& $_POST['saveCard'] == 1)) ? $_POST['saveCard'] : 0;
    $addNewCard = insertNewPaymentMethod($username, $ownerName, $cardNumber, $cvv, $expirationDate, $saved);
    if ($addNewCard) {
      $cardNum = $cardNumber;
    } else {
      //Your payment information was not accepted, please try again.
      executeJS('alert("({$username}, {$ownerName}, {$cardNumber}, {$cvv}, {$expDate}, {$saved})");');
      RedirectJS('./choosetheater.php?movieId=' . $movieId);
      exit();
    }
  } else {
    executeJS('alert("Please select a saved card or provide all the requested information for a new card.");');
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
          <form class="margin-tb-lg" action="placeorder.php" method="post" id="form">
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
              <input type="hidden" name="cardNum" value="<?php echo $cardNum?>">
            </div>
          </form>
          <?php executeJQuery('$("#form").submit()'); ?>
        </div>
      </body>

    </html>

