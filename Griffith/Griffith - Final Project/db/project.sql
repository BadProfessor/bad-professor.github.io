DROP DATABASE IF EXISTS project;
CREATE DATABASE project;
USE project;

-- Users tables
CREATE TABLE users (
    id int (50) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
-- Reviews table
CREATE TABLE reviews (
    id INT (10) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL,
    comment VARCHAR(255) NOT NULL,
    rating INT(1) NOT NULL
);