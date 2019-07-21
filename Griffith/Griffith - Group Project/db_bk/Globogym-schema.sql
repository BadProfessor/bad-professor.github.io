DROP DATABASE IF EXISTS globogym;
CREATE DATABASE globogym;
USE globogym;

/* Main Tables */

-- Juraj: I changed the order of the table so that it matchs the HTML
CREATE TABLE tbl_user (
	user_id int(8) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	user_type varchar(10) NOT NULL,
	-- user_class varchar(6), // Not sure on what the application for this is? We have tbl_userclass.
	user_title varchar(3) NOT NULL,
	user_fname varchar(50) NOT NULL,
	user_lname varchar(50) NOT NULL, 
	user_gender char(6) NOT NULL,
	user_dob date NOT NULL,
	user_email varchar(100) NOT NULL,
	user_address varchar(100) NOT NULL,
	user_pcode varchar(3) NOT NULL,
	user_phone int(10) NOT NULL
	-- user_health varchar(5) NOT NULL, // This can be a checkbox in frontend and validated to let the user know to sign up on site if they have health problems
	-- user_marketing varchar(5), // We'll need to implement a new table for this to save us the hassle of scanning through every user to see if they signed up for the newsletter
	-- user_terms varchar(5) NOT NULL, // Like with the health, stop the user from signing up in frontend.
);

CREATE TABLE tbl_class (
	class_id int(8) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	class_name varchar(50),
	class_desc varchar(255),
	class_capacity int(3),
	class_image varchar(500),
	class_day varchar(3),
	class_stime time,
	class_etime time,
	class_tier int(1),
	class_stat int(1)
);

CREATE TABLE tbl_testimonial (
	test_id int(8) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	test_title varchar(30),
	test_content varchar(80),
	test_stars int(1),
	test_stat int(1)
);

CREATE TABLE tbl_tier (
	tier_id int(8) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	tier_name varchar(30),
	tier_details varchar(300),
	tier_price decimal(3,2),
	tier_class_limit int(2),
	tier_image varchar(255),
	tier_stat int(1)
);

CREATE TABLE tbl_featured (
	featured_id int(8) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	featured_title varchar(50),
	featured_desc varchar(300),
	featured_link varchar(255),
	featured_image varchar(255),
	featured_stat int(1)
);

CREATE TABLE tbl_mail (
	mail_id int(8)	NOT NULL AUTO_INCREMENT PRIMARY KEY,
	mail_type varchar(20),
	mail_subj varchar(30),
	mail_content varchar(50),
	mail_time datetime,
	mail_attachment varchar(255), 
	mail_stat int(1)
);

CREATE TABLE tbl_logs (
	log_id int(8) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	log_type varchar(50),
	log_type_id int(8),
	log_desc varchar(255),
	log_time datetime,
	user_id int(8),
	FOREIGN KEY (user_id)
	REFERENCES tbl_user(user_id) ON DELETE SET NULL ON UPDATE CASCADE
);

/* Junction Tables */

CREATE TABLE tbl_creds (
	user_id int(8),
	user_pass varchar(255),
	FOREIGN KEY (user_id)
	REFERENCES tbl_user(user_id) ON DELETE SET NULL ON UPDATE CASCADE
);

CREATE TABLE tbl_userclass (
	user_id int(8),
	class_id int(8),
	FOREIGN KEY (user_id)
	REFERENCES tbl_user(user_id) ON DELETE SET NULL ON UPDATE CASCADE,
	FOREIGN KEY (class_id)
	REFERENCES tbl_class(class_id) ON DELETE SET NULL ON UPDATE CASCADE
);	

CREATE TABLE tbl_usertest (
	user_id int(8),
	test_id int(8),
	FOREIGN KEY (user_id)
	REFERENCES tbl_user(user_id) ON DELETE SET NULL ON UPDATE CASCADE,
	FOREIGN KEY (test_id)
	REFERENCES tbl_testimonial(test_id) ON DELETE SET NULL ON UPDATE CASCADE
);	

CREATE TABLE tbl_usertier (
	user_id int(8),
	tier_id int(8),
	tier_sub_date date,
	tier_duration int(2),
	FOREIGN KEY (user_id)
	REFERENCES tbl_user(user_id) ON DELETE SET NULL ON UPDATE CASCADE,
	FOREIGN KEY (tier_id)
	REFERENCES tbl_tier(tier_id) ON DELETE SET NULL ON UPDATE CASCADE
);

CREATE TABLE tbl_usermail (
	user_email varchar(100),
	mail_id int(8),
	mail_is_user int(1),
	FOREIGN KEY (mail_id) 
	REFERENCES tbl_mail(mail_id) ON DELETE SET NULL ON UPDATE CASCADE
);

CREATE TABLE tbl_classtest (
	class_id int(8),
	test_id int(8),
	FOREIGN KEY (class_id)
	REFERENCES tbl_class(class_id) ON DELETE SET NULL ON UPDATE CASCADE,
	FOREIGN KEY (test_id)
	REFERENCES tbl_testimonial(test_id) ON DELETE SET NULL ON UPDATE CASCADE
	
);