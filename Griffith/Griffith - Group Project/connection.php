<?php
// Essential include. Must be defined, alwasys.
    session_start();
    // Testing logged in functions. Comment this out for production environment
    // $_SESSION["user_email"] = "test@globogym.com";
    // $_SESSION["user_id"] = "1";
    // connect to the database
    DEFINE('DB_USER', 'root'); 
    DEFINE('DB_PASSWORD', ''); 
    DEFINE('DB_HOST', 'localhost'); 
    DEFINE('DB_NAME', 'globogym'); 
    $db_conn = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR 
    die("Could not connect to MySQL! ". mysqli_connect_error());
    mysqli_set_charset($db_conn, 'utf8');
?>