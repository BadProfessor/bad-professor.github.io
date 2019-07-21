<?php
    require_once("connection.php");
?>
<!DOCTYPE html>
<html lang = "en">
  <head>
    <meta charset="utf-8"/>
    <title>Globo Gym</title>
    <meta name="viewport" content="width=device-width, intial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="img/logo.png">
    <script src="https://code.jquery.com/jquery-3.1.1.js"></script>
    <script src="js/main.js"></script>
  </head>
  <body>
    <header>
      <div><a href="index.php"><img src="img/GloboGymLogo.png" alt= "home logo" id ="logo"></a></div>
      <label id= "burger" for="toggle">&#9776;</label>
      <input type="checkbox" id="toggle"/>
      <nav class="nav_main">
        <ul class="nav_list">
          <li><a href="membership.php">MEMBERSHIP</a></li>
          <li><a href="classes.php">CLASSES</a></li>
          <li><a href="about_us.php">ABOUT US</a></li>
          <li><a href="testimonial.php">TESTIMONIAL</a></li>
          <li><a href="careers.php">CAREERS</a></li>
          <li><a href="contact_us.php">CONTACT US</a></li>
          <!-- Validate if someone is logged in -->
          <?php 
            if(isset($_SESSION["user_email"]) && isset($_SESSION["user_id"]) && isset($_SESSION["user_type"])){
              if($_SESSION["user_type"]=="Admin"){
                echo '<li class = "special"><a href="admin_index.php">Admin Menu</a></li>';
              } else {
                echo '<li class = "special"><a href="my_account.php">Account</a></li>';
              }
              echo '<li class = "special"><a href="logout.php?logout=true">Log Out</a></li>';
            // Test if session variables are unset == no user logged in
            }else if(!(isset($_SESSION["user_email"]) && isset($_SESSION["user_id"]) && isset($_SESSION["user_type"]))){
                echo '<li class = "special"><a href="join_now.php">JOIN NOW</a></li>
                      <li class = "special"><a href="login.php">LOG IN</a></li>';
            // Test if any one of the sessions are set then there's an error. Redirect to logout to reset all sessions
            }else{
                header("Location: logout.php?logout=true");
            }
          ?>
        </ul>
      </nav>
    </header>
