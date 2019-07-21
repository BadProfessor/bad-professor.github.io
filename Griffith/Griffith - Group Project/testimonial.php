<?php
    require_once("header.php");
    // Run scripts for URL verification - used for submitted forms and the search function
    if(isset($_POST["add_test"])){
      // Validate input values title, stars, content
      $class = $_POST["class"];
      $title = $_POST["title"];
      $content = $_POST["content"];
      $stars = $_POST["stars"];

      // Test for empty inputs
      if (empty($title) || empty($content) || empty($stars)){
        header("Location: testimonial.php?error=empty");
      }

      // Test for patterns
      if((!(preg_match('/^[0-9]*$/', $class))) || (!(preg_match('/^[a-zA-Z0-9_\- ,.!?]{5,80}$/', $title))) || (!(preg_match('/[0-5]{1}/', $stars))) || (!(preg_match('/^[a-zA-Z0-9_\- .!?.,]{20,250}$/', $content)))){
        header("Location: testimonial.php?error=pattern");
      }else{
          // Sanitize
          $class = mysqli_real_escape_string($db_conn, trim(filter_var($class, FILTER_SANITIZE_NUMBER_INT)));
          $title = mysqli_real_escape_string($db_conn, trim(filter_var($title, FILTER_SANITIZE_STRING)));
          $stars = mysqli_real_escape_string($db_conn, trim(filter_var($stars, FILTER_SANITIZE_NUMBER_INT)));
          $content = mysqli_real_escape_string($db_conn, trim(filter_var($content, FILTER_SANITIZE_STRING)));

          // Prepare for insertion
          $insert_test_query = "INSERT INTO tbl_testimonial(test_title, test_content, test_stars, test_stat) VALUES('$title', '$content', '$stars', '0')";
          if (!(mysqli_query($db_conn, $insert_test_query))) {
            die("Error: ".mysqli_error($db_conn));
            header("Location: testimonial.php?error=insertquery");
          }
          // Grab latest test id for usertest insertion
          $pull_testid_query = "SELECT test_id FROM tbl_testimonial WHERE test_title = '$title' AND test_content = '$content' AND test_stars='$stars' LIMIT 1";
          $testid = "";
          $pull_testid_result = mysqli_query($db_conn, $pull_testid_query);
                if($pull_testid_result){
                  $num = mysqli_num_rows($pull_testid_result);
                  //  Test for valid test result
                  if($num>0){
                    while($row = mysqli_fetch_array($pull_testid_result)){
                      // Echo out the id
                      $testid = $row["test_id"];
                    }
                  }else{
                    // Echo out if there are no id listed.
                    header("Location: testimonial.php?error=noidlisted");
                  }
                }
          // Usertest insertion
          $insert_usertest_query = "INSERT INTO tbl_usertest VALUES('".$_SESSION["user_id"]."', '$testid')";
          if (!(mysqli_query($db_conn, $insert_usertest_query))) {
            die("Error: ".mysqli_error($db_conn));
            header("Location: testimonial.php?error=inserttestuser");
          }else{
            header("Location: testimonial.php?success=insert");
          }

          // Classtest insertion
          $insert_classtest_query = "INSERT INTO tbl_classtest VALUES('".$class."', '$testid')";
          if (!(mysqli_query($db_conn, $insert_classtest_query))) {
            die("Error: ".mysqli_error($db_conn));
            header("Location: testimonial.php?error=inserttestuser");
          }else{
            header("Location: testimonial.php?success=insert");
          }
      }

    }

