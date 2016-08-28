USE gtmovie;
/* User */
DELETE FROM User;
INSERT INTO User(
  Username,
  Password,
  Email,
  User_type
) VALUES(
  'user',
  'pass',
  'user@gtmovie.com',
  'customer'
);
INSERT INTO User(
  Username,
  Password,
  Email,
  User_type
) VALUES(
  'yoda',
  'yoda',
  'yoda@gtmovie.com',
  'customer'
);
INSERT INTO User(
  Username,
  Password,
  Email,
  User_type
) VALUES(
  'regal',
  'regal',
  'regal@cinemas.com',
  'manager'
);
INSERT INTO User(
  Username,
  Password,
  Email,
  User_type
) VALUES(
  'amc',
  'amc',
  'amc@cinemas.com',
  'manager'
);
INSERT INTO User(
  Username,
  Password,
  Email,
  User_type
) VALUES(
  'carmike',
  'carmike',
  'carmike@cinemas.com',
  'manager'
);
INSERT INTO User(
  Username,
  Password,
  Email,
  User_type
) VALUES(
  'aurora',
  'aurora',
  'aurora@cinemas.com',
  'manager'
);

/* Customer */
DELETE FROM Customer;
INSERT INTO Customer(
  Username,
  Birth_date
) VALUES(
  'user',
  '1995-01-01'
);
INSERT INTO Customer(
  Username,
  Birth_date
) VALUES(
  'yoda',
  '1994-01-01'
);

/* Manager */
DELETE FROM Manager;
INSERT INTO Manager(
  Username,
  Theater_id
) SELECT
  'regal',
  Theater.Theater_id
FROM Theater
WHERE Theater_name LIKE '%Regal%'
LIMIT 1;
INSERT INTO Manager(
  Username,
  Theater_id
) SELECT
  'amc',
  Theater.Theater_id
FROM Theater
WHERE Theater_name LIKE '%AMC%'
LIMIT 1;
INSERT INTO Manager(
  Username,
  Theater_id
) SELECT
  'carmike',
  Theater.Theater_id
FROM Theater
WHERE Theater_name LIKE '%Carmike%'
LIMIT 1;
INSERT INTO Manager(
  Username,
  Theater_id
) SELECT
  'aurora',
  Theater.Theater_id
FROM Theater
WHERE Theater_name LIKE '%Aurora%'
LIMIT 1;

/* Movies */
DELETE FROM Movie;
INSERT INTO Movie(
  Title,
  Release_year,
  Length,
  Synopsis,
  Content_rating,
  Average_rating
) VALUES(
  'X-Men: Apocalypse',
  '2016',
  125,
  'The X-Men are forced to confront an ancient mutant called Apocalypse (Oscar Isaac) in this comic-book adventure set in the 1980s. Eager to take over the world and remake it in his own image, Apocalypse recruits mutants to act as his powerful "Four Horsemen" -- among them is the tortured Magneto (Michael Fassbender), who believes humanity might be a lost cause after a personal tragedy. In time, Charles Xavier (James McAvoy) and his charges must work together to save the planet from this threat. New additions to this X-Men team include the elusive Nightcrawler (Kodi Smit-McPhee), fiery Cyclops (Tye Sheridan), and telepathically gifted Jean Grey (Sophie Turner). Rose Byrne, Jennifer Lawrence, and Olivia Munn co-star. ~ Jack Rodgers, Rovi',
  'PG-13',
  4.1
);
INSERT INTO Movie(
  Title,
  Release_year,
  Length,
  Synopsis,
  Content_rating,
  Average_rating
) VALUES(
  'Inception',
  '2010',
  148,
  'A thief, who steals corporate secrets through use of dream-sharing technology, is given the inverse task of planting an idea into the mind of a CEO.',
  'PG-13',
  8.8
);
INSERT INTO Movie(
  Title,
  Release_year,
  Length,
  Synopsis,
  Content_rating,
  Average_rating
) VALUES(
  'Deadpool',
  '2016',
  108,
  'A former Special Forces operative turned mercenary is subjected to a rogue experiment that leaves him with accelerated healing powers, adopting the alter ego Deadpool.',
  'R',
  8.1
);
INSERT INTO Movie(
  Title,
  Release_year,
  Length,
  Synopsis,
  Content_rating,
  Average_rating
) VALUES(
  'Finding Dory',
  '2016',
  105,
  'The friendly-but-forgetful blue tang fish begins a search for her long-lost parents, and everyone learns a few things about the real meaning of family along the way.',
  'PG',
  7.9
);
INSERT INTO Movie(
  Title,
  Release_year,
  Length,
  Synopsis,
  Content_rating,
  Average_rating
) VALUES(
  'Ghostbusters',
  '2016',
  117,
  'Paranormal researcher Abby Yates (Melissa McCarthy) and physicist Erin Gilbert are trying to prove that ghosts exist in modern society. When strange apparitions appear in Manhattan, Gilbert and Yates turn to engineer Jillian Holtzmann for help. Also joining the team is Patty Tolan, a lifelong New Yorker who knows the city inside and out. Armed with proton packs and plenty of attitude, the four women prepare for an epic battle as more than 1,000 mischievous ghouls descend on Times Square.',
  'PG-13',
  4.4
);

