<?php 
// Include the connection that starts the session
include_once("header.php");
include_once("session_validate.php");

// Test the URL for incoming http requests.
if (isset($_POST["submit"])){
  // Submit means a new class is being created.
  $name = test_input($_POST["name"]);
  $desc = test_input($_POST["desc"]);
  $capacity = test_input($_POST["capacity"]);
  $day = test_input($_POST["day"]);
  $stime = test_input($_POST["stime"]);
  $etime = test_input($_POST["etime"]);
  $tier = test_input($_POST["tier"]);

  // Image Manipulation and Insertion.
  if (!isset($_FILES['image']['tmp_name'])) {
    header("Location: admin_class.php?failed=noimg");
    }else if(isset($_FILES['image']['tmp_name'])){
    // Image sanitation
    $file=$_FILES['image']['tmp_name'];
    $image= addslashes(file_get_contents($_FILES['image']['tmp_name']));
    $image_name= addslashes($_FILES['image']['name']);
    $image_size= getimagesize($_FILES['image']['tmp_name']);

    
      if ($image_size==FALSE) {
      
        header("Location: admin_class.php?failed=imgfrmt");
        
      }else{
        // Move the image to the folder img/classimg.
        move_uploaded_file($_FILES["image"]["tmp_name"],"img/classimg/" .$_FILES["image"]["name"]);
        
        $location=$_FILES["image"]["name"];
        // Query to add the new class.
        $new_class = "INSERT INTO tbl_class(class_name, class_desc, class_capacity, class_image, class_day, class_stime, class_etime, class_tier, class_stat) VALUES ('$name', '$desc', '$capacity', '$location', '$day', '$stime', '$etime', '$tier', '1')";
        if(mysqli_query($db_conn, $new_class)){
          header("Location: admin_class.php?success=add");
        }else{
          header("Location: admin_class.php?dberror=add");
        }
      }
  }else{
    header("Location: admin_class.php?failed=addimg");
  }

// Edit class URL interceptor.
}else if (isset($_POST["edit"])){
  // Sanitize the input
  $id = test_input($_POST["class"]);
  $name = test_input($_POST["name"]);
  $desc = test_input($_POST["desc"]);
  $capacity = test_input($_POST["capacity"]);
  $day = test_input($_POST["day"]);
  $stime = test_input($_POST["stime"]);
  $etime = test_input($_POST["etime"]);
  $tier = test_input($_POST["tier"]);
  $stat = test_input($_POST["status"]);

  // SQL Query to update
  $update_class = "UPDATE tbl_class SET class_name = '$name', class_desc = '$desc', class_capacity = '$capacity', class_day = '$day', class_stime = '$stime', class_etime = '$etime', class_tier = '$tier', class_stat = '$status' WHERE class_id = '$id'";
      if(mysqli_query($db_conn, $update_class)){
        header("Location: admin_class.php?success=edit");
      }else{
        header("Location: admin_class.php?dberror=edit");
      }
}

// Sanitation Function
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

<!--       =====================================================================================
        *  ======================================= Front End Add ===============================
        *  ===================================================================================== -->
