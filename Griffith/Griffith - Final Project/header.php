<?php
// call the header.php
require_once("connection.php");
?>
<!-- header module -->
<!-- Meta tags -->
<!DOCTYPE html>
<!-- english html -->
<html lang="en">

<head>
    <!-- UTF-8 -->
    <meta charset="UTF-8">
    <!-- responsive viewport -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Microsfot compatibility -->
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- custom css -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <!-- Implementing Bootstrap v4.3.1 -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- Unique Font Awesome code -->
    <script src="https://kit.fontawesome.com/d2f0bd6b0b.js"></script>
    <!-- title for all websites -->
    <title>BadGuitars</title>
</head>

<body>
    <header>
        <!-- Boostrap template for the header -->
        <!-- navbar Icon -->
        <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
            <a class="navbar-brand" href="index.php">BadGuitars</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <!-- links on the left -->
            <div class="collapse navbar-collapse" id="navbarsExampleDefault">
                <ul class="navbar-nav mr-auto">
                    <!-- Album link -->
                    <li class="nav-item active">
                        <a class="nav-link" href="album.php">Album<span class="sr-only">(current)</span></a>
                    </li>
                </ul>
                <!-- <a href="register.php"><button class="btn btn-secondary my-2 my-sm-0">Register</button></a>
        <a href="login.php"><button class="btn btn-secondary my-2 my-sm-0">Log In</button></a>';
        <a href="logout.php?logout=true"><button class="btn btn-secondary my-2 my-sm-0">Log Out</button></a> -->
            </div>
        </nav>
    </header>