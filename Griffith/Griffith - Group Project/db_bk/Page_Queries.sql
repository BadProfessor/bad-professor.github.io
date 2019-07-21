/* ********************************************************************************** 
--------------------------------- QUERIES BY PAGE -----------------------------------
 ************************************************************************************ */

USE globogym;

/* ********************************************************************************** 
-------------------------------------- INDEX ----------------------------------------
 ************************************************************************************ */

/* Featured - Fetch all featured for display limit to 2, active only, latest first*/
SELECT featured_id, featured_title, featured_desc, featured_link, featured_image FROM tbl_featured WHERE featured_stat = 'Active' GROUP BY featured_id DESC LIMIT 2;

/* ********************************************************************************** 
------------------------------------ INDEX EDIT -------------------------------------
 ************************************************************************************ */
 
/* Featured - Insert */
INSERT INTO tbl_featured(featured_title, featured_desc, featured_link, featured_image, featured_stat) VALUES (':featured_title', ':featured_desc', ':featured_link', ':featured_image', ':featured_stat');

/* Featured - Fetch all featured for display for editting*/
SELECT featured_id, featured_title, featured_desc, featured_link, featured_image FROM tbl_featured WHERE featured_stat = 'Active' GROUP BY featured_id DESC;

/* Featured - Update */
UPDATE tbl_featured SET featured_stat = 'Inactive' WHERE featured_id = ':featured_id';

/* Featured - Insert Logs (Case: Approve Testimonial)*/
INSERT INTO tbl_logs(log_type, log_type_id, log_desc, log_time, user_id) VALUES ('Featured', ':featured_id', 'New Featured', ':datetime_now', ':SESSION["user_id"]')

/* ********************************************************************************** 
-------------------------------------- CLASS ----------------------------------------
 ************************************************************************************ */

/* Classes - Fetch all classes for display, latest first */
SELECT class_name, class_image, class_tier, FROM tbl_class WHERE class_stat = 'Active' GROUP BY class_id DESC;

/* Classes - Search for classes by class name */
SELECT class_name, class_desc, class_capacity, class_image, class_day, class_stime, class_etime, class_tier, class_stat FROM tbl_class WHERE class_stat = 'Active' AND class_name LIKE ':class_name%' GROUP BY class_id DESC;

/* ********************************************************************************** 
---------------------------------- CLASS DETAILS ------------------------------------
 ************************************************************************************ */

/* Classes - Fetch selected class for display*/
SELECT class_name, class_desc, class_capacity, class_image, class_day, class_stime, class_etime, class_tier, class_stat FROM tbl_class WHERE class_id = ':class_id';

/* Classes - Insert Logs (Case: User views class)*/
INSERT INTO tbl_logs(log_type, log_type_id, log_desc, log_time, user_id) VALUES ('Class', ':row["class_id"]', 'Insert New Class',':datetime_now', ':SESSION["user_id"]');

/* ********************************************************************************** 
-------------------------------- CLASS DETAILS EDIT ---------------------------------
 ************************************************************************************ */

/* Classes - Insert New Class */
INSERT INTO tbl_class(class_name, class_desc, class_capacity, class_image, class_day, class_stime, class_etime, class_tier, class_stat) VALUES (':class_name', ':class_desc', ':class_capacity', ':class_image', ':class_day', ':class_stime', ':class_etime', ':class_tier', 'Active');

/* Classes - Update Class */
UPDATE tbl_class SET class_stat = 'Inactive' WHERE class_id = ':class_id';

/* Classes - Fetch all classes for display, latest first */
SELECT class_id, class_name, class_desc, class_capacity, class_image, class_day, class_stime, class_etime, class_tier, class_stat FROM tbl_class WHERE class_stat = 'Active' GROUP BY class_id DESC;

/* Classes - Insert Logs - Get latest class Id after insert */
SELECT class_id FROM tbl_class GROUP BY class_id DESC LIMIT 1;

