<?php
    require_once("header.php");
    require_once("session_validate.php");
    // URL http request interception
    if ((isset($_GET["action"])) && (isset($_GET["id"]))){
        // Sanitize the input
        $id = test_input($_GET["id"]);
        // Validate the request
        if($_GET["action"] == "approve"){
            $query="UPDATE tbl_testimonial SET test_stat = '1' WHERE test_id = '$id'";
        }elseif($_GET["action"] == "delete"){
            $query="DELETE FROM tbl_testimonial WHERE test_id = '$id'";
        }else{
            // Error handling
            header("Location: admin_testimonial.php?prohibited=true");
        }
        // SQL query injection
        if(mysqli_query($db_conn, $query)){
            header("Location: admin_testimonial.php?success=true");
        }
    }else{
        // No URL to intercept
    }

    function test_input($data)
    {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      $data = ucwords(strtolower($data)); // Capitalize
      $data = mysqli_real_escape_string($GLOBALS["db_conn"], $data);
      return $data;
    }
?>

<!-- Static HTML starts here -->
    <section class = "testimonial_container" id ="admin_testimonial_section">
      <form action="admin_testimonial.php" method="POST" class ="form_search_container">
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
      </form>
      <section class = "testimonial">
      <!-- PHP Script to pull testimonial data from the database -->
      <?php
          if(isset($_POST["search"])){
            $pull_test = "SELECT tbl_testimonial.test_id, tbl_testimonial.test_title, tbl_testimonial.test_content, tbl_testimonial.test_stars, tbl_class.class_name, tbl_user.user_fname FROM tbl_testimonial INNER JOIN tbl_usertest ON tbl_testimonial.test_id = tbl_usertest.test_id INNER JOIN tbl_user ON tbl_usertest.user_id = tbl_user.user_id INNER JOIN tbl_classtest ON tbl_classtest.test_id = tbl_testimonial.test_id INNER JOIN tbl_class ON tbl_class.class_id = tbl_classtest.class_id WHERE tbl_testimonial.test_stat = '0' AND tbl_class.class_id = '".$_POST["class_select"]."' GROUP BY tbl_testimonial.test_id DESC";
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
                           <a href="admin_testimonial.php?action=approve&id='.$row["test_id"].'">Approve    </a><a href="admin_testimonial.php?action=delete&id='.$row["test_id"].'">Delete</a>
                         </div>
                       </div>';
               }
             }else{
               echo "<h2>There are no testimonials to display</h2>";
             }
            }
          }else{
            $pull_test = "SELECT tbl_testimonial.test_id, tbl_testimonial.test_title, tbl_testimonial.test_content, tbl_testimonial.test_stars, tbl_class.class_name, tbl_user.user_fname FROM tbl_testimonial INNER JOIN tbl_usertest ON tbl_testimonial.test_id = tbl_usertest.test_id INNER JOIN tbl_user ON tbl_usertest.user_id = tbl_user.user_id INNER JOIN tbl_classtest ON tbl_classtest.test_id = tbl_testimonial.test_id INNER JOIN tbl_class ON tbl_class.class_id = tbl_classtest.class_id WHERE tbl_testimonial.test_stat = '0' GROUP BY tbl_testimonial.test_id DESC";
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
                        <a href="admin_testimonial.php?action=approve&id='.$row["test_id"].'">Approve   </a><a href="admin_testimonial.php?action=delete&id='.$row["test_id"].'">Delete</a>
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
<?php
    require_once("admin_footer.php");
?>
