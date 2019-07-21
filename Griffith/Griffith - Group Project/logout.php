<?php
// Include the connection that starts the session
include_once("connection.php");
    // Validate the URL.
    if(isset($_GET["logout"])){
        // Destroy all session variables.
        session_destroy();
        unset($_SESSION["user_email"]);
        unset($_SESSION["user_id"]);
        unset($_SESSION["user_type"]);
        header("Location: index.php");
    // If the URL isn't set, validate the sessions.
    }else{
        header("Location: session_validate.php?handle=true");
    }
// Always close the database set by the connection
mysqli_close($db_conn);
?>