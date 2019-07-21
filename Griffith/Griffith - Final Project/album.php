<?php
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
<!-- Album custom css -->
<script>
    void(document.styleSheets.item(0).disabled = true);
</script>
<!-- as per the standard I have didn't add another head tag, but I still needed the separate css because it would break the album page -->
<link rel="stylesheet" type="text/css" href="css/album.css">
<main role="main">
    <section class="jumbotron text-center">
        <div class="container">
            <h1 class="jumbotron-heading">Bad Guitar Gallery</h1>
            <p class="lead text-muted">Welcome to the bad gallery. Please leave your critical comment by clicking on one of the images.</p>
        </div>
    </section>
    <div class="album py-5 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <img src="images/1.jpg" alt="Thumbnail" width="100%" height="225" color="#eceeef" class="card-img-top">
                        <div class="card-body">
                            <p class="card-text">Spicy jalapeno bacon ipsum dolor amet dolore lorem et ham turkey culpa. Rump ham voluptate jerky velit ea beef.</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <a href="product.php"><button type="button" class="btn btn-sm btn-outline-secondary" >View</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <img src="images/2.jpg" alt="Thumbnail" width="100%" height="225" color="#eceeef" class="card-img-top">
                        <div class="card-body">
                            <p class="card-text">Spicy jalapeno bacon ipsum dolor amet dolore lorem et ham turkey culpa. Rump ham voluptate jerky velit ea beef.</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <img src="images/3.jpg" alt="Thumbnail" width="100%" height="225" color="#eceeef" class="card-img-top">
                        <div class="card-body">
                            <p class="card-text">Spicy jalapeno bacon ipsum dolor amet dolore lorem et ham turkey culpa. Rump ham voluptate jerky velit ea beef.</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <img src="images/4.jpg" alt="Thumbnail" width="100%" height="225" color="#eceeef" class="card-img-top">
                        <div class="card-body">
                            <p class="card-text">Spicy jalapeno bacon ipsum dolor amet dolore lorem et ham turkey culpa. Rump ham voluptate jerky velit ea beef.</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <img src="images/5.jpg" alt="Thumbnail" width="100%" height="225" color="#eceeef" class="card-img-top">
                        <div class="card-body">
                            <p class="card-text">Spicy jalapeno bacon ipsum dolor amet dolore lorem et ham turkey culpa. Rump ham voluptate jerky velit ea beef.</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <img src="images/6.jpg" alt="Thumbnail" width="100%" height="225" color="#eceeef" class="card-img-top">
                        <div class="card-body">
                            <p class="card-text">Spicy jalapeno bacon ipsum dolor amet dolore lorem et ham turkey culpa. Rump ham voluptate jerky velit ea beef.</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <img src="images/7.jpg" alt="Thumbnail" width="100%" height="225" color="#eceeef" class="card-img-top">
                        <div class="card-body">
                            <p class="card-text">Spicy jalapeno bacon ipsum dolor amet dolore lorem et ham turkey culpa. Rump ham voluptate jerky velit ea beef.</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <img src="images/8.jpg" alt="Thumbnail" width="100%" height="225" color="#eceeef" class="card-img-top">
                        <div class="card-body">
                            <p class="card-text">Spicy jalapeno bacon ipsum dolor amet dolore lorem et ham turkey culpa. Rump ham voluptate jerky velit ea beef.</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card mb-4 shadow-sm">
                        <img src="images/9.jpg" alt="Thumbnail" width="100%" height="225" color="#eceeef" class="card-img-top">
                        <div class="card-body">
                            <p class="card-text">Spicy jalapeno bacon ipsum dolor amet dolore lorem et ham turkey culpa. Rump ham voluptate jerky velit ea beef.</p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-outline-secondary">View</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<section class="container text-center">
    <!-- This will be later populated -->
    <div class="starter-template">
        <!-- escape the characters -->
        <p class="lead">
            <a href="reset_password.php" class="btn btn-warning">Reset Password</a>
            <a href="logout.php" class="btn btn-danger">Log Out</a>
        </p>
    </div>
</section>
<?php
require_once("footer.php");
?>