/* Classes - Search for classes by class name */
SELECT class_id, class_name, class_desc, class_capacity, class_image, class_day, class_stime, class_etime, class_tier, class_stat FROM tbl_class WHERE class_stat = 'Active' AND class_name LIKE ':class_name%' GROUP BY class_id DESC;

/* Classes - Insert Logs (Case: Insert New Class)*/
INSERT INTO tbl_logs(log_type, log_type_id, log_desc, log_time, user_id) VALUES ('Class', ':row["class_id"]', 'Insert New Class',':datetime_now', ':SESSION["user_id"]');

/* ********************************************************************************** 
----------------------------------- TESTIMONIALS ------------------------------------
 ************************************************************************************ */
 
/* Testimonial - Fetch all testimonials for display, latest first */
SELECT test_id, test_name, test_content, test_stars, user_fname FROM tbl_testimonial INNER JOIN tbl_usertest ON tbl_testimonial.user_id = tbl_usertest.user_id INNER JOIN tbl_user ON tbl_usertest.user_id = tbl_user.user_id WHERE tbl_testimonial.test_stat = 'Active' GROUP BY tbl_testimonial.test_id DESC;

/* Testimonial - Search Testimonials by class name */
SELECT test_name, test_content, test_stars, user_fname FROM tbl_testimonial INNER JOIN tbl_usertest ON tbl_testimonial.user_id = tbl_usertest.user_id INNER JOIN tbl_user ON tbl_usertest.user_id = tbl_user.user_id INNER JOIN tbl_class ON tbl_classtest.test_id = tbl_testimonial.test_id INNER JOIN tbl_class ON tbl_class.class_id = tbl_classtest.class_id WHERE tbl_testimonial.test_stat = 'Active' AND tbl_class.class_name LIKE ':class_name%' GROUP BY tbl_testimonial.test_id DESC;

/* ********************************************************************************** 
-------------------------------- TESTIMONIALS MANAGE --------------------------------
 ************************************************************************************ */

/* Testimonial - Fetch all testimonials for display, latest first */
SELECT test_id, test_name, test_content, test_stars, user_fname FROM tbl_testimonial INNER JOIN tbl_usertest ON tbl_testimonial.user_id = tbl_usertest.user_id INNER JOIN tbl_user ON tbl_usertest.user_id = tbl_user.user_id WHERE tbl_testimonial.test_stat = 'Active' GROUP BY tbl_testimonial.test_id DESC;

/* Testimonial - Update testimonial */
UPDATE tbl_testimonial SET test_content = ':test_content', test_stars = ':test_stars' WHERE test_id = ':test_id';

/* Testimonial - Insert */
INSERT INTO tbl_testimonial(test_title, test_content, test_stars, test_stat) VALUES(':test_title', ':test_content', ':test_stars', ':test_stat');

/* Testimonial - Search Testimonials by class name */
SELECT test_name, test_content, test_stars, user_fname FROM tbl_testimonial INNER JOIN tbl_usertest ON tbl_testimonial.user_id = tbl_usertest.user_id INNER JOIN tbl_user ON tbl_usertest.user_id = tbl_user.user_id INNER JOIN tbl_class ON tbl_classtest.test_id = tbl_testimonial.test_id INNER JOIN tbl_class ON tbl_class.class_id = tbl_classtest.class_id WHERE tbl_testimonial.test_stat = 'Active' AND tbl_class.class_name LIKE ':class_name%' GROUP BY tbl_testimonial.test_id DESC;

/* Testimonial_user - Fetch all user testimonials for display, latest first */
SELECT test_id, test_name, test_content, test_stars, user_fname FROM tbl_testimonial INNER JOIN tbl_usertest ON tbl_testimonial.user_id = tbl_usertest.user_id INNER JOIN tbl_user ON tbl_usertest.user_id = tbl_user.user_id WHERE tbl_user.user_id = ':SESSION["user_id"]' AND tbl_testimonial.test_stat = 'Active' GROUP BY tbl_testimonial.test_id DESC;

