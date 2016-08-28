
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
          <div class="align-ctr">
<?php // put your HTML stuff here 
include "db.php";
$manager = $_SESSION['user']['name'];
$theater = fetchTheaterByManager($manager);
$report_orders = fetchPopularMovieReportMostOrders($manager);
$report_tickets = fetchPopularMovieReportMostTickets($manager);
echo <<<SOMERANDOMNAME
<h1 class="align-ctr">Popular Movie Reports for<br>{$theater['Theater_name']}<br>{$theater['Street_number']} {$theater['Street_name']}<br>{$theater['City']}, {$theater['State']} {$theater['Zip']}</h1><br>
<table align="center" bgcolor="darkgray" border="2" cellspacing="4" cellpadding="5">
<thead><tr><td colspan="3">Popular Movies by Number of Orders</td></tr></thead>
<tr><th>Month</th><th>Movie</th><th>Number of Orders</th></tr>
SOMERANDOMNAME;
array_map(function($data) {
  echo <<<MONTH
<tr><td>{$data['name_of_month']}</td><td>{$data['title']}</td><td>{$data['number_of_orders']}</td></tr>
MONTH;
}, $report_orders);
echo <<<OTHERTABLE
<table align="center" bgcolor="darkgray" border="2" cellspacing="4" cellpadding="5">
<thead><tr><td colspan="3">Popular Movies by Number of Tickets</td></tr></thead>
<tr><th>Month</th><th>Movie</th><th>Number of Tickets</th></tr>
OTHERTABLE;
array_map(function($data) {
  echo <<<MONTH
<tr><td>{$data['name_of_month']}</td><td>{$data['title']}</td><td>{$data['number_of_tickets']}</td></tr>
MONTH;
}, $report_tickets);
// array_map(function($data) {
// $months_done = array();
// if (!in_array($data['month'])) {
// $months_done[] = $data['month'];
// echo <<<MONTH
// <tr><td rowspan="3">{$data['name_of_month']}</td><td>{$data['title']}</td><td>{$data['number_of_orders']}</td></tr>
// MONTH;
// } else {
// echo <<<NOMONTH
// <tr><td>{$data['title']}</td><td>{$data['number_of_orders']}</td></tr>
// NOMONTH;
// }
// }, $report_orders);
// echo <<<OTHERTABLE
// <br>
// <table align="center" bgcolor="darkgray" border="2" cellspacing="4" cellpadding="5">
// <thead><tr><td colspan="3">Popular Movies by Number of Tickets</td></tr></thead>
// <tr><th>Month</th><th>Movie</th><th>Number of Tickets</th></tr>
// OTHERTABLE;
// array_map(function($data) {
// $months_done = array();
// if (!in_array($data['month'])) {
// $months_done[] = $data['month'];
// echo <<<MONTH
// <tr><td rowspan="3">{$data['name_of_month']}</td><td>{$data['title']}</td><td>{$data['number_of_tickets']}</td></tr>
// MONTH;
// } else {
// echo <<<NOMONTH
// <tr><td>{$data['title']}</td><td>{$data['number_of_tickets']}</td></tr>
// NOMONTH;
// }
// }, $report_tickets);
?>
          </div>
          <div class="align-ctr">
            <a href="./managerhome.php" class="btn btn-default btn-lg">
              Back
            </a>
          </div>
        </div>
      </body>

    </html>

