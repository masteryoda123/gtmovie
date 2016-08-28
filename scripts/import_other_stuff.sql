USE gtmovie;
LOAD DATA INFILE '/var/lib/mysql-files/Ticket_Order.csv' INTO TABLE Ticket_Order
COLUMNS TERMINATED BY ','
LINES TERMINATED BY '\n'
IGNORE 1 LINES
(Order_id, Status, @adults, @seniors, @children, @manager_username, @title, @release_year, View_TimeAndDate, Customer_username, Card_number)
SET Theater_id = (SELECT Theater_id FROM Manager WHERE Username=@manager_username),
    Movie_id = (SELECT Movie_id FROM Movie WHERE Title=@title AND Release_year=@release_year),
    Adults = @adults, Seniors = @seniors, Children = @children,
    Cost = 11.54 * (@adults + @seniors*(1-(SELECT Senior_discount FROM System_Info)) + @children*(1-(SELECT Child_discount FROM System_Info)));
LOAD DATA INFILE '/var/lib/mysql-files/new_orders.csv' INTO TABLE Ticket_Order
COLUMNS TERMINATED BY ','
LINES TERMINATED BY '\n'
IGNORE 1 LINES
(Order_id, Status, @adults, @seniors, @children, Theater_id, Movie_id, View_TimeAndDate, Customer_username, Card_number)
SET Adults = @adults, Seniors = @seniors, Children = @children,
    Cost = TRUNCATE(11.54 * (@adults + @seniors*(1-(SELECT Senior_discount FROM System_Info)) + @children*(1-(SELECT Child_discount FROM System_Info))), 2);
LOAD DATA INFILE '/var/lib/mysql-files/future_orders.csv' INTO TABLE Ticket_Order
COLUMNS TERMINATED BY ','
LINES TERMINATED BY '\n'
IGNORE 1 LINES
(Order_id, Status, @adults, @seniors, @children, Theater_id, Movie_id, View_TimeAndDate, Customer_username, Card_number)
SET Adults = @adults, Seniors = @seniors, Children = @children,
    Cost = 11.54 * (@adults + @seniors*(1-(SELECT Senior_discount FROM System_Info)) + @children*(1-(SELECT Child_discount FROM System_Info)));
LOAD DATA INFILE '/var/lib/mysql-files/Review.csv' INTO TABLE Review
COLUMNS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 LINES
(Customer_username, Movie_id, Review_title, Rating, Comment);
LOAD DATA INFILE '/var/lib/mysql-files/Theater_Preference.csv' INTO TABLE Theater_Preference
COLUMNS TERMINATED BY ','
LINES TERMINATED BY '\n'
IGNORE 1 LINES
(Customer_username, @manager_username)
SET Theater_id = (SELECT Theater_id FROM Manager WHERE Username=@manager_username);
LOAD DATA INFILE '/var/lib/mysql-files/Movie_Genre.csv' INTO TABLE Movie_Genre
COLUMNS TERMINATED BY ','
LINES TERMINATED BY '\n'
IGNORE 1 LINES
(@title, @release_year, Genre)
SET Movie_id = (SELECT Movie_id FROM Movie WHERE Title=@title AND Release_year=@release_year);
LOAD DATA INFILE '/var/lib/mysql-files/Movie_Cast.csv' INTO TABLE Movie_Cast
COLUMNS TERMINATED BY ','
LINES TERMINATED BY '\n'
IGNORE 1 LINES
(@title, @release_year, Actor)
SET Movie_id = (SELECT Movie_id FROM Movie WHERE Title=@title AND Release_year=@release_year);
DELETE FROM Manager WHERE Username='regal';