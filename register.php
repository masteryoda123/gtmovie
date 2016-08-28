<?php session_start() ?>
<?php
    include "utils.php";

    $failedRegisterAttempt = FALSE;
    if(isset($_SESSION['user'])) {
        Redirect("./index.php");
    } else {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            include "db.php";

            $username = $_POST['username'];
            $password = $_POST['password'];
            $birthdate = $_POST['birthdate'];
            $confirmPassword = $_POST['confirmPassword'];
            $managerPassword = $_POST['managerPassword'];
            $email = $_POST['email'];

            if (validateInputsForManager($username, $password, $confirmPassword, $email, $managerPassword)) {
              if (insertNewManager($username, $password, $email, $managerPassword)) {
                authenticate($username, 'manager');
                Redirect("./index.php");
              } else {
                $failedRegisterAttempt = TRUE;
              }
            } elseif (validateInputsForCustomer($username, $password, $confirmPassword, $email, $birthdate)) {
              if (insertNewCustomer($username, $password, $email, $birthdate)) {
                authenticate($username, 'customer');
                Redirect("./index.php");
              } else {
                $failedRegisterAttempt = TRUE;
              }
            } else {
              $failedRegisterAttempt = TRUE;
            }
                // if (validateInputs($username, $password, $confirmPassword, $email, $birthdate)
                //         && insertNewCustomer($username, $password, $email, $birthdate) === TRUE) {
                //     $_SESSION['user'] = array(
                //         'name' => $username
                //     );
                //     Redirect("./index.php");
                // } else {
                //     $failedRegisterAttempt = TRUE;
                // }

        }
    }

    function authenticate($username, $userType) {
      $_SESSION['user'] = array(
        'name' => $username,
        'type' => $userType
      );
    }

    function validateInputsForManager($username, $password, $confirmPassword, $email, $managerPassword) {
      if (!validateInputs($username, $password, $confirmPassword, $email)) {
        return FALSE;
      }
      if ($managerPassword === "") {
        return FALSE;
      }
      return TRUE;
    }

    function validateInputsForCustomer ($username, $password, $confirmPassword, $email, $birthdate) {
      if (!validateInputs($username, $password, $confirmPassword, $email)) {
        return FALSE;
      }
      if ($birthdate === "") {
        return FALSE;
      }
      return TRUE;
    }
    
    function validateInputs($username, $password, $confirmPassword, $email) {
        if ($username === "" || $password === "" || $email === "")
            return FALSE;
        if ($password !== $confirmPassword)
            return FALSE;
        return TRUE;
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
        <script src="static/js/jquery-3.0.0.min.js"></script>
    </head>
    <body>
        <!--[if lt IE 8]>
          <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browserhappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <div class="container">
            <form action="./register.php" method="post" class="login-form">
                <h2>Register</h2>
                <input type="text" name="username" class="form-control register-input" placeholder="username" autofocus />
                <input type="text" name="birthdate" class="form-control register-input" placeholder="yyyy-mm-dd" />
                <input type="text" name="email" class="form-control register-input" placeholder="email" />
                <input type="password" name="password" class="form-control register-input" placeholder="password" />
                <input type="password" name="confirmPassword" class="form-control register-input" placeholder="confirm password" />
                <input type="password" name="managerPassword" class="form-control register-input" placeholder="manager password" />
                <div class="login-button-wrapper">
                    <button type="submit" id="register-button" class="btn btn-lg btn-primary btn-block login-button">Register</button>
                    <a href="./index.php" id="register-cancel" class="btn btn-lg btn-danger btn-block login-button">Cancel</a>
                </div>
                <?php
                    if ($failedRegisterAttempt === TRUE) {
                        echo '<p class="text-danger">
                                <strong>Registration Failed. Please Try Again.</strong>
                            </p>';
                    }
                ?>

            </form>
        </div>
    </body>
</html>
