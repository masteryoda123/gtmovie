<?php
  $host = "127.0.0.1";
  $username = "gtmovieuser";
  $password = "gtmoviepass";
  $database = "gtmovie";

  // $conn = new mysqli($servername, $username, $password, $database);
  $conn = new mysqli($host, $username, $password, $database, 3306);




  // Check connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }
  // echo "Database: Connected successfully" . PHP_EOL;


  function createTableUser($args) {
      $querystring = "CREATE TABLE user ("
          . "ID int PRIMARY KEY NOT NULL AUTO_INCREMENT, "
          . " Username varchar(25) NOT NULL, "
          . " Password varchar(25) NOT NULL)";

      query($querystring);
  }

  function dropTableUser($args) {
      $querystring = "DROP TABLE user";

      query($querystring);
  }

  function selectUser($username, $password) {
      $querystring = "SELECT * FROM User "
          . "WHERE "
          . "Username='" . $username . "' "
          . "AND "
          . "Password='" . $password . "'";

      return fetchMultiple($querystring);
  }

  function insertNewCustomer($username, $password, $email, $birthdate) {
      $querystring = "INSERT INTO User ("
          . "Username, "
          . "Password, "
          . "Email,"
          . "User_type) "
          . "VALUES("
          . "'" . $username . "', "
          . "'" . $password . "', "
          . "'" . $email . "', "
          . "'customer')";
      if (!queryInsert($querystring))
        return FALSE;
      $querystring = "INSERT INTO Customer ("
          . "Username, "
          . "Birth_date) "
          . "VALUES ("
          . "'" . $username . "', "
          . "'" . $birthdate . "')";
      return queryInsert($querystring);
  }

  function insertNewManager($username, $password, $email, $managerPassword) {
    $getTheaterID = "SELECT Theater_id FROM Manager_Passwords WHERE Manager_password='" . $managerPassword . "'";
    $managerPasswords = fetchSingle($getTheaterID);
    if ($managerPasswords == NULL) {
      return FALSE;
    }
    $theaterID = $managerPasswords['Theater_id'];
    $querystring = "INSERT INTO User ("
          . "Username, "
          . "Password, "
          . "Email,"
          . "User_type) "
          . "VALUES("
          . "'" . $username . "', "
          . "'" . $password . "', "
          . "'" . $email . "', "
          . "'manager')";
    if (!queryInsert($querystring)) {
      return FALSE;
    }
    $querystring = "INSERT INTO Manager (Username, Theater_id) VALUES("
      . "'" . $username . "', " . $theaterID . ")";

    return queryInsert($querystring);
  }

  function insertReview($movieId, $username, $rating, $title, $comment) {
    if (gettype($rating) !== 'integer'
      || gettype($title) !== 'string'
      || gettype($comment) !== 'string') {
      return FALSE;
    }

    if (!is_null(fetchReviewsByMovieIdAndUsername($movieId, $username))) {
      return FALSE;
    }

    $querystring = 'INSERT INTO Review VALUES('
      . '"' . $username . '", '
      . $movieId. ', '
      . '"' . $title. '", '
      . $rating . ', '
      . '"' . $comment . '")';
    echo $querystring;

    return queryInsert($querystring);
  }

  function insertTheaterPreference($username, $theaterId) {
    $querystring = 'INSERT INTO Theater_Preference VALUES('
      . '"' . $username . '"'
      . ', '
      . $theaterId
      . ')';

    return queryInsert($querystring);
  }

  function deleteTheaterPreference($username, $theaterId) {
    $querystring = 'DELETE FROM Theater_Preference WHERE'
      . ' Customer_username='
      . '"' . $username . '"'
      . ' AND'
      . ' Theater_id='
      . $theaterId;

    return queryDelete($querystring);
  }

  function fetchFirstSystemInfo() {
    $querystring = "SELECT * FROM System_Info LIMIT 1";

    return fetchSingle($querystring);
  }

  function fetchAllMovies() {
    $querystring = "SELECT * FROM Movie";

    return fetchMultiple($querystring);
  }

  function fetchMovieById($id) {
    $querystring = 'SELECT * FROM Movie WHERE Movie_id=' . $id;

    return fetchSingle($querystring);
  }

  function fetchGenresByMovieId($movieId) {
    $querystring = 'SELECT * FROM Movie_Genre WHERE Movie_id=' . $movieId;

    return fetchMultiple($querystring);
  }

  function fetchCastsByMovieId($movieId) {
    $querystring = 'SELECT * FROM Movie_Cast WHERE Movie_id=' . $movieId;

    return fetchMultiple($querystring);
  }

  function fetchRatingCountByMovieId($movieId) {
    $querystring = 'SELECT COUNT(*) FROM Review GROUP BY Movie_id WHERE Movie_id=' . $movieId;

    return fetchSingle($querystring);
  }

  function fetchReviewsByMovieId($movieId) {
    $querystring = 'SELECT * FROM Review WHERE Movie_id=' . $movieId;

    return fetchMultiple($querystring);
  }

  function fetchTheaterById($theaterId) {
    $querystring = 'SELECT * FROM Theater WHERE Theater_id=' . $theaterId;

    return fetchSingle($querystring);
  }

  function fetchTheatersBySearchWord($searchWord) {
    $querystring = 'SELECT * FROM Theater WHERE'
      . ' Theater_name LIKE "%' . $searchWord . '%"'
      . ' OR'
      . ' City LIKE "%' . $searchWord . '%"'
      . ' OR'
      . ' State LIKE "%' . $searchWord . '%"';

    return fetchMultiple($querystring);
  }

  function fetchReviewsByMovieIdAndUsername($movieId, $username) {
    $querystring = 'SELECT * FROM Review WHERE Movie_id=' . $movieId
      . ' AND Customer_username="' . $username . '"';

    return fetchMultiple($querystring);
  }

  function fetchOrderHistory($username) {
      $querystring = 'SELECT DISTINCT *
                        FROM Ticket_Order
                        WHERE Customer_username="' . $username . '"';

      return fetchMultiple($querystring);
  }
  function fetchOrderByID($id) {
      $querystring = 'SELECT *
                        FROM Ticket_Order
                        WHERE Order_id=' . $id .'';

      return fetchSingle($querystring);
  }


  function fetchCardByCardNumber($cardNumber) {
    $querystring = 'SELECT * FROM Payment_Method WHERE Card_number=' . $cardNumber;

    return fetchSingle($querystring);
  }
  
  function cancelOrder($orderid) {
    $querystring = <<<QST
    UPDATE Ticket_Order
    SET Status='cancelled'
    WHERE Order_id={$orderid}
QST;
    return queryUpdate($querystring);
  }

  function fetchTheaterPreferencesByUsername($username) {
    $querystring = 'SELECT * FROM Theater_Preference WHERE Customer_username="'
      . $username . '"';

    return fetchMultiple($querystring);
  }

  function fetchTheaterPreferenceByUsernameAndTheaterId($username, $theaterId) {
    $querystring = 'SELECT * FROM Theater_Preference WHERE Customer_username="'
      . $username . '"'
      . ' AND'
      . ' Theater_id=' . $theaterId;
    return fetchSingle($querystring);
  }

  function fetchScreeningsByMovieId($movieId) {
    $querystring = 'SELECT * FROM Screening WHERE Movie_id='
      . $movieId;

    return fetchMultiple($querystring);
  }

  function fetchScreeningsByTheaterIdAndMovieIdAndDate($theaterId, $movieId, $date) {
    $querystring = 'SELECT * FROM Screening WHERE'
      . ' Theater_id='
      . $theaterId
      . ' AND'
      . ' Movie_id='
      . $movieId
      . ' AND'
      . ' Time_and_date >= "'
      . $date . ' 00:00:00"'
      . ' AND'
      . ' Time_and_date <= "'
      . $date . ' 23:59:59"'
      . '';

    return fetchMultiple($querystring);
  }

  function fetchSavedCardsForCustomer($username) {
    $querystring = <<<QSTRING
    SELECT Card_number, RIGHT(CAST(Card_number AS CHAR), 4) AS lastdigits, Owner_name, Exp_date
    FROM Payment_Method
    WHERE Owner_username="{$username}" AND Saved=1
QSTRING;
    return fetchMultiple($querystring);
  }
  
  function insertNewPaymentMethod($username, $ownerName, $cardNumber, $cvv, $expDate, $saved) {
    $querystring = <<<QSTR
    INSERT INTO Payment_Method(Owner_username, Owner_name, Card_number, Cvv, Exp_date, Saved)
    VALUES("{$username}", "{$ownerName}", {$cardNumber}, {$cvv}, '{$expDate}', {$saved})
QSTR;
    return queryInsert($querystring);
  }

  function insertTicketOrder($username, $movieID, $theaterID, $timedate, $adults, $seniors, $children, $cost,  $cardNum) {
    // NOTE: this function returns the Order_id of the newly inserted order if successful
    $conn = $GLOBALS['conn'];
    $querystring = <<<QQ
    INSERT INTO Ticket_Order(Order_id, Customer_username, Movie_id, Theater_id, View_TimeAndDate, Card_number, Adults, Seniors, Children, Cost)
    VALUES(0, "{$username}", {$movieID}, {$theaterID}, '{$timedate}', {$cardNum}, {$adults}, {$seniors}, {$children}, {$cost})
QQ;
    $insertSuccessful = queryInsert($querystring);
    if ($insertSuccessful) {
      return $conn->insert_id;
    } else {
      return FALSE;
    }
  }
  
  function fetchTheaterByManager($username) {
    $querystring = <<<QSTRING
    SELECT Theater_name, Street_number, Street_name, City, State, Zip FROM Theater AS T, Manager AS M
    WHERE M.Username='{$username}' AND T.Theater_id=M.Theater_id
QSTRING;
    return fetchSingle($querystring);
  }

  function fetchRevenueReport($username) {
	  $querystring = <<<QSTRING
SELECT MONTHNAME(end_of_month) AS name_of_month, SUM(revenue) AS total_revenue
FROM ((SELECT LAST_DAY(DATE(View_TimeAndDate)) AS end_of_month, SUM(Cost) AS revenue
	  FROM Ticket_Order AS T, Manager AS M
	  WHERE M.Username="{$username}" AND T.Theater_id=M.Theater_id AND T.Status="completed"
      AND View_TimeAndDate<NOW()
	  GROUP BY LAST_DAY(DATE(View_TimeAndDate)))
	  UNION
	  (SELECT LAST_DAY(DATE(View_TimeAndDate)) AS end_of_month, 5.00*COUNT(*) AS revenue
	  FROM Ticket_Order AS T, Manager AS M
	  WHERE M.Username="{$username}" AND T.Theater_id=M.Theater_id AND T.Status="cancelled"
      AND View_TimeAndDate<NOW()
	  GROUP BY LAST_DAY(DATE(View_TimeAndDate)))) AS result
GROUP BY end_of_month
ORDER BY end_of_month ASC
LIMIT 0,3
QSTRING;
    return fetchMultiple($querystring);
  }

  function fetchPopularMovieReportMostOrders($username) {
	  $querystring = <<<QSTRING
SELECT MONTHNAME(end_of_month) AS name_of_month, title, number_of_orders
FROM ((SELECT LAST_DAY(DATE(T.View_TimeAndDate)) AS end_of_month, M.Title AS title, COUNT(*) AS number_of_orders
    FROM Ticket_Order AS T, Movie AS M, Manager AS U
    WHERE U.Username="{$username}" AND T.Theater_id=U.Theater_id AND T.Status<>"cancelled" AND M.Movie_id=T.Movie_id
      AND T.View_TimeAndDate<NOW()
    GROUP BY M.Title, end_of_month
    ORDER BY COUNT(*) DESC
    LIMIT 0,3)
    UNION
    (SELECT LAST_DAY(DATE(T.View_TimeAndDate)) AS end_of_month, M.Title AS title, COUNT(*) AS number_of_orders
    FROM Ticket_Order AS T, Movie AS M, Manager AS U
    WHERE U.Username="{$username}" AND T.Theater_id=U.Theater_id AND T.Status<>"cancelled" AND M.Movie_id=T.Movie_id
      AND LAST_DAY(DATE(T.View_TimeAndDate))=SUBDATE(LAST_DAY(CURDATE()), INTERVAL 1 MONTH)
    GROUP BY M.Title, end_of_month
    ORDER BY COUNT(*)
    LIMIT 0,3)
    UNION
    (SELECT LAST_DAY(DATE(T.View_TimeAndDate)) AS end_of_month, M.Title AS title, COUNT(*) AS number_of_orders
    FROM Ticket_Order AS T, Movie AS M, Manager AS U
    WHERE U.Username="{$username}" AND T.Theater_id=U.Theater_id AND T.Status<>"cancelled" AND M.Movie_id=T.Movie_id
      AND LAST_DAY(DATE(T.View_TimeAndDate))=SUBDATE(LAST_DAY(CURDATE()), INTERVAL 2 MONTH)
    GROUP BY M.Title, end_of_month
    ORDER BY COUNT(*) DESC
    LIMIT 0,3)) AS result
ORDER BY end_of_month ASC, number_of_orders DESC
QSTRING;
    return fetchMultiple($querystring);
  }

  function fetchPopularMovieReportMostTickets($username) {
	  $querystring = <<<QSTRING
SELECT MONTHNAME(end_of_month) AS name_of_month, title, number_of_tickets
FROM ((SELECT LAST_DAY(DATE(T.View_TimeAndDate)) AS end_of_month, M.Title AS title, SUM(T.Adults+T.Seniors+T.Children) AS number_of_tickets
    FROM Ticket_Order AS T, Movie AS M, Manager AS U
    WHERE U.Username="{$username}" AND T.Theater_id=U.Theater_id AND T.Status<>"cancelled" AND M.Movie_id=T.Movie_id
      AND T.View_TimeAndDate<NOW()
    GROUP BY M.Title, end_of_month
    ORDER BY number_of_tickets DESC
    LIMIT 0,3)
    UNION
    (SELECT LAST_DAY(DATE(T.View_TimeAndDate)) AS end_of_month, M.Title AS title, SUM(T.Adults+T.Seniors+T.Children) AS number_of_tickets
    FROM Ticket_Order AS T, Movie AS M, Manager AS U
    WHERE U.Username="{$username}" AND T.Theater_id=U.Theater_id AND T.Status<>"cancelled" AND M.Movie_id=T.Movie_id
      AND LAST_DAY(DATE(T.View_TimeAndDate))=SUBDATE(LAST_DAY(CURDATE()), INTERVAL 1 MONTH)
    GROUP BY M.Title, end_of_month
    ORDER BY number_of_tickets DESC
    LIMIT 0,3)
    UNION
    (SELECT LAST_DAY(DATE(T.View_TimeAndDate)) AS end_of_month, M.Title AS title, SUM(T.Adults+T.Seniors+T.Children) AS number_of_tickets
    FROM Ticket_Order AS T, Movie AS M, Manager AS U
    WHERE U.Username="{$username}" AND T.Theater_id=U.Theater_id AND T.Status<>"cancelled" AND M.Movie_id=T.Movie_id
      AND LAST_DAY(DATE(T.View_TimeAndDate))=SUBDATE(LAST_DAY(CURDATE()), INTERVAL 2 MONTH)
    GROUP BY M.Title, end_of_month
    ORDER BY number_of_tickets DESC
    LIMIT 0,3)) AS result
ORDER BY end_of_month ASC, number_of_tickets DESC
QSTRING;
    return fetchMultiple($querystring);
  }

