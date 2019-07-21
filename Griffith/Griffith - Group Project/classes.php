<?php include_once("header.php"); ?>
    <section class = "class_intro_container">
        <section class = "class_text">
         <h1><u>GLOBO GYM CLASSES</u></h1>
         <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec at enim condimentum, sagittis metus nec,
           cursus dui. Ut ullamcorper, ipsum vitae tincidunt facilisis, metus mi porta risus, non scelerisque nibh
           massa ac mauris. Pellentesque vitae magna eget justo varius auctor vitae vitae tellus. Cras sit.cursus dui.
           Ut ullamcorper, ipsum vitae tincidunt facilisis, metus mi porta risus, non scelerisque nibh massa ac mauris.
           Pellentesque vitae magna eget justo varius auctor vitae vitae tellus.</p>
         <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec at enim condimentum, sagittis metus nec,
           cursus dui. Ut ullamcorper, ipsum vitae tincidunt facilisis, metus mi porta risus, non scelerisque nibh
           massa ac mauris. Pellentesque vitae magna eget justo varius auctor vitae vitae tellus. Cras sit.cursus dui.
           Ut ullamcorper, ipsum vitae tincidunt facilisis, metus mi porta risus, non scelerisque nibh massa ac mauris.
           Pellentesque vitae magna eget justo varius auctor vitae vitae tellus.</p>
       </section>
       <div class ="timetable_info">
         <a href="contactfiles/timetable.pdf"><img class ="img_timetable" src="img/timetable.jpg" alt= "timetable"></a>
         <div class="centered"><h2>TIMETABLE DOWNLOAD<h2></div>
     </div>
    </section>
    <section class = "class_container">
      <h1><u>OUR CLASSES</u></h1>
      <section class = "gym_class_container">
      <?php
        // Pull all classes from database
        $pull_class = "SELECT class_id, class_name, class_image FROM tbl_class WHERE class_stat = '1'";
        $pull_class_result = mysqli_query($db_conn, $pull_class);
        if($pull_class_result){
            $num = mysqli_num_rows($pull_class_result);
            //  Test for valid test result
            if($num>0){
            while($row = mysqli_fetch_array($pull_class_result)){
                // Break PHP and output the classes
                // Check if a user is logged in then redirect them to the class_details
                if(isset($_SESSION["user_email"]) && isset($_SESSION["user_id"]) && isset($_SESSION["user_type"])){
                    ?>
                    <div class = "class_info">
                        <a href="class_details.php?id=<?php echo $row["class_id"]?>"><img class ="img_class" src="img/classimg/<?php echo $row["class_image"] ?>" alt= "<?php echo $row["class_name"]?>"></a>
                        <div class="centered"><span><?php echo $row["class_name"]?></span></div>
                    </div>
                    <?php
                // If no user is logged in, forbid them from viewing class details
                }else{
                    ?>
                    <div class = "class_info">
                        <a href="login.php"><img class ="img_class" src="img/classimg/<?php echo $row["class_image"] ?>" alt= "<?php echo $row["class_name"]?>" title="Log in to view class details"></a>
                        <div class="centered"><span><?php echo $row["class_name"]?></span></div>
                    </div>
                    <?php
                }
            }
            }else{
            // Echo out if there are no classes listed.
            echo '<h3>No classes available</h3>';
            }
        }
        if(isset($_SESSION["user_email"]) && isset($_SESSION["user_id"]) && isset($_SESSION["user_type"])){
            if ($_SESSION["user_type"] == "Admin"){
                echo '<div class = "class_info">
                        <a href="admin_class.php"><img class ="img_class" src="img/classimg/class_add.jpg" alt="Add Class" title="Add Class"></a>
                        <div class="centered"><span style="font-size: 200px;">+</span></div>
                    </div>';
            }else{
                echo '<div class = "class_info">
                        <a href="contact_us.php"><img class ="img_class" src="img/classimg/class_add.jpg" alt="Add Class" title="Have a class idea? Contact us!"></a>
                        <div class="centered"><span>Have a class idea? Contact Us!</span></div>
                    </div>';
            }
        }else{
            echo '<div class = "class_info">
                        <a href="contact_us.php"><img class ="img_class" src="img/classimg/class_add.jpg" alt="Add Class" title="Have a class idea? Contact us!"></a>
                        <div class="centered"><span>Have a class idea? Contact Us!</span></div>
                    </div>';
        }
      ?>
      </br>
    </section>
<?php include_once("footer.php"); ?>
