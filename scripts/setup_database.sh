#!/bin/bash

case "$1" in
	reset)
		mysql -u root -p < $PWD/create_users.sql > results.log
		mysql -u gtmovieadmin --password=gtmovieadminpass < $PWD/create_schema.sql >> results.log
		mysql -u gtmovieadmin --password=gtmovieadminpass < $PWD/create_triggers.sql >> results.log
		#echo "$(date): Database reset to empty." >> /home/eric/update.log
	;;
	populate)
		mysql -u root -p < $PWD/create_users.sql > results.log
		mysql -u gtmovieadmin --password=gtmovieadminpass < $PWD/create_schema.sql >> results.log
		mysql -u gtmovieadmin --password=gtmovieadminpass < $PWD/create_triggers.sql >> results.log
		mysql -u gtmovieadmin --password=gtmovieadminpass < $PWD/populate.sql >> results.log
		#echo "$(date): Database reset and repopulated with data." >> /home/eric/update.log
	;;
  import | fill | refill | load | reload)
    mysql -u root -p < $PWD/create_users.sql > results.log
		mysql -u gtmovieadmin --password=gtmovieadminpass < $PWD/create_schema.sql >> results.log
		mysql -u gtmovieadmin --password=gtmovieadminpass < $PWD/create_triggers.sql >> results.log
    cd $PWD
    cp ./User.csv ./Customer.csv ./Manager.csv ./Manager_Passwords.csv ./Movie.csv ./Movie_Cast.csv ./Movie_Genre.csv ./Payment_Method.csv ./Review.csv ./Screening.csv ./System_Info.csv ./Theater.csv ./Theater_Preference.csv ./Ticket_Order.csv ./new_orders.csv ./future_orders.csv ./more_screenings.csv ./import_other_stuff.sql /var/lib/mysql-files 
    mysql -u gtmovieadmin --password=gtmovieadminpass < $PWD/import_data.sql >> results.log
    mysql -u gtmovieadmin --password=gtmovieadminpass < $PWD/import_more_screenings.sql >> results.log
    mysql -u gtmovieadmin --password=gtmovieadminpass < $PWD/import_other_stuff.sql >> results.log
  ;;
  alt)
    mysql -u root -p < $PWD/create_users_alt.sql > results.log
		mysql -u gtmovieadmin --password=gtmovieadminpass < $PWD/create_schema.sql >> results.log
		mysql -u gtmovieadmin --password=gtmovieadminpass < $PWD/create_triggers.sql >> results.log
    mysql -u gtmovieadmin --password=gtmovieadminpass < $PWD/import_data.sql >> results.log
  ;;
	*)
		echo "No action specified."
	;;
esac

