<?php 
    include "validate_session.php";
    include 'db.php';

    $searchWord = $_POST['search'];
    $movieId = $_POST['movieId'];
    $theaters = fetchTheatersBySearchWord($searchWord);

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
          <h1 class="text-center">Results</h1>
          <form class="margin-tb-lg" method="post" action="./selecttime.php" id="form">
            <?php
              array_map(function ($theater) {
                echo '<div class="radio font-sz-md">
                  <label><input type="radio" name="theaterId" value="' . $theater['Theater_id'] . '">'
                  . $theater['Theater_name'] . '<br>'
                  . $theater['Street_number'] . ' '
                  . $theater['Street_name'] . ', '
                  . $theater['City'] . ', '
                  . $theater['State'] . ' '
                  . $theater['Zip']
                  . '</label>
                </div>';
              }, $theaters);
            ?>
            <div class="margin-tb-xl">
              <label class="checkbox"><input name="saveTheater" type="checkbox" value="1">Save this Theater</label>
              <input value="Next" name="submit" type="submit" class="btn btn-default btn-md">
            </div>
            <input type="hidden" name="movieId" value="<?php echo $movieId ?>"></input>
          </form>
        </div>
      </body>

    </html>