/* Testimonial - Insert Logs (Case: Approve Testimonial)*/
INSERT INTO tbl_logs(log_type, log_type_id, log_desc, log_time, user_id) VALUES ('Testimonial', ':row["test_id"]', 'Approve Testimonial', ':datetime_now', ':SESSION["user_id"]');


/* ********************************************************************************** 
-------------------------------- CONTACT US/CAREERS -------------------------------------
 ************************************************************************************ */

/* Mail - Send Mail - Insert into mail, fetch mail id, user_email, insert into usermail */
INSERT INTO tbl_mail(mail_subj, mail_type, mail_content, mail_time, mail_stat) VALUES(':mail_subj', ':mail_type', ':mail_content', ':mail_time', ':mail_stat');
SELECT mail_id FROM tbl_mail GROUP BY mail_id DESC LIMIT 1;
	-- Only perform if a user is logged in. 
	SELECT user_email FROM tbl_user WHERE user_id = ':SESSION["user_id"]';
	INSERT INTO tbl_usermail(user_email, mail_id, mail_is_user) VALUES (':fetched_row["user_email"]', ':fetched_row["user_email"]', '1');
	-- If user is not logged in.
	INSERT INTO tbl_usermail(user_email, mail_id, mail_is_user) VALUES (':user_email', 'mail_id', '0');

/* Mail - Insert Logs (Case: Read Mail)*/
INSERT INTO tbl_logs(log_type, log_type_id, log_desc, log_time, user_id) VALUES ('Mail', ':mail_id', 'Read Mail', ':datetime_now', ':user_email');

/* ********************************************************************************** 
-------------------------------- CONTACT US MANAGE ---------------------------------
 ************************************************************************************ */

/* Mail - Select all for display */
SELECT mail_id, mail_type, mail_subj, mail_time, mail_stat, user_email, mail_is_user FROM tbl_usermail INNER JOIN tbl_mail ON tbl_mail.mail_id = tbl_usermail.mail_id LEFT JOIN tbl_user.user_email = tbl_usermail.user_email GROUP BY mail_time DESC;

/* Mail - Search Mail by Sender(Email address) or Subject */
SELECT mail_id, mail_type, mail_subj, mail_time, mail_stat, user_email, mail_is_user FROM tbl_usermail INNER JOIN tbl_mail ON tbl_mail.mail_id = tbl_usermail.mail_id LEFT JOIN tbl_user.user_email = tbl_usermail.user_email WHERE tbl_mail.mail_subj LIKE ':search_query%' OR tbl_usermail.user_email LIKE ':search_query%' GROUP BY mail_time DESC;

/* Mail - Select one for display */
SELECT mail_id, mail_type, mail_subj, mail_time, mail_stat, mail_content, user_email, mail_is_user FROM tbl_usermail INNER JOIN tbl_mail ON tbl_mail.mail_id = tbl_usermail.mail_id LEFT JOIN tbl_user.user_email = tbl_usermail.user_email WHERE mail_id = ':mail_id';
	-- Update if the mail has been read (1 for read and 0 for unread)
	UPDATE tbl_mail SET mail_stat = '1' WHERE mail_id = ':mail_id';

/* Mail - Send Mail (Reply) - Insert into mail, fetch mail id, user_email, insert into usermail */
INSERT INTO tbl_mail(mail_subj, mail_type, mail_content, mail_time, mail_stat) VALUES(':mail_subj', ':mail_type', ':mail_content', ':mail_time', ':mail_stat');
SELECT mail_id FROM tbl_mail GROUP BY mail_id DESC LIMIT 1;
	-- Only perform if a user is logged in. 
	SELECT user_email FROM tbl_user WHERE user_id = ':SESSION["user_id"]';
	INSERT INTO tbl_usermail(user_email, mail_id, mail_is_user) VALUES (':fetched_row["user_email"]', ':fetched_row["user_email"]', '1');
	-- If user is not logged in.
	INSERT INTO tbl_usermail(user_email, mail_id, mail_is_user) VALUES (':user_email', 'mail_id', '0');

