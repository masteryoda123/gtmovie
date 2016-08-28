USE gtmovie;
-- SELECT Adults, Seniors, Children, Theater_id, Movie_id, View_TimeAndDate, Customer_username, Card_number
-- FROM Ticket_Order
-- INTO OUTFILE '/var/lib/mysql-files/orders.csv'
-- COLUMNS TERMINATED BY ',' LINES TERMINATED BY '\n';
DROP DATABASE IF EXISTS temp;
CREATE DATABASE temp;
USE temp;
CREATE TABLE New_Order (
	Adults TINYINT NOT NULL,
	Seniors TINYINT NOT NULL,
	Children TINYINT NOT NULL,
  Theater_id INT NOT NULL,
	Movie_id INT NOT NULL,
  View_TimeAndDate DATETIME NOT NULL,
  Customer_username VARCHAR(30) NOT NULL,
	Card_number BIGINT NOT NULL
);
LOAD DATA INFILE '/var/lib/mysql-files/orders.csv' INTO TABLE New_Order
COLUMNS TERMINATED BY ','
LINES TERMINATED BY '\n'
(Adults, Seniors, Children, Theater_id, Movie_id, @timedate, Customer_username, Card_number)
SET View_TimeAndDate = (SUBDATE(@timedate, INTERVAL 22 DAY));
LOAD DATA INFILE '/var/lib/mysql-files/orders.csv' INTO TABLE New_Order
COLUMNS TERMINATED BY ','
LINES TERMINATED BY '\n'
(Adults, Seniors, Children, Theater_id, Movie_id, @timedate, Customer_username, Card_number)
SET View_TimeAndDate = (ADDDATE(@timedate, INTERVAL 21 DAY));
SELECT Adults, Seniors, Children, Theater_id, Movie_id, View_TimeAndDate, Customer_username, Card_number
FROM New_Order
WHERE DATE(View_TimeAndDate)<ADDDATE(CURDATE(), INTERVAL 7 DAY)
INTO OUTFILE '/var/lib/mysql-files/new_orders.csv'
COLUMNS TERMINATED BY ',' LINES TERMINATED BY '\n';



