<?php session_start() ?>
<?php
    include "utils.php";

    $failedLoginAttempt = FALSE;
    if(isset($_SESSION['user'])) {
	Redirect("./index.php");
    } else {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            include "db.php";

            $userRows = selectUser($_POST['username'], $_POST['password']);
            if ($userRows != NULL) {
                $_SESSION['user'] = array(
                    'name' => $userRows[0]['Username'], 'type' => $userRows[0]['User_type']
                );
		if($_SESSION['user']['type'] == 'manager'){
			Redirect("./managerhome.php");
		} else {
                	Redirect("./index.php");
		}
            } else {
                $failedLoginAttempt = TRUE;
            }
        }
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
        <link rel="stylesheet" href="static/css/style.css">
        <link rel="stylesheet" href="static/css/react-bootstrap-switch.min.css">
        <link href="http://fonts.googleapis.com/css?family=Indie+Flower" rel="stylesheet" type="text/css">
    </head>
    <body>
        <!--[if lt IE 8]>
          <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browserhappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <div class="container">
            <form action="./login.php" method="post" class="login-form">
                <h2>Login</h2>
                <input type="text" name="username" id="login-username" class="form-control" placeholder="username" autofocus />
                <input type="password" name="password" id="login-password" class="form-control" placeholder="password" />
                <div class="login-button-wrapper">
                    <button type="submit" class="btn btn-lg btn-primary btn-block login-button">Log in</button>
                    <a href="./register.php" class="btn btn-lg btn-primary btn-block login-button">Sign Up</a>
                </div>
                <?php
                    if ($failedLoginAttempt === TRUE) {
                        echo '<p class="text-danger">
                                <strong>Username or password does not match any existing entry. Please try again.</strong>
                            </p>';
                    }
                ?>

            </form>
        </div>

    </body>
</html>
