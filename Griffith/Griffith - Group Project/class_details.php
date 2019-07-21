<!--header that involves the navigation bar and connection to database-->
<?php require_once("header.php");
      require_once("session_validate_members.php");
      ?>
  <!--Class search based on class_id-->
  <section class ="class_expand_container">
    <section class = "class_expand">
      <?php
        //if you have searched a class from form above execute
        if(isset($_GET['id'])) {
          // sorting search information from form above
          $search = $_GET['id'];
          // SQL Query based on class table and search information
          $sql = "SELECT * FROM tbl_class WHERE class_id = $search;";
          // SQL Query connection to database
      		$result = mysqli_query($db_conn, $sql);
          // If there is a correct sql query execute
          if($result){
            //Get information from sql query
            $row = mysqli_fetch_assoc($result);
            // information based on row name.
            echo "<h1>".$row['class_name']."</h1>";
            echo "<p>".$row['class_desc']."</p>";
            echo "<h1>Class Details</h1>";
            echo "<p><b>Class Capacity: </b>".$row['class_capacity']."<br><b>Time: </b>".$row['class_stime']."-".$row['class_etime']."<br><b>Date: </b>". $row['class_day']."</p>";
            echo "<div><img src='img/classimg/".$row["class_image"]."' alt='".$row["class_name"]."' class = 'class_expand_img'></div>";
          }
        }
      ?>
      <h1>Class Search</h1>
      <form action="class_details.php" method="GET" class ="class_form">
        <select name="id" class="form">
        <?php
          $pull_class = "SELECT class_id, class_name FROM tbl_class";
          $pull_class_result = mysqli_query($db_conn, $pull_class);
          if($pull_class_result){
            $num = mysqli_num_rows($pull_class_result);
           //  Test for valid test result
           if($num>0){
             echo '<option value="1">SELECT CLASS</option>';
             while($row =mysqli_fetch_array($pull_class_result)){
               // Echo out the tiers
               echo '<option value="'.$row["class_id"].'">'.$row["class_name"].'</option>';
             }
           }else{
             // Echo out if there are no tiers listed.
             echo '<p>No Class available</p>';
           }
          }
        ?>
        </select>
        <p><input type="submit" name="class_searched" class="class_expand_btn"></p>
      </form>
    </section>
  </section>
<?php require_once("footer.php");?>