/* Review */
DELETE FROM Review;
INSERT INTO Review(
  Username,
  Movie_id,
  Review_title,
  Rating,
  Comment
) SELECT 
  'yoda',
  Movie_id,
  'Garbage Movie',
  4,
  'One of the worst movie Ive seen. Do not waste your money.'
FROM Movie
WHERE Title='Deadpool';
INSERT INTO Review(
  Username,
  Movie_id,
  Review_title,
  Rating,
  Comment
) SELECT 
  'user',
  Movie_id,
  'Awesome Movie!!!!',
  10,
  'Deadpool is a triumph of artistic vision over studio interference. Little credit should be given to 20th Century Fox, as they had zero faith in the success of a Deadpool movie. To put things into perspective, Ryan Reynolds fought for this film back in 2004 when Blade: Trinity was released. Reynolds and co. went to shoot test footage that was then leaked online by Reynolds because Fox had no intentions to release it to the public. Finally, after years and years of BEGGING to the studio and the overwhelming positive responses of the test footage from the public, Fox didn\'t even tell Reynolds and co. that the film was greenlit. They had to find out online like the rest of us plebeians. If that sounds bad, Fox even cut their budget by $7 million AT THE LAST MINUTE, which caused the writers to scratch some action sequences that I\'m sure would\'ve been great to see.'
FROM Movie
WHERE Title='Deadpool';

/* Genre */
DELETE FROM Movie_Genre;
INSERT INTO Movie_Genre(
  Movie_id,
  Genre
) SELECT
  Movie_id,
  'Action'
FROM Movie
WHERE Title LIKE '%Deadpool%'
LIMIT 1;
INSERT INTO Movie_Genre(
  Movie_id,
  Genre
) SELECT
  Movie_id,
  'Adventure'
FROM Movie
WHERE Title LIKE '%Deadpool%'
LIMIT 1;
INSERT INTO Movie_Genre(
  Movie_id,
  Genre
) SELECT
  Movie_id,
  'Romance'
FROM Movie
WHERE Title LIKE '%Dory%'
LIMIT 1;
INSERT INTO Movie_Genre(
  Movie_id,
  Genre
) SELECT
  Movie_id,
  'Comedy'
FROM Movie
WHERE Title LIKE '%Dory%'
LIMIT 1;
INSERT INTO Movie_Genre(
  Movie_id,
  Genre
) SELECT
  Movie_id,
  'Mystery'
FROM Movie
WHERE Title LIKE '%Inception%'
LIMIT 1;
INSERT INTO Movie_Genre(
  Movie_id,
  Genre
) SELECT
  Movie_id,
  'Adventure'
