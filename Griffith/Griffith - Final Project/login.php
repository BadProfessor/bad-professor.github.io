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
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
// Processing form data when form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the username is empty
    if (empty(test_input($_POST["username"]))) {
        $username_err = "Please enter the username";
    } else {
        // if not empty, input
        $username = test_input($_POST["username"]);
    }
    // Check if password is empty
    if (empty(test_input($_POST["password"]))) {
        $password_err = "Please enter your password";
    } else {
        // if not empty, input
        $password = test_input($_POST["password"]);
    }
    // Validate the credentials
    if (empty($username_err) && empty($password_err)) {
        // Store an sql statement
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        // Prepare an SQL statement for execution
        if ($stmt = mysqli_prepare($link, $sql)) {
            // Bind string variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            // Set parameters
            $param_username = $username;
            // Attempt to execute the prepared query statement
            if (mysqli_stmt_execute($stmt)) {
                // Store the result
                mysqli_stmt_store_result($stmt);
                // Check if username exists, if yes then verify password
                // check the number of rows
                if (mysqli_stmt_num_rows($stmt) == 1) {
                    // Bind the result variables
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    // fetch the result
                    if (mysqli_stmt_fetch($stmt)) {
                        if (password_verify($password, $hashed_password)) {
                            // If the password is correct start a new session
                            session_start();
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;
                            // Redirect the user to the index page
                            header("location: index.php");
                        } else {
                            // Display an error message if password is not valid
                            $password_err = "The username and/or password you entered was not valid";
                        }
                    }
                } else {
                    // Display an error message if username doesn't exist
                    // For security reasons we are not specifying if the username or the password is incorrect
                    $username_err = "The username and/or password you entered was not valid";
                }
            } else {
                echo "<p class ='alert alert-danger'>Oops! Something went wrong Please try again later</p>";
            }
        }
        // Close the statement
        mysqli_stmt_close($stmt);
    }
}
?>
<section class="container">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" class="form-signin" method="POST">
        <h1 class="h3 mb-3 font-weight-normal">Login</h1>
        <p>Please fill in your credentials to login</p>
        <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
            <label>Username</label>
            <input type="text" name="username" class="form-control" pattern="[a-zA-Z]{1,50}" autofocus required value="<?php echo $username; ?>">
            <span class="help-block"><?php echo $username_err; ?></span>
        </div>
        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
            <label>Password</label>
            <input type="password" name="password" class="form-control" placeholder="Minimum 8 charachters" minlength="8" required>
            <span class="help-block"><?php echo $password_err; ?></span>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Login">
        </div>
        <p>Don't have an account? <a href="register.php">Sign up now</a></p>
    </form>
</section>
<?php
// include the footer
require_once("footer.php");
?>