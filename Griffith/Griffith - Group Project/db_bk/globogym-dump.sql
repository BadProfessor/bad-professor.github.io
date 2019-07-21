USE globogym;


--
-- Definition for table tbl_featured
--
DROP TABLE IF EXISTS tbl_featured;
CREATE TABLE tbl_featured (
  featured_id INT(8) NOT NULL AUTO_INCREMENT,
  featured_title VARCHAR(50) DEFAULT NULL,
  featured_desc VARCHAR(300) DEFAULT NULL,
  featured_link VARCHAR(255) DEFAULT NULL,
  featured_image VARCHAR(255) DEFAULT NULL,
  featured_stat INT(1) DEFAULT NULL,
  PRIMARY KEY (featured_id)
)
ENGINE = INNODB
AUTO_INCREMENT = 3
AVG_ROW_LENGTH = 8192
CHARACTER SET latin1
COLLATE latin1_swedish_ci;


--
-- Definition for table tbl_classtest
--
DROP TABLE IF EXISTS tbl_classtest;
CREATE TABLE tbl_classtest (
  class_id INT(8) DEFAULT NULL,
  test_id INT(8) DEFAULT NULL,
  INDEX class_id (class_id),
  INDEX test_id (test_id),
  CONSTRAINT tbl_classtest_ibfk_1 FOREIGN KEY (class_id)
    REFERENCES tbl_class(class_id) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT tbl_classtest_ibfk_2 FOREIGN KEY (test_id)
    REFERENCES tbl_testimonial(test_id) ON DELETE SET NULL ON UPDATE CASCADE
)
ENGINE = INNODB
AVG_ROW_LENGTH = 8192
CHARACTER SET latin1
COLLATE latin1_swedish_ci;

--
-- Definition for table tbl_creds
--
DROP TABLE IF EXISTS tbl_creds;
CREATE TABLE tbl_creds (
  user_id INT(8) DEFAULT NULL,
  user_pass VARCHAR(255) DEFAULT NULL,
  INDEX user_id (user_id),
  CONSTRAINT tbl_creds_ibfk_1 FOREIGN KEY (user_id)
    REFERENCES tbl_user(user_id) ON DELETE SET NULL ON UPDATE CASCADE
)
ENGINE = INNODB
AVG_ROW_LENGTH = 5461
CHARACTER SET latin1
COLLATE latin1_swedish_ci;

--
-- Definition for table tbl_logs
--
DROP TABLE IF EXISTS tbl_logs;
CREATE TABLE tbl_logs (
  log_id INT(8) NOT NULL AUTO_INCREMENT,
  log_type VARCHAR(50) DEFAULT NULL,
  log_type_id INT(8) DEFAULT NULL,
  log_desc VARCHAR(255) DEFAULT NULL,
  log_time DATETIME DEFAULT NULL,
  user_id INT(8) DEFAULT NULL,
  PRIMARY KEY (log_id),
  INDEX user_id (user_id),
  CONSTRAINT tbl_logs_ibfk_1 FOREIGN KEY (user_id)
    REFERENCES tbl_user(user_id) ON DELETE SET NULL ON UPDATE CASCADE
)
ENGINE = INNODB
AUTO_INCREMENT = 1
CHARACTER SET latin1
COLLATE latin1_swedish_ci;



--
-- Definition for table tbl_tier
--
DROP TABLE IF EXISTS tbl_tier;
CREATE TABLE tbl_tier (
  tier_id INT(8) NOT NULL AUTO_INCREMENT,
  tier_name VARCHAR(30) DEFAULT NULL,
  tier_details VARCHAR(500) DEFAULT NULL,
  tier_price INT(11) DEFAULT NULL,
  tier_class_limit INT(10) DEFAULT NULL,
  tier_image VARCHAR(255) DEFAULT NULL,
  tier_stat INT(1) DEFAULT NULL,
  PRIMARY KEY (tier_id)
)
ENGINE = INNODB
AUTO_INCREMENT = 8
AVG_ROW_LENGTH = 2730
CHARACTER SET latin1
COLLATE latin1_swedish_ci;