FROM Movie
WHERE Title LIKE '%Inception%'
LIMIT 1;
INSERT INTO Movie_Genre(
  Movie_id,
  Genre
) SELECT
  Movie_id,
  'Action'
FROM Movie
WHERE Title LIKE '%X-Men%'
LIMIT 1;
INSERT INTO Movie_Genre(
  Movie_id,
  Genre
) SELECT
  Movie_id,
  'Adventure'
FROM Movie
WHERE Title LIKE '%X-Men%'
LIMIT 1;
INSERT INTO Movie_Genre(
  Movie_id,
  Genre
) SELECT
  Movie_id,
  'Thriller'
FROM Movie
WHERE Title LIKE '%Ghostbusters%'
LIMIT 1;
INSERT INTO Movie_Genre(
  Movie_id,
  Genre
) SELECT
  Movie_id,
  'Comedy'
FROM Movie
WHERE Title LIKE '%Ghostbusters%'
LIMIT 1;

/* Cast */
DELETE FROM Movie_Cast;
INSERT INTO Movie_Cast(
  Movie_id,
  Actor
) SELECT
  Movie_id,
  'Leonardo DiCaprio'
FROM Movie
WHERE Title LIKE '%Inception%'
LIMIT 1;
INSERT INTO Movie_Cast(
  Movie_id,
  Actor
) SELECT
  Movie_id,
  'Tom Hardy'
FROM Movie
WHERE Title LIKE '%Inception%'
LIMIT 1;
INSERT INTO Movie_Cast(
  Movie_id,
  Actor
) SELECT
  Movie_id,
  'Ellen Page'
FROM Movie
WHERE Title LIKE '%Inception%'
LIMIT 1;
INSERT INTO Movie_Cast(
  Movie_id,
  Actor
) SELECT
  Movie_id,
  'Joseph Gordon-Levitt'
FROM Movie
WHERE Title LIKE '%Inception%'
LIMIT 1;
INSERT INTO Movie_Cast(
  Movie_id,
  Actor
) SELECT
  Movie_id,
  'Ryan Reynolds'
FROM Movie
WHERE Title LIKE '%Deadpool%'
LIMIT 1;
INSERT INTO Movie_Cast(
  Movie_id,
  Actor
) SELECT
  Movie_id,
  'Morena Baccarin'
FROM Movie
WHERE Title LIKE '%Deadpool%'
LIMIT 1;
INSERT INTO Movie_Cast(
  Movie_id,
  Actor
) SELECT
  Movie_id,
  'Gina Carano'
FROM Movie
WHERE Title LIKE '%Deadpool%'
LIMIT 1;
INSERT INTO Movie_Cast(
  Movie_id,
  Actor
) SELECT
  Movie_id,
  'Jennifer Lawrence'
FROM Movie
WHERE Title LIKE '%X-Men%'
LIMIT 1;
INSERT INTO Movie_Cast(
  Movie_id,
  Actor
) SELECT
  Movie_id,
  'Sophie Turner'
FROM Movie
WHERE Title LIKE '%X-Men%'
LIMIT 1;
INSERT INTO Movie_Cast(
  Movie_id,
  Actor
) SELECT
  Movie_id,
  'James McAvoy'
FROM Movie
WHERE Title LIKE '%X-Men%'
LIMIT 1;
INSERT INTO Movie_Cast(
  Movie_id,
  Actor
) SELECT
  Movie_id,
  'Ellen DeGeneres'
FROM Movie
WHERE Title LIKE '%Dory%'
LIMIT 1;
INSERT INTO Movie_Cast(
  Movie_id,
  Actor
) SELECT
  Movie_id,
  'Ty Burrell'
FROM Movie
WHERE Title LIKE '%Dory%'
LIMIT 1;
INSERT INTO Movie_Cast(
  Movie_id,
  Actor
) SELECT
  Movie_id,
  'Albert Brooks'
