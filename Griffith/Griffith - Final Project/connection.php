<?php
// Essential include. Must be defined, always.
    // we will only use the localhost
    DEFINE('DB_SERVER', 'localhost');
    // define the user as root
    DEFINE('DB_USERNAME', 'root');
    // define the password, in this case no password since it is only a closed project
    DEFINE('DB_PASSWORD', '');
    // the name of the database
    DEFINE('DB_NAME', 'project');
    // connect it to the database
    $link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME) OR
    // error if it cannot connect
    die("Could not connect to MySQL! Error: ".mysqli_connect_error());
    // define the charachter set
    mysqli_set_charset($link, 'utf8');
?>