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
// Check existence of id parameter before processing further
if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    // Include header file
    require_once "header.php";

    // Prepare a select statement
    $sql = "SELECT * FROM reviews WHERE id = ?";

    if ($stmt = mysqli_prepare($link, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);

        // Set parameters
        $param_id = trim($_GET["id"]);

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) == 1) {
                /* Fetch result row as an associative array. Since the result set contains only one row, we don't need to use while loop */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);

                // Retrieve individual field value
                $username = $row["username"];
                $comment = $row["comment"];
                $rating = $row["rating"];
            } else {
                // URL doesn't contain valid id parameter. Redirect to error page
                header("location: error.php");
                exit();
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }

    // Close statement
    mysqli_stmt_close($stmt);
} else {
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
}
?>
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="pb-2 mt-4 mb-2 border-bottom">
                    <h1>View Record</h1>
                </div>
                <div class="form-group">
                    <label>Username</label>
                    <p class="form-control-static"><?php echo $row["username"]; ?></p>
                </div>
                <div class="form-group">
                    <label>Comment</label>
                    <p class="form-control-static"><?php echo $row["comment"]; ?></p>
                </div>
                <div class="form-group">
                    <label>Rating</label>
                    <p class="form-control-static"><?php echo $row["rating"]; ?></p>
                </div>
                <p><a href="product.php" class="btn btn-primary">Back</a></p>
            </div>
        </div>
    </div>
</div>
<?php
require_once("footer.php");
?>