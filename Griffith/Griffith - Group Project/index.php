<?php
    require_once("header.php");
?>
    <section class = "home_container">
      <div class = "home_info_inner">
        <div class = "home_info">
            <div id="homeborder"></div>
            <h2 id = "welcome">WELCOME TO</h2>
            <h1>GLOBO<span id = "gymtext">GYM</span></h1>
            <h2 id = "owner">BY WHITE GOODMAN</h2>
          <p>Welcome to my pride and joy, GloboGym! We facilitate your fitness need 24 hours a day, seven days a week,
            to be available to all of our members who have different preferences or lifestyles.GloboGym wants to help you
            grow into your fitness journey with full dedication!!</p>
          <p class = "offer"><a href="membership.php">MEMBERSHIP OFFERS</a></p>
        </div>
      </div>
    </section>
    <section class = "update_container">
      <h2>GLOBO GYM UPDATES</h2>
      <div class = "updates">
      <?php 
        // Pull all featured from database
        $pull_featured = "SELECT * FROM tbl_featured WHERE featured_stat = '1'";
        $pull_featured_result = mysqli_query($db_conn, $pull_featured);
        if($pull_featured_result){
          $num = mysqli_num_rows($pull_featured_result);
          //  Test for valid test result
          if($num>0){
            while($row = mysqli_fetch_array($pull_featured_result)){
              // Echo out the classes
              echo '<div class = "update_info">
                      <a href="'.$row["featured_link"].'"><img class ="img_update" src="img/featuredimg/'.$row["featured_image"].'" alt= "'.$row["featured_title"].'"></a>
                      <div class="centered"><span>'.$row["featured_title"].'<span></div>
                    </div>';
            }
          }else{
            
          }
        }
        ?>
      </div>
    </section>
    
<?php
    require_once("footer.php");
?>