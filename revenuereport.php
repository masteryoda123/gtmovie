
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
<?php // put your HTML stuff here 
include "db.php";
$manager = $_SESSION['user']['name'];
$theater = fetchTheaterByManager($manager);
$report = fetchRevenueReport($manager);
echo <<<NAMETBD
<h1 class="align-ctr">Revenue Report for<br>{$theater['Theater_name']}<br>{$theater['Street_number']} {$theater['Street_name']}<br>{$theater['City']}, {$theater['State']} {$theater['Zip']}</h1><br>         
<table align="center" bgcolor="darkgray" border="2" cellspacing="4" cellpadding="5">
<tr><th>Month</th><th>Revenue</th></tr>
NAMETBD;
array_map(function($data) {
echo <<<TABLEROW
<tr><td>{$data['name_of_month']}</td><td>{$data['total_revenue']}</td></tr>
TABLEROW;
}, $report);
echo "</table>"
?>

          <div class="align-ctr">
            <a href="./managerhome.php" class="btn btn-default btn-lg">
              Back
            </a>
          </div>
        </div>
      </body>

    </html>

