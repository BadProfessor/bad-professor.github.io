<?php
    include_once("header.php");
    // Validate for logged in users → forbidden access.
    if(isset($_SESSION["user_email"]) && isset($_SESSION["user_id"]) && isset($_SESSION["user_type"])){
        header("Location: index.php?error=forbidden");
    }
    
    // Start with form URL validation from the login form.
    // If the user wants to login, a POST method from the URL will be detected.

    if (isset($_POST["submit"])){

         // Set the sanitize function
         function sanitize($data){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            $data = mysqli_real_escape_string($GLOBALS["db_conn"], $data);
            return $data;
        }
        // Sanitize the inputs.
        $email = sanitize($_POST["email"]);
        $password = mysqli_real_escape_string($db_conn, $_POST["psw"]);
        $hash = password_hash($password, PASSWORD_DEFAULT);

        // Lookup email from db
        $email_lookup = "SELECT user_id, user_email, user_type FROM tbl_user WHERE user_email = '$email' LIMIT 1";
        $pull_email = mysqli_query($db_conn, $email_lookup);
                $num = mysqli_num_rows($pull_email);
                // Test if the email query passed.
                if($num==1){
                  while($row = mysqli_fetch_array($pull_email)){
                    // Fetch the password
                    $pass_lookup = "SELECT user_pass FROM tbl_creds WHERE user_id = '".$row["user_id"]."' LIMIT 1";
                    $pull_pass = mysqli_query($db_conn, $pass_lookup);
                    // Test if there's a pass existing for the user being pulled.
                    $num = mysqli_num_rows($pull_pass);
                        if($num==1){
                            while($row2 = mysqli_fetch_assoc($pull_pass)){
                                // Test if password is verified
                                $verify =  $row2["user_pass"];
                                if(password_verify($password, $verify)){
                                    // Assign session values
                                    $_SESSION["user_id"] = $row["user_id"];
                                    $_SESSION["user_email"] = $row["user_email"];
                                    $_SESSION["user_type"] = $row["user_type"];
                                    header("Location: index.php?login=success");
                                }else{
                                    // Password doesn't match
                                    header("Location: login.php?login=failedpassword");
                                }
                            }
                        }
                        // User has no password set. Maybe reset the password?? Make a page.
                  }
                }else{
                  // There's no user with that email, throw an error
                  header("Location: login.php?login=failedemail");
                }
    }
?>
    <section class = "login">
      <div class = "login_area">
          <form action="login.php" method="POST">
            <h1>MEMBER LOGIN</h1>
            <label for="email"><b>Email:</b></label><input type="email" name="email" id = "email"/>
            <label><b>Password:</b></label><input type="password" name="psw" required><br>
            <input type="submit" name="submit" value="Login" hidden>
          </form>
      </div>
    </section>
<?php
    require_once("footer.php");
?>
