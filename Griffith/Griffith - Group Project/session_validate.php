<?php 
// Include the connection that starts the session
include_once("connection.php");
    // Test if all session variables are filled == a user is logged in. THESE ARE FOR THE MEMBER PAGES
    if(isset($_SESSION["user_email"]) && isset($_SESSION["user_id"]) && isset($_SESSION["user_type"])){
        if ($_SESSION["user_type"] == "Admin"){
            // The admin is valid to stay on the page. 
        }else{
            header("Location: index.php?error=forbidden");
        }
    // Test if session variables are unset == no user logged in
    }else if(!(isset($_SESSION["user_email"]) && isset($_SESSION["user_id"]) && isset($_SESSION["user_type"]))){
    // Test if any all of these sessions are unset then no user is logged in
    header("Location: index.php");
    }else if((isset($_SESSION["user_email"])) || (isset($_SESSION["user_id"])) || (isset($_SESSION["user_type"]))){
        header("Location: logout.php?logout=true");
    // Test if any one of the sessions are set then there's an error. Redirect to logout to reset all sessions
    }else{
        header("Location: index.php?error=forbidden");
    }
    // Test for empty session exceptions (See logging out).
    if(isset($_GET["handle"])){
        header("Location: index.php");
    }
// Always close the database set by the connection
// mysqli_close($db_conn);
?>