/* Mail - Insert Logs (Case: Read Mail)*/
INSERT INTO tbl_logs(log_type, log_type_id, log_desc, log_time, user_id) VALUES ('Mail', ':mail_id', 'Read Mail', ':datetime_now', ':user_email');

/* ********************************************************************************** 
----------------------------------- REGISTRATION ------------------------------------
 ************************************************************************************ */

/* User - Add new user (Register) */
INSERT INTO tbl_user(user_type, user_title, user_fname, user_lname, user_gender, user_dob, user_email, user_address, user_pcode, user_phone) VALUES (':user_type', ':user_title', ':user_fname', ':user_lname', ':user_gender', ':user_dob', ':user_email', ':user_address', ':user_pcode', ':user_phone');
INSERT INTO tbl_usertier(user_id, tier_id, tier_sub_date, tier_duration) VALUES (':user_id', ':tier_id', ':tier_sub_date', ':tier_duration');
INSERT INTO tbl_userclass(user_id, class_id) VALUES (':user_id', ':class_id'), (':user_id', ':class_id'), (':user_id', ':class_id'); -- Multiple values for each class picked.

/* User - Register Insert logs - Get user id */
SELECT user_id FROM tbl_user WHERE user_email = ':email' LIMIT 1;

/* User - Register Insert Logs */
INSERT INTO tbl_logs(log_type, log_desc, log_time, user_id) VALUES ('Register','User Activity',':datetime_now', ':fetched_row["user_id"]');


/* ********************************************************************************** 
--------------------------- REGISTRATION EDIT (EDIT USER??)------------------------------------
 ************************************************************************************ */
 
/* User - Get user details */
SELECT user_id, CONCAT(user_title, " ", user_fname, " ", user_lname) AS user_name, user_address, user_pcode, user_email, user_phone, user_dob FROM tbl_user WHERE user_id = ':SESSION[user_id]';

/* User - Update user details */
UPDATE tbl_user SET user_fname = ':user_fname', user_lname = ':user_lname' WHERE user_id = ':SESSION["user_id"]';

/* User - Update user password */
UPDATE tbl_cred SET user_pass = ':user_pass' WHERE user_id = ':SESSION["user_id"]';

/* User - Search for user by first name, last name or id */
SELECT user_id, CONCAT(user_title, " ", user_fname, " ", user_lname) AS user_name, user_address, user_pcode, user_email, user_phone, user_dob FROM tbl_user WHERE user_fname LIKE ':user_fname%' OR user_lname LIKE ':user_lname%' OR user_id LIKE ':user_id';

/* User - Insert Logs (Case: admin updates another user's details) */
INSERT INTO tbl_logs(log_type, log_type_id, log_desc, log_time, user_id) VALUES ('User Management', ':fetched_row["user_id"]', 'Update Information',':datetime_now', ':SESSION["user_id"]');

/* User - Register Insert logs - Get user id */
SELECT user_id FROM tbl_user WHERE user_email == ':email' LIMIT 1;

/* User - Register Insert Logs */
INSERT INTO tbl_logs(log_type, log_desc, log_time, user_id) VALUES ('Register','User Activity',':datetime_now', ':fetched_row["user_id"]');

/* ********************************************************************************** 
-------------------------------------- LOGIN ----------------------------------------
 ************************************************************************************ */
 
/* Login - Check if email exist */
SELECT user_email FROM tbl_user WHERE user_email == ':email' LIMIT 1;

/* Login - Load user credentials */
SELECT user_id, user_email, user_pass FROM tbl_users INNER JOIN tbl_cred ON tbl_user.user_id = tbl_cred.user_id WHERE user_email = ':email' LIMIT 1;