--
-- Definition for table tbl_user
--
DROP TABLE IF EXISTS tbl_user;
CREATE TABLE tbl_user (
  user_id INT(8) NOT NULL AUTO_INCREMENT,
  user_title VARCHAR(3) DEFAULT NULL,
  user_fname VARCHAR(50) DEFAULT NULL,
  user_lname VARCHAR(50) DEFAULT NULL,
  user_type VARCHAR(20) DEFAULT NULL,
  user_pcode VARCHAR(10) DEFAULT NULL,
  user_address VARCHAR(100) DEFAULT NULL,
  user_email VARCHAR(100) DEFAULT NULL,
  user_phone INT(10) DEFAULT NULL,
  user_gender INT(1) DEFAULT NULL,
  user_dob DATE DEFAULT NULL,
  PRIMARY KEY (user_id)
)
ENGINE = INNODB
AUTO_INCREMENT = 13
AVG_ROW_LENGTH = 4096
CHARACTER SET latin1
COLLATE latin1_swedish_ci;



--
-- Definition for table tbl_userclass
--
DROP TABLE IF EXISTS tbl_userclass;
CREATE TABLE tbl_userclass (
  user_id INT(8) DEFAULT NULL,
  class_id INT(8) DEFAULT NULL,
  INDEX class_id (class_id),
  INDEX user_id (user_id),
  CONSTRAINT tbl_userclass_ibfk_1 FOREIGN KEY (user_id)
    REFERENCES tbl_user(user_id) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT tbl_userclass_ibfk_2 FOREIGN KEY (class_id)
    REFERENCES tbl_class(class_id) ON DELETE SET NULL ON UPDATE CASCADE
)
ENGINE = INNODB
CHARACTER SET latin1
COLLATE latin1_swedish_ci;

--
-- Definition for table tbl_usermail
--
DROP TABLE IF EXISTS tbl_usermail;
CREATE TABLE tbl_usermail (
  user_email VARCHAR(100) DEFAULT NULL,
  mail_id INT(8) DEFAULT NULL,
  mail_is_user INT(1) DEFAULT NULL,
  INDEX mail_id (mail_id),
  CONSTRAINT tbl_usermail_ibfk_1 FOREIGN KEY (mail_id)
    REFERENCES tbl_mail(mail_id) ON DELETE SET NULL ON UPDATE CASCADE
)
ENGINE = INNODB
AVG_ROW_LENGTH = 16384
CHARACTER SET latin1
COLLATE latin1_swedish_ci;

--
-- Definition for table tbl_usertest
--
DROP TABLE IF EXISTS tbl_usertest;
CREATE TABLE tbl_usertest (
  user_id INT(8) DEFAULT NULL,
  test_id INT(8) DEFAULT NULL,
  INDEX test_id (test_id),
  INDEX user_id (user_id),
  CONSTRAINT tbl_usertest_ibfk_1 FOREIGN KEY (user_id)
    REFERENCES tbl_user(user_id) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT tbl_usertest_ibfk_2 FOREIGN KEY (test_id)
    REFERENCES tbl_testimonial(test_id) ON DELETE SET NULL ON UPDATE CASCADE
)
ENGINE = INNODB
AVG_ROW_LENGTH = 8192
CHARACTER SET latin1
COLLATE latin1_swedish_ci;

--
-- Definition for table tbl_class
--
DROP TABLE IF EXISTS tbl_class;
CREATE TABLE tbl_class (
  class_id INT(8) NOT NULL AUTO_INCREMENT,
  class_name VARCHAR(50) DEFAULT NULL,
  class_desc VARCHAR(255) DEFAULT NULL,
  class_capacity INT(3) DEFAULT NULL,
  class_image VARCHAR(500) DEFAULT NULL,
  class_day VARCHAR(3) DEFAULT NULL,
  class_stime TIME DEFAULT NULL,
  class_etime TIME DEFAULT NULL,
  class_tier INT(1) DEFAULT NULL,
  class_stat INT(1) DEFAULT NULL,
  PRIMARY KEY (class_id)
)
ENGINE = INNODB
AUTO_INCREMENT = 13
AVG_ROW_LENGTH = 1489
CHARACTER SET latin1
COLLATE latin1_swedish_ci;



