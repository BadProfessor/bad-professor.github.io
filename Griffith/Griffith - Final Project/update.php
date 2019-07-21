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
if (isset($_POST["id"]) && !empty($_POST["id"])) {
    // Get hidden input value
    $id = $_POST["id"];

    // Validate username
    // keeping the original source code
    // $input_username = trim($_POST["username"]);
    $input_username = test_input($_SESSION["username"]);
    if (empty($input_username)) {
        $username_err = "Please enter a username.";
    } elseif (!filter_var($input_username, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-Z\s]+$/")))) {
        $username_err = "Please enter a valid username.";
    } else {
        $username = $input_username;
    }

    // Validate comment comment
    $input_comment = test_input($_POST["comment"]);
    if (empty($input_comment)) {
        $comment_err = "Please enter a comment.";
    } else {
        $comment = $input_comment;
    }

    // Validate rating
    $input_rating = test_input($_POST["rating"]);
    if (empty($input_rating)) {
        $rating_err = "Please enter the rating amount.";
    } elseif (!ctype_digit($input_rating)) {
        $rating_err = "Please enter a positive integer value.";
    } else {
        $rating = $input_rating;
    }

    // Check input errors before inserting in database
    if (empty($username_err) && empty($comment_err) && empty($rating_err)) {
        // Prepare an update statement
        $sql = "UPDATE reviews SET username=?, comment=?, rating=? WHERE id=?";

        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssi", $param_username, $param_comment, $param_rating, $param_id);

            // Set parameters
            $param_username = $username;
            $param_comment = $comment;
            $param_rating = $rating;
            $param_id = $id;

            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Records updated successfully. Redirect to landing page
                header("location: product.php");
                exit();
            } else {
                echo "Something went wrong. Please try again later.";
            }
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }
} else {
    // Check existence of id parameter before processing further
    if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
        // Get URL parameter
        $id =  trim($_GET["id"]);

        // Prepare a select statement
        $sql = "SELECT * FROM reviews WHERE id = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);

            // Set parameters
            $param_id = $id;

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
                    // URL doesn't contain valid id. Redirect to error page
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
}
?>
<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="pb-2 mt-4 mb-2 border-bottom">
                    <h2>Update Record</h2>
                </div>
                <p>Please edit the input values and submit to update the record.</p>
                <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                    <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                        <label>Username</label>
                        <!-- <input type="text" name="username" class="form-control" value="<?php/* echo $username; */?>"> -->
                        <input type="text" name="username" class="form-control" disabled required value="<?php echo htmlspecialchars($_SESSION["username"]); ?>">
                        <span class="help-block"><?php echo $username_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($comment_err)) ? 'has-error' : ''; ?>">
                        <label>Comment</label>
                        <textarea name="comment" class="form-control" required ><?php echo $comment; ?></textarea>
                        <span class="help-block"><?php echo $comment_err; ?></span>
                    </div>
                    <div class="form-group <?php echo (!empty($rating_err)) ? 'has-error' : ''; ?>">
                        <label>Rating</label>
                        <input type="number" name="rating" class="form-control" min="1" max="5" required value="<?php echo $rating; ?>">
                        <span class="help-block"><?php echo $rating_err; ?></span>
                    </div>
                    <input type="hidden" name="id" value="<?php echo $id; ?>" />
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