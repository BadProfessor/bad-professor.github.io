<?php
// call the header.php
require_once("header.php");
// Initialize the session
session_start();
// TO BE UNCOMMENTED
// Check if the user is logged in, if not then redirect to login page
// if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
//     header("location: login.php");
//     exit;
// }
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
// Define variables and initialize with empty values
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";
// Processing form data when the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate new password
    if (empty(test_input($_POST["new_password"]))) {
        $new_password_err = "Please enter the new password.";
        // check the length
    } elseif (strlen(test_input($_POST["new_password"])) < 8) {
        $new_password_err = "Password must have atleast 8 characters.";
    } else {
        $new_password = test_input($_POST["new_password"]);
    }
    // Validate the confirm password
    if (empty(test_input($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm the password.";
    } else {
        $confirm_password = test_input($_POST["confirm_password"]);
        if (empty($new_password_err) && ($new_password != $confirm_password)) {
            $confirm_password_err = "Password did not match.";
        }
    }
    // Check input errors before updating the database
    // check if the passwords match
    if (empty($new_password_err) && empty($confirm_password_err)) {
        // Prepare an update statement
        $sql = "UPDATE users SET password = ? WHERE id = ?";
        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);
            // Set parameters
            // hash it
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            // set the session i
            $param_id = $_SESSION["id"];
            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Password updated successfully
                // Destroy the session
                session_destroy();
                // redirect to login page
                header("location: login.php");
                // exit
                exit();
            } else {
                // <p class ='alert alert-danger'></p>
                echo "<p class ='alert alert-danger'>Oops! Something went wrong. Please try again later</p>";
            }
        }
        // Close the statement
        mysqli_stmt_close($stmt);
    }
}
?>
<section class="container">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="form-signin" method="post">
        <h2 class="h3 mb-3 font-weight-normal">Reset Password</h2>
        <p>Fill out this form to reset your password.</p>
        <div class="form-group <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
            <label>New Password</label>
            <input type="password" name="new_password" class="form-control" placeholder="Minimum 8 charachters" minlength="8" value="<?php echo $new_password; ?>">
            <span class="help-block"><?php echo $new_password_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
            <label>Confirm Password</label>
            <input type="password" name="confirm_password" placeholder="Minimum 8 charachters" minlength="8" class="form-control">
            <span class="help-block"><?php echo $confirm_password_err; ?></span>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Submit">
            <a class="btn btn-link" href="index.php">Cancel</a>
        </div>
    </form>
</section>
<?php
// call the footer.php
require_once("footer.php");
?>