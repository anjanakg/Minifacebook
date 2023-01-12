-- file for sql database creation by Dr. Phung and modified and utilized by Josh and Anjana
-- if the table exists, delete it
-- DROP database IF EXISTS secad_team5;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS posts;
DROP TABLE IF EXISTS comments;
DROP table if exists superusers;

-- CREATE database secad_team5;
-- USE secad_team5;
-- SELECT current_date as "date";
-- create tables

CREATE TABLE users(
	username varchar(45) NOT NULL UNIQUE,
	email varchar(45) NOT NULL,
	password varchar(100) NOT NULL,
	fname varchar(45) NOT NULL,
	lname varchar(45) NOT NULL,
	phonenumber varchar(12),
	DOB date,
	gender varchar(10),
	date_joined TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	active BOOLEAN,
	-- user_id int AUTO_INCREMENT,
	PRIMARY KEY (username) -- user_id)
	);


CREATE TABLE posts(
	post_id int AUTO_INCREMENT, 
	post_title varchar(100) NOT NULL,
	post_msg text, 
	username varchar(45) NOT NULL,
	date_posted date NOT NULL ,
	PRIMARY KEY (post_id)); 
	-- FOREIGN KEY (user_id) REFERENCES users(user_id));
-- DEFAULT(CURRENT_DATE),

CREATE TABLE comments(
	comment_id int AUTO_INCREMENT, 
	post_id int, 
	comment_msg varchar(80) NOT NULL,
	username varchar(45) NOT NULL UNIQUE, 
	date_commented date ,
	PRIMARY KEY(comment_id));
	-- FOREIGN KEY (post_id) REFERENCES posts(post_id), 
	-- FOREIGN KEY (user_id) REFERENCES posts(user_id)); 


-- inster data to the table users
LOCK TABLES users WRITE;
-- INSERT INTO users VALUE ('Admin','admin@admin.com',password('Team5@secad'),'admin','admin',null,null,null,'2022-01-01', 1);
UNLOCK TABLES;

LOCK TABLES posts WRITE;
-- INSERT INTO posts VALUE (1,"Welcome in!","The first post","admin",'2022-01-01');
UNLOCK TABLES;

-- create a table for Admin
CREATE TABLE superusers(
	username VARCHAR(45) NOT NULL UNIQUE, 
	password VARCHAR(100) NOT NULL,
	PRIMARY KEY(username));

-- inster data to the table superusers
LOCK TABLES superusers WRITE;
INSERT INTO superusers VALUE ('adminteam',password('Admin@team5'));
UNLOCK TABLES;



