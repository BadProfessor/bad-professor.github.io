</br></br></br>
    <footer id = "admin_footer">
      <div><a href="index.php"><img src="img/admin_logo.png" alt= "home logo" id ="admin_logo"></a></div>
      <label id= "admin_burger" for="admin_toggle">&#9776;</label>
      <input type="checkbox" id="admin_toggle"/>
      <nav class="nav_main" id ="nav_admin">
        <ul class="nav_list" id ="admin_list">
          <li><a href="admin_index.php">INDEX</a></li>
          <li><a href="admin_membership.php">MEMBERSHIP TIERS</a></li>
          <li><a href="admin_testimonial.php">TESTIMONIALS</a></li>
          <li><a href="admin_class.php">CLASS</a></li>
          <li><a href="admin_account.php">MANAGE USERS</a></li>
          <li><a href="admin_mail.php">MAILBOX</a></li>
        </ul>
      </nav>
    </footer>
  </body>
</html>
<?php
  mysqli_close($db_conn);
?>
