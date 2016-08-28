<?php 
    include "validate_session.php";
    include "db.php";

    $title = $_POST['title'];
    $rating = (int) $_POST['rating'];
    $comment = $_POST['comment'];
    $username = $_SESSION['user']['name'];
    $movieId = (int) $_POST['movieId'];

    if ($title === ''
      || $comment === '') {
      RedirectJS('./givereview.php?movieId=' . $movieId);
    }

    if (insertReview($movieId, $username, $rating, $title, $comment)) {
      RedirectJS('./review.php?movieId=' . $movieId);
    }
    RedirectJS('./givereview.php?movieId=' . $movieId);

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
        </div>
      </body>

    </html>