--
-- Definition for table tbl_usertier
--
DROP TABLE IF EXISTS tbl_usertier;
CREATE TABLE tbl_usertier (
  user_id INT(8) DEFAULT NULL,
  tier_id INT(8) DEFAULT NULL,
  tier_sub_date DATE DEFAULT NULL,
  tier_duration INT(2) DEFAULT NULL,
  INDEX tier_id (tier_id),
  INDEX user_id (user_id),
  CONSTRAINT tbl_usertier_ibfk_1 FOREIGN KEY (user_id)
    REFERENCES tbl_user(user_id) ON DELETE SET NULL ON UPDATE CASCADE,
  CONSTRAINT tbl_usertier_ibfk_2 FOREIGN KEY (tier_id)
    REFERENCES tbl_tier(tier_id) ON DELETE SET NULL ON UPDATE CASCADE
)
ENGINE = INNODB
AVG_ROW_LENGTH = 5461
CHARACTER SET latin1
COLLATE latin1_swedish_ci;



--
-- Definition for table tbl_testimonial
--
DROP TABLE IF EXISTS tbl_testimonial;
CREATE TABLE tbl_testimonial (
  test_id INT(8) NOT NULL AUTO_INCREMENT,
  test_title VARCHAR(80) DEFAULT NULL,
  test_content VARCHAR(250) DEFAULT NULL,
  test_stars INT(1) DEFAULT NULL,
  test_stat INT(1) DEFAULT NULL,
  PRIMARY KEY (test_id)
)
ENGINE = INNODB
AUTO_INCREMENT = 14
AVG_ROW_LENGTH = 16384
CHARACTER SET latin1
COLLATE latin1_swedish_ci;

--
-- Definition for table tbl_mail
--
DROP TABLE IF EXISTS tbl_mail;
CREATE TABLE tbl_mail (
  mail_id INT(8) NOT NULL AUTO_INCREMENT,
  mail_type VARCHAR(20) DEFAULT NULL,
  mail_subj VARCHAR(80) DEFAULT NULL,
  mail_content VARCHAR(500) DEFAULT NULL,
  mail_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  mail_attachment VARCHAR(255) DEFAULT NULL,
  mail_stat INT(1) DEFAULT NULL,
  PRIMARY KEY (mail_id)
)
ENGINE = INNODB
AUTO_INCREMENT = 4
AVG_ROW_LENGTH = 16384
CHARACTER SET latin1
COLLATE latin1_swedish_ci;