// function insertIntoUser($args) {
  //     $querystring = "INSERT INTO user("
  //             . "Username, "
  //             . "Password) "
  //         . "VALUES("
  //             . $username . ", "
  //             . $password . ")";
  //
  //     query($querystring);
  // }

  // function stringqueryUpdate($table, $cols, $vals) {
  //     $querystring =  "INSERT INTO " . $cols . "(";
  //     foreach ($cols as $col) {
  //         $querystring = $col . ", ";
  //     }
  //     $querystring = substr($querystring, 0, -2); // truncate comma
  //     $querystring = $querystring . ") "
  //         . "VALUES(";
  //     foreach ($vals as $val) {
  //         $querystring = $val . ", ";
  //     }
  // }

  function query($query) {
      $conn = $GLOBALS['conn'];
      if ($conn->query($query) === TRUE) {
              echo "Query { " . $query . " }: success";
      } else {
              echo "ERROR: " . $conn->error;
      }
  }

  function queryDelete($query) {
      $conn = $GLOBALS['conn'];
      return $conn->query($query);
  }

  function queryUpdate($query) {
      $conn = $GLOBALS['conn'];
      return $conn->query($query);
  }

  function queryInsert($query) {
    $conn = $GLOBALS['conn'];
    return $conn->query($query);
  }

  function fetchMultiple($query) {
      $conn = $GLOBALS['conn'];
      $queryResult = $conn->query($query);
      return $queryResult->num_rows > 0 ? $queryResult->fetch_all(MYSQLI_ASSOC) : NULL;
  }

  function fetchSingle($query) {
      $conn = $GLOBALS['conn'];
      $queryResult = $conn->query($query);
      return $queryResult->num_rows == 1 ? $queryResult->fetch_all(MYSQLI_ASSOC)[0] : NULL;
  }


?>
