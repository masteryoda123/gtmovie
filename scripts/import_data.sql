USE gtmovie;
LOAD DATA INFILE '/var/lib/mysql-files/System_Info.csv' INTO TABLE System_Info
COLUMNS TERMINATED BY ','
LINES TERMINATED BY '\n'
IGNORE 1 LINES
(Cancellation_fee, Senior_discount, Child_discount);
LOAD DATA INFILE '/var/lib/mysql-files/User.csv' INTO TABLE User
COLUMNS TERMINATED BY ','
LINES TERMINATED BY '\n'
IGNORE 1 LINES
(Username, Password, Email, User_type);
LOAD DATA INFILE '/var/lib/mysql-files/Customer.csv' INTO TABLE Customer
COLUMNS TERMINATED BY ','
LINES TERMINATED BY '\n'
IGNORE 1 LINES
(Username, Birth_date);
LOAD DATA INFILE '/var/lib/mysql-files/Theater.csv' INTO TABLE Theater
COLUMNS TERMINATED BY ','
LINES TERMINATED BY '\n'
IGNORE 1 LINES
(Theater_id, Theater_name, Street_number, Street_name, City, State, Zip);
LOAD DATA INFILE '/var/lib/mysql-files/Manager_Passwords.csv' INTO TABLE Manager_Passwords
COLUMNS TERMINATED BY ','
LINES TERMINATED BY '\n'
IGNORE 1 LINES
(Cancellation_fee, Manager_password, @theater_name, @street_number, @street_name, @city, @state, @zip)
SET Theater_id = (SELECT Theater_id FROM Theater WHERE Theater_name=@theater_name AND Street_number=CAST(@street_number AS UNSIGNED)
                  AND Street_name=@street_name AND City=@city AND State=@state AND Zip=@zip);
LOAD DATA INFILE '/var/lib/mysql-files/Manager.csv' INTO TABLE Manager
COLUMNS TERMINATED BY ','
LINES TERMINATED BY '\n'
IGNORE 1 LINES
(Username, @manager_password)
SET Theater_id = (SELECT Theater_id FROM Manager_Passwords WHERE Manager_Password=@manager_password);
LOAD DATA INFILE '/var/lib/mysql-files/Movie.csv' INTO TABLE Movie
COLUMNS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '"'
LINES TERMINATED BY '\n'
IGNORE 1 LINES
(Movie_id, Title, Release_year, Length, Synopsis, Content_rating, Average_rating);
LOAD DATA INFILE '/var/lib/mysql-files/Screening.csv' INTO TABLE Screening
COLUMNS TERMINATED BY ','
LINES TERMINATED BY '\n'
IGNORE 1 LINES
(@manager_username, @title, @release_year, Time_and_date)
SET Theater_id = (SELECT Theater_id FROM Manager WHERE Username=@manager_username),
    Movie_id = (SELECT Movie_id FROM Movie WHERE Title=@title AND Release_year=@release_year);
LOAD DATA INFILE '/var/lib/mysql-files/Screening.csv' INTO TABLE Screening
COLUMNS TERMINATED BY ','
LINES TERMINATED BY '\n'
IGNORE 1 LINES
(@manager_username, @title, @release_year, @timedate)
SET Theater_id = (SELECT Theater_id FROM Manager WHERE Username=@manager_username),
    Movie_id = (SELECT Movie_id FROM Movie WHERE Title=@title AND Release_year=@release_year),
    Time_and_date = (SUBDATE(@timedate, INTERVAL 22 DAY));
LOAD DATA INFILE '/var/lib/mysql-files/Screening.csv' INTO TABLE Screening
COLUMNS TERMINATED BY ','
LINES TERMINATED BY '\n'
IGNORE 1 LINES
(@manager_username, @title, @release_year, @timedate)
SET Theater_id = (SELECT Theater_id FROM Manager WHERE Username=@manager_username),
    Movie_id = (SELECT Movie_id FROM Movie WHERE Title=@title AND Release_year=@release_year),
    Time_and_date = (ADDDATE(@timedate, INTERVAL 21 DAY));
LOAD DATA INFILE '/var/lib/mysql-files/Payment_Method.csv' INTO TABLE Payment_Method
COLUMNS TERMINATED BY ','
LINES TERMINATED BY '\n'
IGNORE 1 LINES
(Owner_username, Card_number, Exp_date, Cvv, Owner_name, Saved);