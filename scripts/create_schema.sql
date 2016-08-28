DROP DATABASE IF EXISTS gtmovie;
CREATE DATABASE gtmovie;
USE gtmovie;
CREATE TABLE User (
	Username VARCHAR(30) PRIMARY KEY,
	Password VARCHAR(30) NOT NULL,
	Email VARCHAR(50) UNIQUE NOT NULL,
	User_type ENUM('customer', 'manager') NOT NULL
);
CREATE TABLE Customer (
	Username VARCHAR(30) NOT NULL,
	Birth_date DATE NOT NULL,
	FOREIGN KEY (Username) REFERENCES User(Username) ON UPDATE CASCADE
);
CREATE TABLE Theater (
	Theater_id INT AUTO_INCREMENT PRIMARY KEY,
	Theater_name VARCHAR(50) NOT NULL,
	Street_number INT NOT NULL,
	Street_name VARCHAR(50) NOT NULL,
	City VARCHAR(50) NOT NULL,
	State CHAR(2) NOT NULL,
	Zip INT NOT NULL
);
CREATE TABLE Manager (
	Username VARCHAR(30) PRIMARY KEY,
	Theater_id INT UNIQUE NOT NULL,
	FOREIGN KEY (Username) REFERENCES User(Username) ON UPDATE CASCADE,
	FOREIGN KEY (Theater_id) REFERENCES Theater(Theater_id) ON UPDATE CASCADE
);
CREATE TABLE Movie (
	Movie_id INT AUTO_INCREMENT PRIMARY KEY,
	Title VARCHAR(50) NOT NULL,
	Release_year YEAR NOT NULL,
	Length SMALLINT NOT NULL,
	Synopsis LONGTEXT NOT NULL,
	Content_rating ENUM('G', 'PG', 'PG-13', 'R', 'NC-17') NOT NULL,
	Average_rating DECIMAL(2,1)
);
CREATE TABLE Screening (
	Theater_id INT NOT NULL,
	Movie_id INT NOT NULL,
	Time_and_date DATETIME NOT NULL,
	PRIMARY KEY (Theater_id, Movie_id, Time_and_date),
	FOREIGN KEY (Theater_id) REFERENCES Theater(Theater_id) ON UPDATE CASCADE,
	FOREIGN KEY (Movie_id) REFERENCES Movie(Movie_id) ON UPDATE CASCADE
);
CREATE TABLE Payment_Method (
	Owner_username VARCHAR(30) NOT NULL,
	Card_number BIGINT PRIMARY KEY,
	Exp_date DATE NOT NULL,
	Cvv SMALLINT NOT NULL,
	Owner_name VARCHAR(30) NOT NULL,
	Saved BOOLEAN NOT NULL,
	FOREIGN KEY (Owner_username) REFERENCES Customer(Username) ON UPDATE CASCADE
);
CREATE TABLE Ticket_Order (
	Order_id INT AUTO_INCREMENT PRIMARY KEY,
	Status ENUM('unused', 'completed', 'cancelled') NOT NULL DEFAULT 'unused',
	Adults TINYINT NOT NULL,
	Seniors TINYINT NOT NULL,
	Children TINYINT NOT NULL,
	Cost DECIMAL(5,2) NOT NULL,
  Theater_id INT NOT NULL,
	Movie_id INT NOT NULL,
  View_TimeAndDate DATETIME NOT NULL,
  Customer_username VARCHAR(30) NOT NULL,
	Card_number BIGINT NOT NULL,
  FOREIGN KEY (Theater_id, Movie_id, View_TimeAndDate) REFERENCES Screening(Theater_id, Movie_id, Time_and_date) ON UPDATE CASCADE,
	FOREIGN KEY (Customer_username, Card_number) REFERENCES Payment_Method(Owner_username, Card_number) ON UPDATE CASCADE
);
CREATE TABLE Review (
	Customer_username VARCHAR(30) NOT NULL,
	Movie_id INT NOT NULL,
	Review_title VARCHAR(30) NOT NULL,
	Rating TINYINT NOT NULL,
	Comment MEDIUMTEXT,
	PRIMARY KEY (Customer_username, Movie_id),
	FOREIGN KEY (Customer_username) REFERENCES Customer(Username) ON UPDATE CASCADE,
	FOREIGN KEY (Movie_id) REFERENCES Movie(Movie_id) ON UPDATE CASCADE
);
CREATE TABLE Theater_Preference (
	Customer_username VARCHAR(30) NOT NULL,
	Theater_id INT NOT NULL,
	PRIMARY KEY (Customer_username, Theater_id),
	FOREIGN KEY (Customer_username) REFERENCES Customer(Username) ON UPDATE CASCADE,
	FOREIGN KEY (Theater_id) REFERENCES Theater(Theater_id) ON UPDATE CASCADE
);
CREATE TABLE Movie_Genre (
	Movie_id INT NOT NULL,
	Genre VARCHAR(20) NOT NULL,
	PRIMARY KEY (Movie_id, Genre),
	FOREIGN KEY (Movie_id) REFERENCES Movie(Movie_id) ON UPDATE CASCADE
);
CREATE TABLE Movie_Cast (
	Movie_id INT NOT NULL,
	Actor VARCHAR(30) NOT NULL,
	PRIMARY KEY (Movie_id, Actor),
	FOREIGN KEY (Movie_id) REFERENCES Movie(Movie_id) ON UPDATE CASCADE
);
CREATE TABLE System_Info (
	Cancellation_fee DECIMAL(3,2) PRIMARY KEY DEFAULT 5.00,
	Senior_discount DECIMAL(2,2) NOT NULL DEFAULT 0.80,
	Child_discount DECIMAL(2,2) NOT NULL DEFAULT 0.70
);
CREATE TABLE Manager_Passwords (
	Cancellation_fee DECIMAL(3,2) NOT NULL,
	Manager_password VARCHAR(30) UNIQUE NOT NULL,
	Theater_id INT UNIQUE NOT NULL,
	PRIMARY KEY (Cancellation_fee, Manager_password),
	FOREIGN KEY (Cancellation_fee) REFERENCES System_Info(Cancellation_fee) ON UPDATE CASCADE,
	FOREIGN KEY (Theater_id) REFERENCES Theater(Theater_id) ON UPDATE CASCADE
);