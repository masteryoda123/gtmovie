#!/bin/bash

# This script automates the process of updating the project website
# on the server by pulling from the remote git repository,
# replacing and re-populating the MySQL database,
# and restarting the apache2 server.
# This script is meant to be scheduled to run periodically.

cd /var/www/html/gtmovie-php
git pull
# cp -f /var/www/html/gtmovie-php/scripts/update_website.sh /home/eric/update_website.sh
# cp -f /var/www/html/gtmovie-php/scripts/setup_database.sh /home/eric/setup_database.sh
# chmod +x /home/eric/update_website.sh /home/eric/setup_database.sh
# service apache2 stop

# # One of the following instructions for the setup_database.sh script must be included in the setup_instruction.txt file, otherwise the scripts will do nothing:
# #	reset --> tell the script to drop the database and users and re-create everything
# #	repopulate/refill --> tell the script to drop the database and users, re-create everything, and populate the database
# /var/www/html/gtmovie-php/scripts/setup_database.sh $(cat setup_instruction.txt)
# # Clear setup_instruction.txt after it is used
# echo > setup_instruction.txt

# service apache2 start
# echo "$(date): Update successful." >> /home/eric/update.log
service apache2 restart