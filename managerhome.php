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
		  <div class="align-ctr">
            <a href="./logout.php" class="btn btn-link font-sz-md">Logout</a>
          </div>
<?php
include "db.php";
$manager = $_SESSION['user']['name'];
echo <<<IDKWHATTONAMETHIS
<h1 class="align-ctr">Welcome, <br>{$_SESSION['user']['name']}</h1><br>
<h1 class="align-ctr">Select a report to view.</h1><br>
IDKWHATTONAMETHIS;
?>
          
          <h3 class="align-ctr">
            <a href="./revenuereport.php" class="btn btn-link font-sz-lg font-bold">Revenue Report</a>
          </h3>
          <h3 class="align-ctr">
            <a href="./popularmoviereport.php" class="btn btn-link font-sz-lg font-bold">Popular Movie Report</a>
          </h3>
        </div>
      </body>

    </html>

