<!--header that involves the navigation bar and connection to database-->
<?php require_once("header.php");?>
<section class = "membership">
  <section class="membership_container">
    <div class="membership_info">
      <?php
        $tier_sql1 = "SELECT * FROM tbl_tier WHERE tier_id = 1;";
        $tier_sql2 = "SELECT * FROM tbl_tier WHERE tier_id = 2;";
        $tier_result1 = mysqli_query($db_conn, $tier_sql1);
        $tier_result2 = mysqli_query($db_conn, $tier_sql2);
        if($tier_result1){
          $row = mysqli_fetch_assoc($tier_result1);
          echo "<h3><b>STUDENT MEMBERSHIP</b></h3>";
          echo "<p>".$row['tier_details']."</p>";
          echo "<p>MONTHLY<p>";
          echo "<p class = 'join_now'><a href='join_now.php'><b>€".$row['tier_price']." JOIN NOW</b></a></p>";
        }
        if($tier_result2){
          $row = mysqli_fetch_assoc($tier_result2);
          echo "<p>YEARLY<p>";
          echo "<p class = 'join_now'><a href='join_now.php'><b>€".$row['tier_price']." JOIN NOW</b></a></p>";
        }
      ?>
    </div>
    <div class="membership_info">
      <?php
        $tier_sql3 = "SELECT * FROM tbl_tier WHERE tier_id = 3;";
        $tier_sql4 = "SELECT * FROM tbl_tier WHERE tier_id = 4;";
        $tier_result3 = mysqli_query($db_conn, $tier_sql3);
        $tier_result4 = mysqli_query($db_conn, $tier_sql4);
        if($tier_result3){
          $row = mysqli_fetch_assoc($tier_result3);
          echo "<h3><b>ADULTS MEMBERSHIP</b></h3>";
          echo "<p>".$row['tier_details']."</p>";
          echo "<p>MONTHLY<p>";
          echo "<p class = 'join_now'><a href='join_now.php'><b>€".$row['tier_price']." JOIN NOW</b></a></p>";
        }
        if($tier_result4){
          $row = mysqli_fetch_assoc($tier_result4);
          echo "<p>YEARLY<p>";
          echo "<p class = 'join_now'><a href='join_now.php'><b>€".$row['tier_price']." JOIN NOW</b></a></p>";
        }
      ?>
    </div>
    <div class="membership_info">
      <?php
        $tier_sql5 = "SELECT * FROM tbl_tier WHERE tier_id = 5;";
        $tier_sql6 = "SELECT * FROM tbl_tier WHERE tier_id = 6;";
        $tier_result5 = mysqli_query($db_conn, $tier_sql5);
        $tier_result6 = mysqli_query($db_conn, $tier_sql6);
        if($tier_result5){
          $row = mysqli_fetch_assoc($tier_result5);
          echo "<h3><b>PREMIUM MEMBERSHIP</b></h3>";
          echo "<p>".$row['tier_details']."</p>";
          echo "<p>MONTHLY<p>";
          echo "<p class = 'join_now'><a href='join_now.php'><b>€".$row['tier_price']." JOIN NOW</b></a></p>";
        }
        if($tier_result6){
          $row = mysqli_fetch_assoc($tier_result6);
          echo "<p>YEARLY<p>";
          echo "<p class = 'join_now'><a href='join_now.php'><b>€".$row['tier_price']." JOIN NOW</b></a></p>";
        }
      ?>
    </div>
  </section>
  <section class="faq_container">
    <div class="faq_question">
      <h3>What you need to know about the membership.</h3>
      <div class="faq_content">
        <div class="faq_answer">
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur eu venenatis purus.
             Nunc tristique ut erat sit amet luctus. Mauris sed odio congue, molestie eros vel,
             congue mi. Sed id quam id dolor facilisis laoreet at sed ligula. Etiam malesuada justo
             risus, at rutrum risus ullamcorper quis. Nam sed tempus elit, quis dapibus nulla. Aenean
             a nunc at risus consequat suscipit. </p>
        </div>
      </div>
    </div>
    <div class="faq_question">
      <h3>Why you should subscribe to the premium membership.</h3>
      <div class="faq_content">
        <div class="faq_answer">
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur eu venenatis purus.
             Nunc tristique ut erat sit amet luctus. Mauris sed odio congue, molestie eros vel,
             congue mi. Sed id quam id dolor facilisis laoreet at sed ligula. Etiam malesuada justo
             risus, at rutrum risus ullamcorper quis. Nam sed tempus elit, quis dapibus nulla. Aenean
             a nunc at risus consequat suscipit. </p>
        </div>
      </div>
    </div>
    <div class="faq_question">
      <h3>Using direct debit or PayPal with your membership.</h3>
      <div class="faq_content">
        <div class="faq_answer">
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur eu venenatis purus.
             Nunc tristique ut erat sit amet luctus. Mauris sed odio congue, molestie eros vel,
             congue mi. Sed id quam id dolor facilisis laoreet at sed ligula. Etiam malesuada justo
             risus, at rutrum risus ullamcorper quis. Nam sed tempus elit, quis dapibus nulla. Aenean
             a nunc at risus consequat suscipit. </p>
        </div>
      </div>
    </div>
    <div class="faq_question">
      <h3>Canceling your membership.</h3>
      <div class="faq_content">
        <div class="faq_answer">
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur eu venenatis purus.
             Nunc tristique ut erat sit amet luctus. Mauris sed odio congue, molestie eros vel,
             congue mi. Sed id quam id dolor facilisis laoreet at sed ligula. Etiam malesuada justo
             risus, at rutrum risus ullamcorper quis. Nam sed tempus elit, quis dapibus nulla. Aenean
             a nunc at risus consequat suscipit. </p>
        </div>
      </div>
    </div>
    <div class="faq_question">
      <h3>Pausing your membership subscription.</h3>
      <div class="faq_content">
        <div class="faq_answer">
          <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur eu venenatis purus.
             Nunc tristique ut erat sit amet luctus. Mauris sed odio congue, molestie eros vel,
             congue mi. Sed id quam id dolor facilisis laoreet at sed ligula. Etiam malesuada justo
             risus, at rutrum risus ullamcorper quis. Nam sed tempus elit, quis dapibus nulla. Aenean
             a nunc at risus consequat suscipit. </p>
        </div>
      </div>
    </div>
  </section>
</section>
<?php require_once("footer.php");?>
