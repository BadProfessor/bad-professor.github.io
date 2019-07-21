<?php
include_once("header.php");
include_once("session_validate.php");
    // Error Messages of Forms
    $tier_nameErr = "";
    $tier_detailsErr = "";
    $tier_priceErr = "";
    // Input of information of Forms
    $tier_name = "";
    $tier_details = "";
    $tier_price = "";
    // Number of errors from form
    $errors = 0;
    // Form vailidation.
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
      // Membership validation.
      if (empty($_POST["tier_name"])) {
        $tier_nameErr = "<p class ='error'>*Please select a membership type</p>";
        $errors += 1;
      } else {
        $tier_name = test_input($_POST["tier_name"]);
      }
      if (empty($_POST["tier_details"])) {
        $tier_detailsErr = "<p class ='error'>*Please enter membership description</p>";
        $errors += 1;
      } else {
        $tier_details = test_input($_POST["tier_details"]);
      }
      if (empty($_POST["tier_price"])) {
        $tier_priceErr = "<p class ='error'>*Please enter membership price</p>";
        $errors += 1;
      } else {
        $tier_price = test_input($_POST["tier_price"]);
      }
    }
    //Manipulate the data input from the user.
    function test_input($data)
    {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      $data = mysqli_real_escape_string($GLOBALS["db_conn"], $data);
      return $data;
    }
    if ($errors == 0) {?>
    <section class="form_container" id = "membership_section">
      <form action="membership_edit.php" method="post" class="form">
        <h1>MEMBERSHIP UPDATE</h1>
        <label>MEMBERSHIP TYPE</label>
        <select name="tier_name" class="form_control">
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
        <label>MEMBERSHIP DESCRIPTION</label><textarea type="text" name="tier_details" class = "form_control"></textarea>
        <label>MEMBERSHIP PRICE</label><input name = "tier_price" class = "form_control" type="number" max="1000">
        <input type="submit" name="submit" value="SUBMIT" class="formBtn" required>
      </form>
      </br></br></br></br>
    </section>
    <?php
        $update_tier = "UPDATE tbl_tier SET tier_details = '$tier_details', tier_price = '$tier_price' WHERE tier_id ='$tier_name'";
        mysqli_query($db_conn, $update_tier)
        /*if (mysqli_query($db_conn, $update_tier)){
					echo "<p class = 'userdata'>Has Successfully Been Added to the Database!!</p>";
				}else {
					echo "<p class = 'userdata'> You are not connected to the database.</p>";
				}*/
			?>
    <?php
		  }else { ?>
        <section class="form_container" id = "membership_section">
          <form action="membership_edit.php" method="post" class="form">
            <h1>GLOBO CLASS UPDATE</h1>
            <label>CLASS NAME</label>
            <select name="tier_name" class="form_control">
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
            <?php echo $tier_nameErr; ?>
            <label>CLASS DESCRIPTION</label><textarea name = "tier_details" class = "form_control"></textarea>
            <?php echo $tier_detailsErr; ?>
            <label>MEMBERSHIP PRICE</label><input name ="tier_price" class = "form_control" type="number" max="1000">
            <?php echo $tier_priceErr; ?>
            <input type="submit" name="submit" value="SUBMIT" class="formBtn" required>
          </form>
          </br></br></br></br>
        </section>

    <?php }
    /*
      echo "<h2>Your Input:</h2>";
      echo $tier_name;
      echo "<br>";
      echo $tier_details;
      echo "<br>";
    */
require_once("admin_footer.php");?>