/* Login - Insert Logs */
INSERT INTO tbl_logs(log_type, log_desc, log_time, user_id) VALUES ('Login','User Activity',':datetime_now', ':SESSION["user_id"]');

 
/* ********************************************************************************** 
-------------------------------------- LOGOUT ---------------------------------------
 ************************************************************************************ */

/* Logout - Insert Logs */
INSERT INTO tbl_logs(log_type, log_desc, log_time, user_id) VALUES ('Logout','User Activity',':datetime_now', ':SESSION["user_id"]');


/* ********************************************************************************** 
--------------------------------- TIERS/MEMBERSHIP ----------------------------------
 ************************************************************************************ */

/* Tier - Fetch all for display, limit 3 */
SELECT tier_name, tier_details, tier_price, tier_class_limit, tier_image FROM tbl_tier WHERE tier_stat = 'Active' GROUP BY tier_id DESC LIMIT 3;

/* ********************************************************************************** 
------------------------------- TIERS/MEMBERSHIP EDIT -------------------------------
 ************************************************************************************ */
 
/* Tier - Insert */
INSERT INTO tbl_tier(tier_name, tier_details, tier_price, tier_class_limit, tier_image, tier_stat) VALUES (':tier_name', ':tier_details', ':tier_price', ':tier_class_limit', ':tier_image', ':tier_stat');

/* Tier - Update */
UPDATE tbl_tier SET tier_price = ':tier_price' = '29.99' WHERE tier_id = ':tier_id';

/* Tier - Fetch user tier, limit 1 and only the most recently subscribed. Might want to validate the sub_date with the duration for the expiry date. */
SELECT tier_name, tier_details, tier_price, tier_sub_date, tier_duration FROM tbl_tier INNER JOIN tbl_usertier ON tbl_usertier.tier_id = tbl_tier.tier_id INNER JOIN tbl_user ON tbl_user.user_id = tbl_usertier.user_id WHERE tbl_usertier.tbl_user = ':SESSION["user_id"]' GROUP BY tbl_tier.tier_sub_date DESC LIMIT 1;

/* Tier - Insert Logs (Case: Change Tier Descriptor)*/
INSERT INTO tbl_logs(log_type, log_type_id, log_desc, log_time, user_id) VALUES ('Tier', ':tier_id', 'Update Tier', ':datetime_now', ':SESSION["user_id"]')

/* Tier - Unsubscribe user from tier */
UPDATE tbl_usertier SET tier_duration = '0' WHERE user_id = ':user_id';

/* ********************************************************************************** 
-------------------------------- LOGIN/REGISTRATION --------------------------------
 ************************************************************************************ */

/* Login - Check if email exist */
SELECT user_email FROM tbl_user WHERE user_email == ':email' LIMIT 1;

/* Login - Load user credentials */
SELECT user_id, user_email, user_pass FROM tbl_users INNER JOIN tbl_cred ON tbl_user.user_id = tbl_cred.user_id WHERE user_email = ':email' LIMIT 1;

/* Login - Insert Logs */
INSERT INTO tbl_logs(log_type, log_desc, log_time, user_id) VALUES ('Login','User Activity',':datetime_now', ':SESSION["user_id"]');

/* Register */
INSERT INTO tbl_user(user_fname, user_lname, user_type, user_address, user_email, user_phone, user_gender, user_dob) VALUES (':user_fname', ':user_lname', ':user_type', ':user_address', ':user_email', ':user_phone', ':user_gender', ':user_dob');

/* Register - Insert logs - Get user id */
SELECT user_id FROM tbl_user WHERE user_email == ':email' LIMIT 1;

/* Register - Insert Logs */
INSERT INTO tbl_logs(log_type, log_desc, log_time, user_id) VALUES ('Register','User Activity',':datetime_now', ':fetched_row["user_id"]');

/* ********************************************************************************** 
--------------------------------------- USER ---------------------------------------
 ************************************************************************************ */

