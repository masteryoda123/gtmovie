<?php
    $TICKET_PRICE = 11.54;

    function Redirect($url, $permanent = false)
    {
      header('Location: ' . $url, true, $permanent ? 301 : 302);
      exit();
    }

    function RedirectJS($url)
    {
      echo "<script type='text/javascript'>window.location.href='" . $url . "';</script>";
      exit();
    }

    function executeJS($js) {
      echo '<script type="text/javascript">' . $js . '</script>';
    }

    function executeJQuery($jquery) {
      $script = '$(document).ready(function() {'
        . $jquery
        . '});';
      executeJS($script);
    }

    function movieLengthToString($mins) {
      $hours = round($mins / 60);
      $mins = $mins % 60;
      return $hours . ' hr ' . $mins . ' min';
    }

    function datetimeToTime($datetime) {
      $time = explode(" ", $datetime);
      $time = $time[1];

      return substr($time, 0, 5);
    }

    function datetimeToString($datetime) {
      return date('l, M d, g:ia', strtotime($datetime));
    }
?>
