<?php
// call the header.php
require_once("header.php");
// Initialize the session
session_start();
// Check if the user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    // if not, log in
    header("location: login.php");
    exit;
}
// ?>
<section class="bg"></section>
<!-- main index container -->
<main role="main" class="container center wh">
    <!-- Boostrap template for the main section -->
    <!-- This will be later populated -->
    <div class="starter-template">
        <p class="lead">Hi, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Welcome to our site.</p>
        <p  class="lead">
            <a href="reset_password.php" class="btn btn-warning">Reset Password</a>
            <a href="logout.php" class="btn btn-danger">Log Out</a>
        </p>
    </div>
</main><!-- /.container -->
<?php
// call the footer.php
require_once("footer.php");
?>