/* User - Get user details */
SELECT user_id, CONCAT(user_title, " ", user_fname, " ", user_lname) AS user_name, user_address, user_pcode, user_email, user_phone, user_dob FROM tbl_user WHERE user_id = ':SESSION[user_id]';

/* User - Add new user (Register) */
INSERT INTO tbl_user(user_type, user_title, user_fname, user_lname, user_gender, user_dob, user_email, user_address, user_pcode, user_phone) VALUES (':user_type', ':user_title', ':user_fname', ':user_lname', ':user_gender', ':user_dob', ':user_email', ':user_address', ':user_pcode', ':user_phone');
INSERT INTO tbl_usertier(user_id, tier_id, tier_sub_date, tier_duration) VALUES (':user_id', ':tier_id', ':tier_sub_date', ':tier_duration');
INSERT INTO tbl_userclass(user_id, class_id) VALUES (':user_id', ':class_id'), (':user_id', ':class_id'), (':user_id', ':class_id'); -- Multiple values for each class picked.

/* User - Update user details */
UPDATE tbl_user SET user_fname = ':user_fname', user_lname = ':user_lname' WHERE user_id = ':SESSION["user_id"]';

/* User - Update user password */
UPDATE tbl_cred SET user_pass = ':user_pass' WHERE user_id = ':SESSION["user_id"]';

/* User - Search for user by first name, last name or id */
SELECT user_id, CONCAT(user_title, " ", user_fname, " ", user_lname) AS user_name, user_address, user_pcode, user_email, user_phone, user_dob FROM tbl_user WHERE user_fname LIKE ':user_fname%' OR user_lname LIKE ':user_lname%' OR user_id LIKE ':user_id';

/* User - Insert Logs (Case: admin updates another user's details) */
INSERT INTO tbl_logs(log_type, log_type_id, log_desc, log_time, user_id) VALUES ('User Management', ':fetched_row["user_id"]', 'Update Information',':datetime_now', ':SESSION["user_id"]');

/* ********************************************************************************** 
------------------------------------- CLASSES --------------------------------------
 ************************************************************************************ */

/* Classes - Insert New Class */
INSERT INTO tbl_class(class_name, class_desc, class_capacity, class_image, class_day, class_stime, class_etime, class_tier, class_stat) VALUES (':class_name', ':class_desc', ':class_capacity', ':class_image', ':class_day', ':class_stime', ':class_etime', ':class_tier', 'Active');

/* Classes - Update Class */
UPDATE tbl_class SET class_stat = 'Inactive' WHERE class_id = ':class_id';

/* Classes - Fetch all classes for display, latest first */
SELECT class_id, class_name, class_desc, class_capacity, class_image, class_day, class_stime, class_etime, class_tier, class_stat FROM tbl_class WHERE class_stat = 'Active' GROUP BY class_id DESC;

/* Classes - Insert Logs - Get latest class Id after insert */
SELECT class_id FROM tbl_class GROUP BY class_id DESC LIMIT 1;

/* Classes- Search for classes by class name */
SELECT class_name, class_desc, class_capacity, class_image, class_day, class_stime, class_etime, class_tier, class_stat FROM tbl_class WHERE class_stat = 'Active' AND class_name LIKE ':class_name%' GROUP BY class_id DESC;

/* Classes_User - Get user classes */
SELECT class_name, class_desc, class_day, class_ stime, class_etime FROM tbl_class INNER JOIN tbl_userclass ON  tbl_class.class_id = tbl_userclass.class_id WHERE tbluserclass.user_id = ':SESSION["user_id"]';

/* Classes - Insert Logs (Case: Insert New Class)*/
INSERT INTO tbl_logs(log_type, log_type_id, log_desc, log_time, user_id) VALUES ('Class', ':row["class_id"]', 'Insert New Class',':datetime_now', ':SESSION["user_id"]');

/* ********************************************************************************** 
---------------------------------- TESTIMONIALS ------------------------------------
 ************************************************************************************ */