FROM Movie
WHERE Title LIKE '%Dory%'
LIMIT 1;

/* Theater */
DELETE FROM Theater;
INSERT INTO Theater(
  Theater_name,
  Street_number,
  Street_name,
	City,
	State,
	Zip 
) VALUES(
  'Regal Atlantic Station',
  123,
  'Atlantic Dr',
  'Atlanta',
  'GA',
  30313
);
INSERT INTO Theater(
  Theater_name,
  Street_number,
  Street_name,
	City,
	State,
	Zip 
) VALUES(
  'AMC Rosell 12',
  447,
  'AMC Boulevard',
  'Roswell',
  'GA',
  30412
);
INSERT INTO Theater(
  Theater_name,
  Street_number,
  Street_name,
	City,
	State,
	Zip 
) VALUES(
  'Carmike Crossroads 1549',
  1549,
  'Hudson Ave',
  'Snellville',
  'GA',
  39812
);
INSERT INTO Theater(
  Theater_name,
  Street_number,
  Street_name,
	City,
	State,
	Zip 
) VALUES(
  'Aurora Cineplex',
  17,
  'Pine Aurora St',
  'Atlanta',
  'GA',
  30332
);

/* Theater Preference */
DELETE FROM Theater_Preference;
INSERT INTO Theater_Preference(
  Customer_username,
  Theater_id
) SELECT
  'yoda',
  Theater_id
FROM Theater
WHERE Theater_name LIKE '%amc%'
LIMIT 1;
INSERT INTO Theater_Preference(
  Customer_username,
  Theater_id
) SELECT
  'user',
  Theater_id
FROM Theater
WHERE Theater_name LIKE '%carmike%'
LIMIT 1;

/* Screening */
DELETE FROM Screening;
INSERT INTO Screening(
  Theater_id,
  Movie_id,
  Time_and_date
) SELECT
  Theater_id,
  movie_id,
  '2016-07-28 11:20:00'
from theater, movie
where theater.theater_name like '%amc%'
and movie.title like 'deadpool';
insert into screening(
  theater_id,
  movie_id,
  time_and_date
) select
  theater_id,
  movie_id,
  '2016-07-28 13:45:00'
from theater, movie
where theater.theater_name like '%amc%'
and movie.title like 'deadpool';
insert into screening(
  theater_id,
  movie_id,
  time_and_date
) select
  theater_id,
  movie_id,
  '2016-07-29 10:30:00'
from theater, movie
where theater.theater_name like '%amc%'
and movie.title like 'deadpool';
insert into screening(
  theater_id,
  movie_id,
  time_and_date
) select
  theater_id,
  movie_id,
  '2016-07-30 14:00:00'
from theater, movie
where theater.theater_name like '%amc%'
and movie.title like 'deadpool';
INSERT INTO Screening(
  Theater_id,
  Movie_id,
  Time_and_date
) SELECT
  Theater_id,
  movie_id,
  '2016-07-28 11:20:00'
from theater, movie
where theater.theater_name like '%carmike%'
and movie.title like 'deadpool';
insert into screening(
  theater_id,
  movie_id,
  time_and_date
) select
  theater_id,
  movie_id,
  '2016-07-28 13:45:00'
from theater, movie
where theater.theater_name like '%carmike%'
and movie.title like 'deadpool';
insert into screening(
  theater_id,
  movie_id,
  time_and_date
) select
  theater_id,
  movie_id,
  '2016-07-29 10:30:00'
from theater, movie
where theater.theater_name like '%carmike%'
and movie.title like 'deadpool';
insert into screening(
  theater_id,
  movie_id,
  time_and_date
) select
  theater_id,
  movie_id,
  '2016-07-30 14:00:00'
from theater, movie
where theater.theater_name like '%carmike%'
and movie.title like 'deadpool';

/* System Info */
INSERT INTO System_Info (
  Cancellation_fee,
  Senior_discount,
  Child_discount
) VALUES (
  5.0,
  0.2,
  0.3
);

