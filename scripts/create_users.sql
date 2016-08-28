DROP USER IF EXISTS gtmovieuser@127.0.0.1, gtmovieadmin@localhost;
CREATE USER gtmovieadmin@localhost IDENTIFIED BY 'gtmovieadminpass';
CREATE USER gtmovieuser@127.0.0.1 IDENTIFIED BY 'gtmoviepass';
REVOKE ALL PRIVILEGES, GRANT OPTION FROM gtmovieadmin@localhost, gtmovieuser@127.0.0.1;
DROP DATABASE IF EXISTS gtmovie;
CREATE DATABASE gtmovie;
GRANT ALL PRIVILEGES ON *.* TO gtmovieadmin@localhost;
GRANT GRANT OPTION ON gtmovie.* TO gtmovieadmin@localhost;
GRANT INSERT, DELETE, UPDATE, SELECT ON gtmovie.* TO gtmovieuser@127.0.0.1;
SET GLOBAL event_scheduler = ON;