/* Testimonial - Fetch all testimonials for display, latest first */
SELECT test_id, test_name, test_content, test_stars, user_fname FROM tbl_testimonial INNER JOIN tbl_usertest ON tbl_testimonial.user_id = tbl_usertest.user_id INNER JOIN tbl_user ON tbl_usertest.user_id = tbl_user.user_id WHERE tbl_testimonial.test_stat = 'Active' GROUP BY tbl_testimonial.test_id DESC;

/* Testimonial - Update testimonial */
UPDATE tbl_testimonial SET test_content = ':test_content', test_stars = ':test_stars' WHERE test_id = ':test_id';

/* Testimonial - Insert */
INSERT INTO tbl_testimonial(test_title, test_content, test_stars, test_stat) VALUES(':test_title', ':test_content', ':test_stars', ':test_stat');

/* Testimonial - Search Testimonials by class name */
SELECT test_name, test_content, test_stars, user_fname FROM tbl_testimonial INNER JOIN tbl_usertest ON tbl_testimonial.user_id = tbl_usertest.user_id INNER JOIN tbl_user ON tbl_usertest.user_id = tbl_user.user_id INNER JOIN tbl_class ON tbl_classtest.test_id = tbl_testimonial.test_id INNER JOIN tbl_class ON tbl_class.class_id = tbl_classtest.class_id WHERE tbl_testimonial.test_stat = 'Active' AND tbl_class.class_name LIKE ':class_name%' GROUP BY tbl_testimonial.test_id DESC;

/* Testimonial_user - Fetch all user testimonials for display, latest first */
SELECT test_id, test_name, test_content, test_stars, user_fname FROM tbl_testimonial INNER JOIN tbl_usertest ON tbl_testimonial.user_id = tbl_usertest.user_id INNER JOIN tbl_user ON tbl_usertest.user_id = tbl_user.user_id WHERE tbl_user.user_id = ':SESSION["user_id"]' AND tbl_testimonial.test_stat = 'Active' GROUP BY tbl_testimonial.test_id DESC;

/* Testimonial - Insert Logs (Case: Approve Testimonial)*/
INSERT INTO tbl_logs(log_type, log_type_id, log_desc, log_time, user_id) VALUES ('Testimonial', ':row["test_id"]', 'Approve Testimonial', ':datetime_now', ':SESSION["user_id"]');

/* ********************************************************************************** 
------------------------------------- FEATURED --------------------------------------
 ************************************************************************************ */

/* Featured - Insert */
INSERT INTO tbl_featured(featured_title, featured_desc, featured_link, featured_image, featured_stat) VALUES (':featured_title', ':featured_desc', ':featured_link', ':featured_image', ':featured_stat');

/* Featured - Fetch all featured for display limit to 2, active only, latest first*/
SELECT featured_id, featured_title, featured_desc, featured_link, featured_image FROM tbl_featured WHERE featured_stat = 'Active' GROUP BY featured_id DESC LIMIT 2;

/* Featured - Update */
UPDATE tbl_featured SET featured_stat = 'Inactive' WHERE featured_id = ':featured_id';

/* Featured - Insert Logs (Case: Approve Testimonial)*/
INSERT INTO tbl_logs(log_type, log_type_id, log_desc, log_time, user_id) VALUES ('Featured', ':featured_id', 'New Featured', ':datetime_now', ':SESSION["user_id"]')

/* ********************************************************************************** 
--------------------------------------- TIER ----------------------------------------
 ************************************************************************************ */
 
/* Tier - Insert */
INSERT INTO tbl_tier(tier_name, tier_details, tier_price, tier_class_limit, tier_image, tier_stat) VALUES (':tier_name', ':tier_details', ':tier_price', ':tier_class_limit', ':tier_image', ':tier_stat');
 