-- 
-- Dumping data for table tbl_class
--
INSERT INTO tbl_class VALUES
(1, 'Bootcamp', 'Try This Out. Fun For The Whole Family', 45, 'class_bootcamp.jpg', 'Sat', '10:00:00', '16:00:00', 1, 1),
(2, 'Strength and Conditioning', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec at enim condimentum, sagittis metus nec, cursus dui. Ut ullamcorper, ipsum vitae\r\n  tincidunt facilisis, metus mi porta risus, non scelerisque nibh massa ac mauris. Pellentesque vitae magna eg', 20, 'class_strength.jpg', 'MON', '20:00:00', '21:00:00', 1, 1),
(3, 'BATTLE ROPES', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec at enim condimentum, sagittis metus nec, cursus dui. Ut ullamcorper, ipsum vitae\r\n  tincidunt facilisis, metus mi porta risus, non scelerisque nibh massa ac mauris. Pellentesque vitae magna eg', 20, 'class_ropes.jpg', 'TUE', '18:00:00', '20:00:00', 1, 1),
(4, 'BOXING', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec at enim condimentum, sagittis metus nec, cursus dui. Ut ullamcorper, ipsum vitae\r\n  tincidunt facilisis, metus mi porta risus, non scelerisque nibh massa ac mauris. Pellentesque vitae magna eg', 20, 'class_boxing.jpg', 'WED', '18:00:00', '20:00:00', 1, 1),
(5, 'GLOBO CYCLE', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec at enim condimentum, sagittis metus nec, cursus dui. Ut ullamcorper, ipsum vitae\r\n  tincidunt facilisis, metus mi porta risus, non scelerisque nibh massa ac mauris. Pellentesque vitae magna eg', 20, 'class_cycle.jpg', 'THU', '10:00:00', '12:00:00', 1, 1),
(6, 'DRAGON BOAT', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec at enim condimentum, sagittis metus nec, cursus dui. Ut ullamcorper, ipsum vitae\r\n  tincidunt facilisis, metus mi porta risus, non scelerisque nibh massa ac mauris. Pellentesque vitae magna eg', 20, 'class_dragonboat.jpg', 'FRI', '15:00:00', '17:00:00', 1, 1),
(7, 'TRX', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec at enim condimentum, sagittis metus nec, cursus dui. Ut ullamcorper, ipsum vitae\r\n  tincidunt facilisis, metus mi porta risus, non scelerisque nibh massa ac mauris. Pellentesque vitae magna eg', 20, 'class_trx.jpg', 'SAT', '17:00:00', '19:00:00', 1, 1),
(8, 'KICKBOXING', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec at enim condimentum, sagittis metus nec, cursus dui. Ut ullamcorper, ipsum vitae\r\n  tincidunt facilisis, metus mi porta risus, non scelerisque nibh massa ac mauris. Pellentesque vitae magna eg', 20, 'class_kickboxing.jpg', 'SUN', '09:00:00', '11:00:00', 1, 1),
(9, 'GLOBOBALL FITNESS', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec at enim condimentum, sagittis metus nec, cursus dui. Ut ullamcorper, ipsum vitae\r\n  tincidunt facilisis, metus mi porta risus, non scelerisque nibh massa ac mauris. Pellentesque vitae magna eg', 20, 'class_powerball.jpg', 'MON', '08:00:00', '10:00:00', 1, 1),
(10, 'Dance Fit', 'Ditch the workout, join the party!  Dancefit is the hottest new fitness class that will feel more like a party than a workout. Fabulous mix of dance styles that will improve endurance, fat-loss and tone your body. Get your groove on and book your place to', 20, 'class_dancefit.jpg', 'Mon', '02:30:00', '03:30:00', 1, 1),
(12, 'Basketball', 'Fun Team Sport. Practice The Fundamentals', 20, 'class_basketball.jpg', 'Wed', '10:00:00', '12:00:00', 1, 1);

-- 
-- Dumping data for table tbl_featured
--
INSERT INTO tbl_featured VALUES
(1, 'New Summer Classes !', 'Get Beach Bod Ready With These New Classes This Summer !', 'Classes.php', 'class_bootcamp.jpg', 1),
(2, '3 Month Premium At 50% Off!', 'Enjoy Your First 3 Months Of Premium Membership At Half The Price! Join Us Now', 'Membership.php', 'class_strength.jpg', 1);

-- 
-- Dumping data for table tbl_mail
--
INSERT INTO tbl_mail VALUES
(3, 'Careers', 'Yo I Wanna Be A Trainer', 'Hi Globogym, I Just Want To Say... I Wanna Apply. Here''s My Cv', '2019-05-10 20:51:38', '', 0);

-- 
-- Dumping data for table tbl_testimonial
--
INSERT INTO tbl_testimonial VALUES
(12, 'Fun for the mates', 'Real fun. Kinda like tug of war with yourself', 5, 1);


-- 
-- Dumping data for table tbl_tier
--
INSERT INTO tbl_tier VALUES
(1, 'STUDENT MEMBERSHIP MONTHLY', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur eu venenatis purus. Nunc tristique ut erat sit amet luctus. Mauris sed odio congue, molestie eros vel, congue mi. Sed id quam id dolor facilisis laoreet at sed ligula. Etiam malesuada justo risus, at rutrum risus ullamcorper quis. Nam sed tempus elit, quis dapibus nulla. Aenean a nunc at risus consequat suscipit.', 29, 8000, '../img/tiers/premium.jpg', 1),
(2, 'STUDENT MEMBERSHIP YEARLY', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur eu venenatis purus.\r\n  Nunc tristique ut erat sit amet luctus. Mauris sed odio congue, molestie eros vel, congue mi. Sed id quam id dolor facilisis\r\n  laoreet at sed ligula. Etiam malesuada justo risus, at rutrum risus ullamcorper quis. Nam sed tempus elit, quis dapibus nulla.\r\n  Aenean a nunc at risus consequat suscipit.', 259, 8000, NULL, 1),
(3, 'ADULT MEMBERSHIP MONTHLY', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur eu venenatis purus.\r\n  Nunc tristique ut erat sit amet luctus. Mauris sed odio congue, molestie eros vel, congue mi. Sed id quam id dolor facilisis\r\n  laoreet at sed ligula. Etiam malesuada justo risus, at rutrum risus ullamcorper quis. Nam sed tempus elit, quis dapibus nulla.\r\n  Aenean a nunc at risus consequat suscipit.', 39, 8000, NULL, 1),
(4, 'ADULT MEMBERSHIP YEARLY', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur eu venenatis purus.\r\n  Nunc tristique ut erat sit amet luctus. Mauris sed odio congue, molestie eros vel, congue mi. Sed id quam id dolor facilisis\r\n  laoreet at sed ligula. Etiam malesuada justo risus, at rutrum risus ullamcorper quis. Nam sed tempus elit, quis dapibus nulla.\r\n  Aenean a nunc at risus consequat suscipit.', 359, 8000, NULL, 1),
(5, 'PREMIUM MEMBERSHIP MONTHLY', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur eu venenatis purus.\r\n  Nunc tristique ut erat sit amet luctus. Mauris sed odio congue, molestie eros vel, congue mi. Sed id quam id dolor facilisis\r\n  laoreet at sed ligula. Etiam malesuada justo risus, at rutrum risus ullamcorper quis. Nam sed tempus elit, quis dapibus nulla.\r\n  Aenean a nunc at risus consequat suscipit.', 49, 8000, NULL, 1),
(6, 'PREMIUM MEMBERSHIP YEARLY', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur eu venenatis purus.\r\n  Nunc tristique ut erat sit amet luctus. Mauris sed odio congue, molestie eros vel, congue mi. Sed id quam id dolor facilisis\r\n  laoreet at sed ligula. Etiam malesuada justo risus, at rutrum risus ullamcorper quis. Nam sed tempus elit, quis dapibus nulla.\r\n  Aenean a nunc at risus consequat suscipit.', 459, 8000, NULL, 1);

-- 
-- Dumping data for table tbl_user
--
INSERT INTO tbl_user VALUES
(1, 'Mr', 'Admin', 'TestAccount', 'Admin', 'Dublin 12', 'GloboGym', 'admin@gmail.com', 14967876, 1, '1998-05-07'),
(10, 'Mr', 'Kiel', 'Cee', 'Member', 'D4', '123 Berry Lane, High County', 'kcee@gmail.com', 835477854, 0, '1997-09-19'),
(11, 'mr', 'Admin', 'Admin', 'Admin', 'D8', '12 Berry Road, Frontier Park', 'admin@globogym.com', 836698745, 0, '1997-09-19'),
(12, 'Mrs', 'Admin2', 'Admin2', 'Member', 'D8', '12 Berry Road, Frontier Park', 'admin2@globogym.com', 836698745, 0, '1980-03-25');

-- 
-- Dumping data for table tbl_classtest
--
INSERT INTO tbl_classtest VALUES
(3, 12),
(2, NULL);

-- 
-- Dumping data for table tbl_creds
--
INSERT INTO tbl_creds VALUES
(10, '$2y$10$j.7ukOM1ZF0Z7aRGZGbjrOCDBQjmYgiVgNpwC1v8QXSbHRuIyz/wG '),
(11, '$2y$10$x5XMV.HmRifXaGAldyzabu3OrIcKctIzVw6AwLud9M/TwaKljx0yy'),
(12, '$2y$10$t0IQeAaEO8bCoaX0QoST0OHkO3uLtSQfcDvB3rlgar3VtX.z7sfIO');

-- 
-- Dumping data for table tbl_logs
--

-- Table globogym.tbl_logs does not contain any data (it is empty)

-- 
-- Dumping data for table tbl_userclass
--

-- Table globogym.tbl_userclass does not contain any data (it is empty)

-- 
-- Dumping data for table tbl_usermail
--
INSERT INTO tbl_usermail VALUES
('Admin@globogym.com', 3, 1);

-- 
-- Dumping data for table tbl_usertest
--
INSERT INTO tbl_usertest VALUES
(11, 12),
(11, NULL);

-- 
-- Dumping data for table tbl_usertier
--
INSERT INTO tbl_usertier VALUES
(10, 1, '2019-05-07', 1),
(11, 1, '2019-05-10', 1),
(12, 1, '2019-05-10', 1);

-- 
-- Enable foreign keys
-- 
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;