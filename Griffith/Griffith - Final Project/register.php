<?php
// include the header
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
// Input of information of Forms
$username = $password = $confirm_password = "";
// Declare the Error Messages
$username_err = $password_err = $confirm_password_err = "";
// If posted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate the username
    if (empty(test_input($_POST["username"]))) {
        $username_err = "Please enter a username";
    } elseif (!preg_match("/[a-zA-Z]{1,50}/", (test_input($_POST["username"])))) {
        $username_err = "Invalid Username Please use only letters";
    } else {
        // Store an sql statement
        $sql = "SELECT id FROM users WHERE username = ?";
        // Prepare an SQL statement for execution
        if ($stmt = mysqli_prepare($link, $sql)) {
            // Binds variables to a prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            // Set parameters
            $param_username = test_input($_POST["username"]);
            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Transfers a result set from a prepared statement
                mysqli_stmt_store_result($stmt);
                // Return the number of rows in statements result set
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    $username_err = "This username is already taken";
                } else {
                    $username = test_input($_POST["username"]);
                }
            } else {
                echo "<p class ='alert alert-danger'>Oops! Something went wrong Please try again later</p>";
            }
        }
        // Close statement
        mysqli_stmt_close($stmt);
    }
    // Validate the password
    if (empty(test_input($_POST["password"]))) {
        $password_err = "Please enter a password";
    } elseif (strlen(test_input($_POST["password"])) < 8) {
        $password_err = "Password must have at least 8 characters";
    } else {
        $password = test_input($_POST["password"]);
    }
    // Validate the confirm password
    if (empty(test_input($_POST["confirm_password"]))) {
        $confirm_password_err = "Please confirm password";
    } else {
        $confirm_password = test_input($_POST["confirm_password"]);
        if (empty($password_err) && ($password != $confirm_password)) {
            $confirm_password_err = "The passwords did not match";
        }
    }
    // Check input errors before inserting in database
    if (empty($username_err) && empty($password_err) && empty($confirm_password_err)) {
        // Prepare an insert statement
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind variables to the prepared statement as parameters and strings
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            // Set the parameters
            $param_username = $username;
            // Creates a password hash and uses the default hashing algorithm
            $param_password = password_hash($password, PASSWORD_DEFAULT);
            // Attempt to execute the prepared statement
            if (mysqli_stmt_execute($stmt)) {
                // Redirect to login page
                header("location: login.php");
            } else {
                echo "<p class ='alert alert-danger'>Something went wrong. Please try again later</p>";
            }
        }
        // Close the statement
        mysqli_stmt_close($stmt);
    }
}
?>
<!-- I will just comment the form in this page because it will be similar for log in and reset password -->
<section class="container">
    <!-- execute the form -->
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="form-signin">
        <h1 class="h3 mb-3 font-weight-normal">Register</h1>
        <!-- execute the username and its html classes -->
        <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
            <label>Username</label>
            <input type="text" name="username" class="form-control" pattern="[a-zA-Z]{1,50}" placeholder="Letters only" autofocus required value="<?php echo $username; ?>">
            <!-- if error, display it-->
            <span class="form-text"><?php echo $username_err; ?></span>
        </div>
        <!-- execute password -->
        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
            <label>Password</label>
            <input type="password" name="password" class="form-control" placeholder="Minimum 8 charachters" minlength="8" required value="<?php echo $password; ?>">
            <span class="form-text"><?php echo $password_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
            <label>Confirm Password</label>
            <input type="password" name="confirm_password" class="form-control" placeholder="Minimum 8 charachters" minlength="8" required value="<?php echo $confirm_password; ?>">
            <span class="form-text"><?php echo $confirm_password_err; ?></span>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Submit">
            <input type="reset" class="btn btn-default" value="Reset">
        </div>
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </form>
</section>
<?php
require_once("footer.php");
?>