<section class="form_container">
      <form id="class_add" action="admin_class.php" method="POST" enctype="multipart/form-data" class="form">
      <center><a class="global_button special" href="#class_edit">Go to Edit Class</a></center>
        <h1>ADMIN MENU - ADD CLASS</h1>
        <label>Class Name</label><input type="text" name="name" class="form_control" size="20" maxlength="50" required>
        <label>Description</label><textarea class = "form_control" name="desc" minlength="20" maxlength="255" title="Alphanumerics only, max of 255 characters" required></textarea>
        <label>Class Capacity</label><input type="number" name="capacity" class="form_control" min="20" max="200" required>
        </br>
        <label>Class Image</label><input type="file" id="image" class="itemFileInput" accept="image/png, image/jpeg" name="image" required>
        </br></br><label>Class Day</label>
        <select name="day" class="form_control">
          <option value="Mon">Monday</option>
          <option value="Tue">Tuesday</option>
          <option value="Wed">Wednesday</option>
          <option value="Thu">Thursday</option>
          <option value="Fri">Friday</option>
          <option value="Sat">Saturday</option>
          <option value="Sun">Sunday</option>
        </select>
        <label>Start Time</label><input type="time" name="stime" class="form_control" required>
        <label>End Time</label><input type="time" name="etime" class="form_control" required>
        <label>Class Tier Level</label>
        <select name="tier" class="form_control">
          <?php
            $pull_tier = "SELECT tier_id, tier_name FROM tbl_tier WHERE tier_stat = '1'";
            $pull_tier_result = mysqli_query($db_conn, $pull_tier);
            if($pull_tier_result){
              $num = mysqli_num_rows($pull_tier_result);
             //  Test for valid test result
             if($num>0){
               while($row =mysqli_fetch_array($pull_tier_result)){
                 // Echo out the tiers
                 echo '<option value="'.$row["tier_id"].'">'.$row["tier_name"].'</option>';
               }
             }else{
               // Echo out if there are no tiers listed.
               echo '<option>No tiers available</option>';
             }
            }
          ?>
        </select>
        <input type="submit" name="submit" value="Add Class" class="formBtn" required>
      </form>
    </section>
   
    <!--   =====================================================================================
        *  ======================================= Front End Edit ==============================
        *  ===================================================================================== -->
    <section class="form_container">
    <form id="class_edit" action="admin_class.php" method="POST" class="form">
    <center><a class="global_button special" href="#class_add">Back to Add Class</a></center>
      <h2>Edit Class</h2>
      <label>Select Class</label>
      <select name="class" class="form_control">
      <?php 
        // Pull all classes from database
        $pull_class = "SELECT class_id, class_name FROM tbl_class WHERE class_stat = '1'";
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
            echo '<option value="#">No Classes Available</option>';
          }
        }
      ?>
      <select>
      <label>New Class Name</label><input type="text" name="name" class="form_control" size="20" maxlength="50" required>
        <label>New Description</label><textarea class = "form_control" name="desc" minlength="20" maxlength="255" title="Alphanumerics only, max of 255 characters" required></textarea>
        <label>New Class Capacity</label><input type="number" name="capacity" class="form_control" min="20" max="200" required>
        <label>New Class Day</label>
        <select name="day" class="form_control">
          <option value="Mon">Monday</option>
          <option value="Tue">Tuesday</option>
          <option value="Wed">Wednesday</option>
          <option value="Thu">Thursday</option>
          <option value="Fri">Friday</option>
          <option value="Sat">Saturday</option>
          <option value="Sun">Sunday</option>
        </select>
        <label>New Start Time</label><input type="time" name="stime" class="form_control" required>
        <label>New End Time</label><input type="time" name="etime" class="form_control" required>
        <label>New Class Tier Level</label>
        <select name="tier" class="form_control">
          <?php
            $pull_tier = "SELECT tier_id, tier_name FROM tbl_tier WHERE tier_stat = '1'";
            $pull_tier_result = mysqli_query($db_conn, $pull_tier);
            if($pull_tier_result){
              $num = mysqli_num_rows($pull_tier_result);
             //  Test for valid test result
             if($num>0){
               while($row =mysqli_fetch_array($pull_tier_result)){
                 // Echo out the tiers
                 echo '<option value="'.$row["tier_id"].'">'.$row["tier_name"].'</option>';
               }
             }else{
               // Echo out if there are no tiers listed.
               echo '<option>No tiers available</option>';
             }
            }
          ?>
        </select>
        <label>New Class Status</label>
        <select name="status" class = "form_control">
          <option value="1">Active</option>
          <option value="0">Inactive</option>
        </select>
        <input type="submit" name="edit" value="Edit Class" class="formBtn" required>
      </form>
    </section>
<?php
  include_once("admin_footer.php");
?>