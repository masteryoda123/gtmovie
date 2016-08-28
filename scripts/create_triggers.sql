USE gtmovie;
delimiter ##
CREATE TRIGGER OnlyOneReviewPerMovieSeen
BEFORE INSERT ON Review FOR EACH ROW
BEGIN
	IF (NEW.Customer_username, NEW.Movie_id)
	NOT IN (SELECT Customer_username, Movie_id
			FROM Ticket_Order
			WHERE Status='completed')
		THEN SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Customers cannot review movies they have not seen.';
	ELSEIF (NEW.Customer_username, NEW.Movie_id) IN (SELECT Customer_username, Movie_id FROM Review)
		THEN SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Cannot review a movie more than once.';
	END IF;
END;##
CREATE TRIGGER OnlyOrderTicketsSevenDaysPrior
BEFORE INSERT ON Ticket_Order FOR EACH ROW
BEGIN
	IF ADDDATE(CURDATE(), INTERVAL 7 DAY) < DATE(NEW.View_TimeAndDate)
		THEN SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Cannot place ticket order more than a week before viewing date.';
	END IF;
END;##
CREATE TRIGGER CantPayWithExpiredCard
BEFORE INSERT ON Ticket_Order FOR EACH ROW
FOLLOWS OnlyOrderTicketsSevenDaysPrior
BEGIN
	IF CURDATE() >= (SELECT Exp_date
					 FROM Payment_Method
					 WHERE Card_number=NEW.Card_number)
		THEN SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Cannot pay with an expired card.';
	END IF;
END;##
CREATE TRIGGER OnlyCancelUnusedOrders
BEFORE UPDATE ON Ticket_Order FOR EACH ROW
BEGIN
	IF NEW.Status='cancelled' AND OLD.Status<>'unused'
		THEN SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Only unused orders can be cancelled.';
	END IF;
END;##
CREATE TRIGGER UpdateAverageRating
AFTER INSERT ON Review FOR EACH ROW
BEGIN
  UPDATE Movie
  SET Average_rating = (SELECT AVG(Rating)
                              FROM Review
                              WHERE Review.Movie_id=NEW.Movie_id)
  WHERE Movie_id=NEW.Movie_id;
END;##
CREATE TRIGGER AgeVerification
BEFORE INSERT ON Ticket_Order FOR EACH ROW
BEGIN
  IF (SELECT Content_rating FROM Movie WHERE Movie_id=NEW.Movie_id) IN ('R', 'NC-17')
      AND ADDDATE((SELECT Birth_date FROM Customer WHERE Username=NEW.Customer_username), INTERVAL 17 YEAR)>CURDATE()
    THEN SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'You must be at least 17 years old to purchase tickets for this movie.';
  END IF;
END;##
CREATE EVENT UpdateTicketOrderStatus
ON SCHEDULE EVERY 1 MINUTE
ON COMPLETION PRESERVE ENABLE
DO
  UPDATE Ticket_Order
  SET Status='completed'
  WHERE Status='unused' AND View_TimeAndDate<NOW();##

delimiter ;


