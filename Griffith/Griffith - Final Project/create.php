<?php
// call the header.php
require_once("header.php");
//Sanitize the data input from the user
function test_input($data)
{
    // remove the white spaces
    $data = trim($data);
    // remove the slashes
    $data = stripslashes($data);
    // converts special characters into HTML entities
    $data = htmlspecialchars($data);
    // escape special charachters for SQL statements
    $data = mysqli_real_escape_string($GLOBALS["link"], $data);
    return $data;
}
// Initialize the session
session_start();
// Check if the user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    // if not, log in
    header("location: login.php");
    exit;
}
// Define variables and initialize with empty values
$username = $comment = $rating = "";
$username_err = $comment_err = $rating_err = "";
// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate username
    // original input, just changing it to the session's username, but keeping the original code for referrence
    // $input_username = trim($_POST["username"]);
    $input_username = test_input($_SESSION["username"]);
    if (empty($input_username)) {
        $username_err = "Please enter a username.";
    } elseif (!filter_var($input_username, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $username_err = "Please enter a valid username.";
    } else {
        $username = $input_username;
    }

    // Validate comment
    $input_comment = test_input($_POST["comment"]);
    if (empty($input_comment)) {
        $comment_err = "Please enter an comment.";
    } else {
        $comment = $input_comment;
    }

    // Validate rating
    $input_rating = test_input($_POST["rating"]);
    if (empty($input_rating)) {
        $rating_err = "Please enter the rating amount.";
    } elseif (!ctype_digit($input_rating))  {
        $rating_err = "Please enter a positive integer value.";
    } else {
        $rating = $input_rating;
    }

    // Check input errors before inserting in database
    if (empty($username_err) && empty($comment_err) && empty($rating_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO reviews (username, comment, rating) VALUES (?, ?, ?)";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_username, $param_comment, $param_rating);
            // Set parameters
            $param_username = $username;
            $param_comment = $comment;
            $param_rating = $rating;
            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Records created successfully. Redirect to landing page
                header("location: product.php");
                exit();
            } else {
                echo "Something went wrong. Please try again later.";
            }
        }
        // Close statement
        mysqli_stmt_close($stmt);
    }
}
?>
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="pb-2 mt-4 mb-2 border-bottom">
                    <h2>Create Record</h2>
                </div>
                <p>Please fill this form and submit to add review record to the database.</p>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                    <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                        <label>Username</label>
                        <!-- <input type="text" name="username" class="form-control" value="<?php /*echo $username; */?>"> -->
                        <input type="text" name="username" class="form-control" disabled required value="<?php echo htmlspecialchars($_SESSION["username"]); ?>">
                        <span class="help-block"><?php echo $username_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($comment_err)) ? 'has-error' : ''; ?>">
                        <label>Comment</label>
                        <textarea name="comment" class="form-control" required><?php echo $comment; ?></textarea>
                        <span class="help-block"><?php echo $comment_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($rating_err)) ? 'has-error' : ''; ?>">
                        <label>Rating</label>
                        <input type="number" name="rating" class="form-control" min="1" max="5" required placeholder="1-5" value="<?php echo $rating; ?>">
                        <span class="help-block"><?php echo $rating_err; ?></span>
                    </div>
                    <input type="submit" class="btn btn-primary" value="Submit">
                    <a href="product.php" class="btn btn-default">Cancel</a>
                </form>
            </div>
        </div>
    </div>
</div>
<?php
require_once("footer.php");
?>