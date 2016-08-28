<?php
    session_start();
    
    include "utils.php";

    if(!isset($_SESSION['user'])) {
        Redirect("./login.php");
    }
?>
