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
        <div class="container max-width-md">
          <div class="align-ctr">
            <a href="./logout.php" class="btn btn-link font-sz-md">Logout</a>
          </div>
          <h1 class="text-center">My Preferred Theaters</h1>
          <form action="my_preferred_theater_delete.php" method="post">
            <?php // put your HTML stuff here
              include 'db.php';

              $username = $_SESSION['user']['name'];
              $theaterPreferences = fetchTheaterPreferencesByUsername($username);
              $theaters = array_map(function($theaterPreference) {
                return fetchTheaterById($theaterPreference['Theater_id']);
              }, $theaterPreferences);

              echo '<div class="radio font-sz-md">';
                array_map(function($theater) {
                  echo '
                    <label class="margin-tb-sm"><input type="radio" name="theaterId" value="' . $theater['Theater_id'] . '">'
                      . $theater['Theater_name'] . '<br>'
                      . $theater['Street_number'] 
                      . ' ' . $theater['Street_name'] 
                      . ', ' . $theater['City'] 
                      . ', ' . $theater['State'] 
                      . ' ' . $theater['Zip']
                    .'</label>
                '; }, $theaters);
              echo '</div>';


            ?>
            <div class="align-ctr">
              <input type="submit" class="btn btn-default btn-lg" value="Delete">
              <a href="./me.php" class="btn btn-default btn-lg">
                Back
              </a>
            </div>
          </form>
        </div>
      </body>

    </html>

