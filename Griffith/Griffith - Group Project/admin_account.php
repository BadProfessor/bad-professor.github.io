<?php
    include_once("header.php");
    include_once("session_validate.php");
    // Start off the page with some URL validation

    // Declare some global variables
    // Error Messages of Forms
    $user_idErr = "";
    $user_typeErr = "";
    $user_tier = "";
    $user_fnameErr = "";
    $user_lnameErr = "";
    $user_genderErr = "";
    $user_dobErr = "";
    $user_emailErr = "";
    $user_pass1Err = "";
    $user_phoneErr = "";
    $user_addressErr = "";
    $user_pcodeErr = "";
    // Input of information of Forms
    $user_id = "";
    $user_type = "Member";
    $user_classes[] = "";
    $user_tier = "";
    $user_fname = "";
    $user_lname = "";
    $user_gender = "";
    $user_dob = "";
    $user_email = "";
    $confirm_user_email = "";
    $user_pass1 = "";
    $user_pass = "";
    $user_phone = "";
    $user_address = "";
    $user_pcode = "";
    // Number of errors from form
    $errors = 0;

    // Catch URL requests
    // Form validation.
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
      // Membership validation.
      if (empty($_POST["user_type"])) {
        $user_typeErr = "<p class ='error'>*Please select a Membership Type</p>";
        $errors += 1;
      } else {
        $user_tier = test_input($_POST["user_type"]);
      }
      // Classes validation.
      /*if (empty($_POST["class"])) {
        $user_typeErr = "<p class ='error'>*Please select at least one class/p>";
        $errors += 1;
      } else {
        $user_classes = $_POST["class"];
      }*/
      if (empty($_POST["user_id"])) {
        $user_idErr = "<p class ='error'>*user id is required.</p>";
        $errors += 1;
      } else {
        $user_id = test_input($_POST["user_id"]);
        if (!preg_match("/^[0-9]{1,8}/", $user_id)) {
          $user_idErr = "<p class ='error'>*Invalid user id</p>";
          $errors += 1;
        }
      }
      // First Name validation.
      if (empty($_POST["user_fname"])) {
        $user_fnameErr = "<p class ='error'>*First name is required.</p>";
        $errors += 1;
      } else {
        $user_fname = test_input($_POST["user_fname"]);
        if (!preg_match("/^[a-zA-Z]/", $user_fname)) {
          $user_fnameErr = "<p class ='error'>*Invalid Firstname(use only letters and white space)</p>";
          $errors += 1;
        }
      }
      // Last Name validation.
      if (empty($_POST["user_lname"])) {
        $user_lnameErr = "<p class ='error'>*Last name is required.</p>";
        $errors += 1;
      } else {
        $user_lname = test_input($_POST["user_lname"]);
        if (!preg_match("/^[a-zA-Z]/", $user_lname)) {
          $user_lnameErr = "<p class ='error'>*Invalid Lastname(use only letters and white space)</p>";
          $errors += 1;
        }
      }
      // Gender validation.
      if (empty($_POST["user_gender"])) {
        $user_genderErr = "<p class ='error'>*Please select a gender type</p>";
        $errors += 1;
      } else {
        $user_gender = test_input($_POST["user_gender"]);
      }
      // Date of Birth validation.
      if (empty($_POST["user_dob"])) {
        $user_dobErr = "<p class ='error'>*Date of birth is required.</p>";
        $errors += 1;
      } else {
        $user_dob = test_input($_POST["user_dob"]);
      }
      // Email validation.
      if (empty($_POST['user_email'])) {
        $user_emailErr = "<p class ='error'>*Email is required.</p>";
        $errors += 1;
      } elseif (($_POST['user_email']) != ($_POST['confirm_user_email'])) {
        $user_emailErr = "<p class ='error'>*Emails are not matching.</p>";
        $errors += 1;
      } else {
        $user_email = test_input($_POST['user_email']);
        $user_email = filter_var($user_email, FILTER_SANITIZE_EMAIL);
        if (!filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
          $user_emailErr = "<p class ='error'>*Invalid email address.</p>";
          $errors += 1;
        }
      }
      //Password validation
      if (empty($_POST['user_pass1']) && empty($_POST['user_pass2'])) {
        $user_pass1Err = "<p class ='error'>*The passwords are required</p>";
        $errors += 1;
      } elseif (($_POST['user_pass1']) != ($_POST['user_pass2'])) {
        $user_pass1Err = "<p class ='error'>*The passwords do not match.</p>";
      } else {
        $user_pass1 = test_input($_POST['user_pass1']);
        $user_pass1 = hash('sha256', $user_pass1);
      }
      // Phone validation.
      if (empty($_POST["user_phone"])) {
        $user_phoneErr = "<p class ='error'>*Phone number is required.</p>";
        $errors += 1;
      } else {
        $user_phone = test_input($_POST["user_phone"]);
        if (!preg_match("/^08[3-9]{1}[0-9]{7}$/", $user_phone)){
          $user_phoneErr = "<p class ='error'>*Invalid phone number</p>";
          $errors += 1;
        }
      }
      // Address validation.
      if (empty($_POST["user_address"])) {
        $user_addressErr = "<p class ='error'>*Address is required.</p>";
        $errors += 1;
      } else {
        $user_address = test_input($_POST["user_address"]);
        if (!preg_match("/[1-9]+[ a-zA-Z]+/", $user_address)) {
          $user_addressErr = "<p class ='error'>*Invalid address</p>";
          $errors += 1;
        }
      }
      // Post code validation.
      if (empty($_POST["user_pcode"])) {
        $user_pcodeErr = "<p class ='error'>*Please select post code</p>";
        $errors += 1;
      } else {
        $user_pcode = test_input($_POST["user_pcode"]);
      }

      if($errors == 0){
        /* =====================================================================================
        *  ======================================= SQL Insertion ===============================
        *  ===================================================================================== */

        // Prepare SQL Insertion
        $update_user = "UPDATE tbl_user SET user_type='$user_type',user_fname ='$user_fname',user_lname='$user_lname',user_gender='$user_gender',user_dob='$user_dob',user_email='$user_email',user_address='$user_address',user_address='$user_address',user_pcode='$user_pcode',user_phone='$user_phone' WHERE user_id= $user_id;";

        // Query to get ID
        $query_id = "SELECT user_id FROM tbl_user WHERE user_email = '$user_email' GROUP BY user_id DESC LIMIT 1";
        // Assign global Variables
        $class_list = "";
        $now = date("Y-m-d");
        $user_id = "";


        //(mysqli_query($db_connection, $query);
        if (mysqli_query($db_conn, $update_user)){
                //  Test for valid User ID.
                $pull_id = mysqli_query($db_conn, $query_id);
                $num = mysqli_num_rows($pull_id);
                // Test if the id query passed.
                if($num>0){
                  while($row = mysqli_fetch_array($pull_id)){
                    // Assign value to id
                    $user_id = $row["user_id"];
                  }
                }else{
                  // Error
                }
                // Iterate through the class array.
                foreach($user_classes as $selected){
                  if ($class_list != ""){
                    $class_list = $class_list.",";
                  }
                  $class_list = $class_list. "('$user_id', '$selected')";
                }
                $query_classes = "INSERT INTO tbl_userclass VALUES $class_list";
                $query_pass = "INSERT INTO tbl_creds VALUES ('$user_id','$user_pass1')";
                $query_tier = "INSERT INTO tbl_usertier VALUES ('$user_id','$user_tier','$now','1')";
          if(mysqli_query($db_conn, $query_classes)){
            if(mysqli_query($db_conn, $query_tier)){
              if(mysqli_query($db_conn, $query_pass)){
                echo "<p class = 'userdata'>Has Successfully Been Added to the Database!!</p>";
              header("Location: index.php?registration=success");
              }else{
                echo "<p>Error Inserting Password</p>";
              }
            }else{
              echo "<p>Error Inserting Tier</p>";
            }
          }else{
            echo "<p>Error Inserting Classes</p>";
          }
        }else {
          echo "<p class = 'userdata'> You are not connected to the database.</p>";
        }
      }
    }

    // ===================================================================================

    // Functions
    //Sanitize the data input from the user.
    function test_input($data)
    {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      $data = mysqli_real_escape_string($GLOBALS["db_conn"], $data);
      return $data;
    }


    // Front End code below ====================================================================================================================================================
    if ($errors == 0) {?>
    <section class="form_container">
      <form action="registration_edit.php" method="post" class="form">
        <h1>USER REGISTRATION UPDATE</h1>
        <label>ID*</label><input type="number" name="user_id" class="form_control" max = "99999999">
        <label>FIRSTNAME*</label><input type="text" name="user_fname" class="form_control" size="20" maxlength="30">
        <label>LASTNAME*</label><input type="text" name="user_lname" class="form_control" size="20" maxlength="30">
        <label>MEMBERSHIP TYPE*</label>
        <select name="user_type" class="form_control">
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
         <!-- <label>CLASS*</label><br>
           <div class = "form_class_container" > -->
             <?php
                // Pull all classes from database
              /*$pull_class = "SELECT class_id, class_name FROM tbl_class WHERE class_stat = '1'";
                $pull_class_result = mysqli_query($db_conn, $pull_class);
                if($pull_class_result){
                  $num = mysqli_num_rows($pull_class_result);
                 //  Test for valid test result
                 if($num>0){
                   while($row =mysqli_fetch_array($pull_class_result)){
                     // Echo out the classes
                     echo '<input type="checkbox" name="class[]" value="'.$row["class_id"].'" class="form_class"><label>'.$row["class_name"].'</label>';
                   }
                 }else{
                   // Echo out if there are no classes listed.
                   echo '<input type="checkbox" name="class[]" value="" class="form_class"><label>No classes are currently available</label>';
                 }
                }*/
             ?>
          <!-- </div> -->
        <label>GENDER*</label>
        <select name="user_gender" class="form_control">
          <option value="0">Male</option>
          <option value="1">Female</option>
          <option value="2">Unknown</option>
        </select>
        <label>DATE OF BIRTH*</label><input type="date" name="user_dob" class="form_control" min="1920-01-01" max="2001-01-01">
        <label>EMAIL ADDRESS*</label>
        <input type="email" name="user_email" class="form_control"/>
        <label>CONFIRM EMAIL*</label>
        <input type="email" name="confirm_user_email" class="form_control"/>
        <label>PASSWORD*</label><input type="password" class="form_control" name="user_pass1" required>
        <label>CONFIRM PASSWORD*</label><input type="password" class="form_control" name="user_pass2" required>
        <label>ADDRESS</label> <input type="text" name="user_address" size="20" maxlength="200" class ="form_control">
        <label>POST CODE</label>
          <select name ="user_pcode" class ="form_control">
            <option value="D1">Dublin 1</option>
            <option value="D2">Dublin 2</option>
            <option value="D3">Dublin 3</option>
            <option value="D4">Dublin 4</option>
            <option value="D5">Dublin 5</option>
            <option value="D6">Dublin 6</option>
            <option value="D7">Dublin 7</option>
            <option value="D8">Dublin 8</option>
            <option value="D9">Dublin 9</option>
            <option value="D10">Dublin 10</option>
            <option value="D11">Dublin 11</option>
            <option value="D12">Dublin 12</option>
            <option value="D13">Dublin 13</option>
            <option value="D14">Dublin 14</option>
            <option value="D15">Dublin 15</option>
            <option value="D16">Dublin 16</option>
            <option value="D17">Dublin 17</option>
            <option value="D18">Dublin 18</option>
            <option value="D19">Dublin 19</option>
            <option value="D20">Dublin 20</option>
            <option value="D21">Dublin 21</option>
            <option value="D22">Dublin 22</option>
            <option value="D23">Dublin 23</option>
            <option value="D24">Dublin 24</option>
          </select>
          <label>PHONE NUMBER</label>
          <input type="tel" name="user_phone" placeholder="eg.0861238200" class="form_control"/>
        <input type="submit" name="submit" value="SUBMIT" class="formBtn" required>
      </form>
    </section>
    <?php }else { ?>
        <section class="form_container">
          <form action="registration_edit.php" method="post" class="form">
          <label>ID*</label><input type="number" name="user_id" class="form_control" max = "99999999">
            <?php echo $user_idErr;?>
            <label>FIRSTNAME*</label><input type="text" name="user_fname" class="form_control" size="20" maxlength="30">
            <?php echo $user_fnameErr; ?>
            <label>LASTNAME*</label><input type="text" name="user_lname" class="form_control" size="20" maxlength="30">
            <?php echo $user_lnameErr; ?>
            <label>MEMBERSHIP TYPE*</label>
            <select name="user_type" class="form_control">
              <?php
                $pull_tier = "SELECT tier_id, tier_name FROM tbl_tier WHERE tier_stat = '1'";
                $pull_tier_result = mysqli_query($db_conn, $pull_tier);
                if($pull_tier_result){
                  $num = mysqli_num_rows($pull_tier_result);
                //  Test for valid test result
                if($num>0){
                  while($row =mysqli_fetch_array($pull_tier_result)){
                    // Echo out the classes
                    echo '<option value="'.$row["tier_id"].'">'.$row["tier_name"].'</option>';
                  }
                }else{
                  // Echo out if there are no classes listed.
                  echo '<option>No tiers available</option>';
                }
                }
              ?>
            </select>
            <?php echo $user_typeErr; ?>
            <!-- <label>CLASS*</label><br>
           <div class = "form_class_container" > -->
            <?php
                // Pull all classes from database
              /*$pull_class = "SELECT class_id, class_name FROM tbl_class WHERE class_stat = '1'";
                $pull_class_result = mysqli_query($db_conn, $pull_class);
                if($pull_class_result){
                  $num = mysqli_num_rows($pull_class_result);
                 //  Test for valid test result
                 if($num>0){
                   while($row =mysqli_fetch_array($pull_class_result)){
                     // Echo out the classes
                     echo '<input type="checkbox" name="class[]" value="'.$row["class_id"].'" class="form_class"><label>'.$row["class_name"].'</label>';
                   }
                 }else{
                   // Echo out if there are no classes listed.
                   echo '<input type="checkbox" name="class[]" value="" class="form_class"><label>No classes are currently available</label>';
                 }
               } */
             ?>
          <!-- </div> -->
            <label>GENDER*</label>
            <select name="user_gender" class="form_control">
              <option value="male">Male</option>
              <option value="female">Female</option>
              <option value="unknown">Unknown</option>
            </select>
            <?php echo $user_genderErr; ?>
            <label>DATE OF BIRTH*</label><input type="date" name="user_dob" class="form_control" min="1920-01-01" max="2001-01-01">
            <?php echo $user_dobErr; ?>
            <label>EMAIL ADDRESS*</label>
            <input type="email" name="user_email" class="form_control"/>
            <label>CONFIRM EMAIL*</label>
            <input type="email" name="confirm_user_email" class="form_control"/>
            <?php echo $user_emailErr; ?>
            <label>PASSWORD*</label><input type="password" class="form_control" name="user_pass1" required>
            <label>COMFIRM PASSWORD*</label><input type="password" class="form_control" name="user_pass2" required>
            <label>ADDRESS</label> <input type="text" name="user_address" size="20" maxlength="200" class ="form_control">
            <?php echo $user_addressErr; ?>
            <label>POST CODE</label>
              <select name ="user_pcode" class ="form_control">
                <option value="D1">Dublin 1</option>
                <option value="D2">Dublin 2</option>
                <option value="D3">Dublin 3</option>
                <option value="D4">Dublin 4</option>
                <option value="D5">Dublin 5</option>
                <option value="D6">Dublin 6</option>
                <option value="D7">Dublin 7</option>
                <option value="D8">Dublin 8</option>
                <option value="D9">Dublin 9</option>
                <option value="D10">Dublin 10</option>
                <option value="D11">Dublin 11</option>
                <option value="D12">Dublin 12</option>
                <option value="D13">Dublin 13</option>
                <option value="D14">Dublin 14</option>
                <option value="D15">Dublin 15</option>
                <option value="D16">Dublin 16</option>
                <option value="D17">Dublin 17</option>
                <option value="D18">Dublin 18</option>
                <option value="D19">Dublin 19</option>
                <option value="D20">Dublin 20</option>
                <option value="D21">Dublin 21</option>
                <option value="D22">Dublin 22</option>
                <option value="D23">Dublin 23</option>
                <option value="D24">Dublin 24</option>
              </select>
              <?php echo $user_pcodeErr; ?>
              <label>PHONE NUMBER</label>
              <input type="tel" name="user_phone" placeholder="eg.0861238200" class="form_control"/>
              <?php echo $user_phoneErr; ?>
            <input type="submit" name="submit" value="SUBMIT" class="formBtn" required>
          </form>
        </section>
    <?php }
    include_once("admin_footer.php");
    ?>
