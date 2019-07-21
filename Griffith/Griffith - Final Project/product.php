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
?>
<!-- main index container -->
<main role="main" class="container" style="margin-top: 30em;">
    <!-- Boostrap template for the main section -->
    <!-- This will be later populated -->
    <section class="starter-template">
        <div class="card mb-4 shadow-sm">
            <img src="images/1.jpg" alt="Thumbnail" width="50%" height="50%" color="#eceeef" class="card-img-top">
            <div class="card-body">
                <p class="card-text">Spicy jalapeno bacon ipsum dolor amet dolore lorem et ham turkey culpa. Rump ham voluptate jerky velit ea beef.</p>
            </div>
    </section>
    <?php
    // call the crud.php
    require_once("crud.php");
    ?>
</main><!-- /.container -->
<?php
// call the footer.php
require_once("footer.php");
?>