/* Tier - Fetch all for display, limit 3 */
SELECT tier_name, tier_details, tier_price, tier_class_limit, tier_image FROM tbl_tier WHERE tier_stat = 'Active' GROUP BY tier_id DESC LIMIT 3;

/* Tier - Update */
UPDATE tbl_tier SET tier_price = ':tier_price' = '29.99' WHERE tier_id = ':tier_id';

/* Tier - Fetch user tier, limit 1 and only the most recently subscribed. Might want to validate the sub_date with the duration for the expiry date. */
SELECT tier_name, tier_details, tier_price, tier_sub_date, tier_duration FROM tbl_tier INNER JOIN tbl_usertier ON tbl_usertier.tier_id = tbl_tier.tier_id INNER JOIN tbl_user ON tbl_user.user_id = tbl_usertier.user_id WHERE tbl_usertier.tbl_user = ':SESSION["user_id"]' GROUP BY tbl_tier.tier_sub_date DESC LIMIT 1;

/* Tier - Insert Logs (Case: Change Tier Descriptor)*/
INSERT INTO tbl_logs(log_type, log_type_id, log_desc, log_time, user_id) VALUES ('Tier', ':tier_id', 'Update Tier', ':datetime_now', ':SESSION["user_id"]')

/* ********************************************************************************** 
--------------------------------------- MAIL ----------------------------------------
 ************************************************************************************ */
 
/* Mail - Select all for display */
SELECT mail_id, mail_type, mail_subj, mail_time, mail_stat, user_email, mail_is_user FROM tbl_usermail INNER JOIN tbl_mail ON tbl_mail.mail_id = tbl_usermail.mail_id LEFT JOIN tbl_user.user_email = tbl_usermail.user_email GROUP BY mail_time DESC;

/* Mail - Search Mail by Sender(Email address) or Subject */
SELECT mail_id, mail_type, mail_subj, mail_time, mail_stat, user_email, mail_is_user FROM tbl_usermail INNER JOIN tbl_mail ON tbl_mail.mail_id = tbl_usermail.mail_id LEFT JOIN tbl_user.user_email = tbl_usermail.user_email WHERE tbl_mail.mail_subj LIKE ':search_query%' OR tbl_usermail.user_email LIKE ':search_query%' GROUP BY mail_time DESC;

/* Mail - Select one for display */
SELECT mail_id, mail_type, mail_subj, mail_time, mail_stat, mail_content, user_email, mail_is_user FROM tbl_usermail INNER JOIN tbl_mail ON tbl_mail.mail_id = tbl_usermail.mail_id LEFT JOIN tbl_user.user_email = tbl_usermail.user_email WHERE mail_id = ':mail_id';
	-- Update if the mail has been read (1 for read and 0 for unread)
	UPDATE tbl_mail SET mail_stat = '1' WHERE mail_id = ':mail_id';

/* Mail - Send Mail - Insert into mail, fetch mail id, user_email, insert into usermail */
INSERT INTO tbl_mail(mail_subj, mail_type, mail_content, mail_time, mail_stat) VALUES(':mail_subj', ':mail_type', ':mail_content', ':mail_time', ':mail_stat');
SELECT mail_id FROM tbl_mail GROUP BY mail_id DESC LIMIT 1;
	-- Only perform if a user is logged in. 
	SELECT user_email FROM tbl_user WHERE user_id = ':SESSION["user_id"]';
	INSERT INTO tbl_usermail(user_email, mail_id, mail_is_user) VALUES (':fetched_row["user_email"]', ':fetched_row["user_email"]', '1');
	-- If user is not logged in.
	INSERT INTO tbl_usermail(user_email, mail_id, mail_is_user) VALUES (':user_email', 'mail_id', '0');

/* Mail - Insert Logs (Case: Read Mail)*/
INSERT INTO tbl_logs(log_type, log_type_id, log_desc, log_time, user_id) VALUES ('Mail', ':mail_id', 'Read Mail', ':datetime_now', ':SESSION["user_id"]')