?>
    <!-- Static HTML starts here -->
    <section class = "testimonial_container">
      <form action="testimonial.php" method="POST" class ="form_search_container">
        <h3>MEMBER TESTIMONIALS</h3>
        <select name ="class_select" class ="class_select">
         <!-- Pull class names from the database -->
         <?php
             $pull_class = "SELECT class_id, class_name FROM tbl_class WHERE class_stat = '1'";
             $pull_class_result = mysqli_query($db_conn, $pull_class);
             if($pull_class_result){
               $num = mysqli_num_rows($pull_class_result);
              //  Test for valid test result
              if($num>0){
                while($row =mysqli_fetch_array($pull_class_result)){
                  // Echo out the classes
                  echo '<option value="'.$row["class_id"].'">'.$row["class_name"].'</option>';
                }
              }else{
                // Echo out if there are no classes listed.
                echo '<option>No classes available</option>';
              }
             }
          ?>
        </select>
        <input type="submit" name="search" value="SEARCH" class ="search_button">
        <p class ="write_button"><a href="#write">WRITE TESTIMONIAL</a></p>
      </form>
      <section class = "testimonial">
      <!-- PHP Script to pull testimonial data from the database -->
      <?php
          if(isset($_POST["search"])){
            $pull_test = "SELECT tbl_testimonial.test_title, tbl_testimonial.test_content, tbl_testimonial.test_stars, tbl_class.class_name, tbl_user.user_fname FROM tbl_testimonial INNER JOIN tbl_usertest ON tbl_testimonial.test_id = tbl_usertest.test_id INNER JOIN tbl_user ON tbl_usertest.user_id = tbl_user.user_id INNER JOIN tbl_classtest ON tbl_classtest.test_id = tbl_testimonial.test_id INNER JOIN tbl_class ON tbl_class.class_id = tbl_classtest.class_id WHERE tbl_testimonial.test_stat = '1' AND tbl_class.class_id = '".$_POST["class_select"]."' GROUP BY tbl_testimonial.test_id DESC";
            $pull_test_result = mysqli_query($db_conn, $pull_test);
            if($pull_test_result){
             $num = mysqli_num_rows($pull_test_result);
             //Test for valid search
             if($num> 0){
               while($row = mysqli_fetch_array($pull_test_result)){
                 // Echo out a row of testimonials
                 echo'<div class="testimonial">
                        <div class="card">
                           <p>"'.$row["test_content"].'"</p>
                           <p class ="member">'.$row["class_name"].', '.$row["test_stars"].' Stars, '.$row["user_fname"].'<p>
                         </div>
                      </div>';
               }
             }else{
               echo "<h2>There are no testimonials to display</h2>";
             }
            }
          }else{
            $pull_test = "SELECT tbl_testimonial.test_title, tbl_testimonial.test_content, tbl_testimonial.test_stars, tbl_class.class_name, tbl_user.user_fname FROM tbl_testimonial INNER JOIN tbl_usertest ON tbl_testimonial.test_id = tbl_usertest.test_id INNER JOIN tbl_user ON tbl_usertest.user_id = tbl_user.user_id INNER JOIN tbl_classtest ON tbl_classtest.test_id = tbl_testimonial.test_id INNER JOIN tbl_class ON tbl_class.class_id = tbl_classtest.class_id WHERE tbl_testimonial.test_stat = '1' GROUP BY tbl_testimonial.test_id DESC";
           $pull_test_result = mysqli_query($db_conn, $pull_test);
           if($pull_test_result){
            $num = mysqli_num_rows($pull_test_result);
            //Test for valid search
            if($num> 0){
              while($row = mysqli_fetch_array($pull_test_result)){
                // Echo out a row of testimonials
                echo '<div class="testimonial">
                        <div class="card">
                          <p>"'.$row["test_content"].'"</p>
                          <p class ="member">'.$row["class_name"].', '.$row["test_stars"].' Stars, '.$row["user_fname"].'<p>
                        </div>
                      </div>';
              }
            }else{
              echo "<h3>There are no testimonials to display</h3>";
            }
           }
          }

      ?>
      </section>
      <!-- PHP Script to display the write testimonial form -->
      <div id="borderwrite"></div>
      <section class ="testimonContainer">
      <?php
      // Test for logged in user
        if(isset($_SESSION['user_email'])){
          echo '<form action="testimonial.php" method="POST" class ="testimonial_form">
                  <h2>WRITE TESTIMONIAL</h2>
                  <label>CLASS:</label>
                  <select name ="class" class ="form_control">';
          // Pull class list.
          $pull_class_result = mysqli_query($db_conn, $pull_class);
          if($pull_class_result){
            $num = mysqli_num_rows($pull_class_result);
           //  Test for valid test result
           if($num>0){
             while($row = mysqli_fetch_array($pull_class_result)){
               // Echo out the classes
               echo '<option value="'.$row["class_id"].'">'.$row["class_name"].'</option>';
             }
           }else{
             // Echo out if there are no classes listed.
             echo '<option>No classes available</option>';
           }
          }
          echo '</select>
                <label for="Title">TITLE:</label><input class = "form_control" type="text" minlength="5" maxlength="80" name="title" pattern="^([a-zA-Z0-9_- .,!?]){5,80}$" title="Min of 5 characters, Max of 80 characters" Required>
                <label>STARS:</label><input class = "form_control" name="stars" type="number" step="1" min="0" max="5" pattern="(0-5){1}" required>
                <label>COMMENT:</label><textarea class = "form_control" name="content" minlength="20" maxlength="250" title="Alphanumerics only, max of 250 characters" required></textarea>
              <input type="submit" name="add_test" value="SUBMIT" class ="formBtn">
            </form>
          </section>';

        }else{
          echo '<section class ="testimonial_container">
                  <h2> You must <a href="login.php">log in</a> to write a testimonial. </h2>
                </section>';
        }
      ?>
    </section>
<?php
    require_once("footer.php");
?>
