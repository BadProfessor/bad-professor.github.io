<?php
// Include the connection that starts the session
include_once("header.php");
include_once("session_validate.php");
?>
    <section class="contact_contain">
		<div class="contact_form">
			<h1>Admin - Mail</h1>
			<!-- Provide filter functionality if possible -->
			<!-- THIS IS A TEMPLATE -->
			<table style="color: white; width: 100%;">
				<tr>
					<th>Time</th>
					<th>Sender</th>
					<th>Type</th>
                    <th>Subject</th>
                    <th>Attachment</th>
					<th>Action</th>
				</tr>

			<!-- Main PHP Script goes here -->
				<?php
						//Query the db for the mail rows
						$query = "SELECT tbl_mail.mail_id, tbl_mail.mail_type, tbl_mail.mail_subj, tbl_mail.mail_time, tbl_mail.mail_attachment, tbl_mail.mail_stat, tbl_usermail.user_email, tbl_usermail.mail_is_user FROM tbl_usermail INNER JOIN tbl_mail ON tbl_mail.mail_id = tbl_usermail.mail_id LEFT JOIN tbl_user ON tbl_user.user_email = tbl_usermail.user_email GROUP BY mail_time DESC";
                        $result = mysqli_query($db_conn, $query);
                        if($result){
                            $num = mysqli_num_rows($result);
                           //  Test for valid test result
                           if($num>0){
                             while($row = mysqli_fetch_array($result)){
                                if($row['mail_stat'] == 0){
                                    // Shorthand if statement is used here
                                    echo "
                                    <tr style = 'font-weight: bold;'>
                                        <td>".$row["mail_time"]."</td>
                                        <td>".$row["user_email"]."</td>
                                        <td>".$row["mail_type"]."</td>
                                        <td>".$row["mail_subj"]."</td>
                                        <td>".$row["mail_attachment"]."</td>
                                        <td><a href='admin_mail.php?view=true&id=".$row['mail_id']."'>View</a></td>
                                    </tr>";
                                }else{
                                    echo "
                                    <tr>
                                        <td>".$row["mail_time"]."</td>
                                        <td>".$row["user_email"]."</td>
                                        <td>".$row["mail_type"]."</td>
                                        <td>".$row["mail_subj"]."</td>
                                        <td>".$row["mail_attachment"]."</td>
                                        <td><a href='admin_mail.php?view=true&id=".$row['mail_id']."'>View</a></td>
                                    </tr>";
                                }
                             }
                           }else{
                             // Echo out if there are no tiers listed.
                             echo '<tr><td>No Data</td><td>No Data</td><td>No Data</td><td>No Data</td><td>No Data</td></tr>';
                           }
                          }
				?>

			</table>
		</div>
      </section>

	  <!-- This section is to view the mail -->
	  <section class = "contact_contain">
		<div class = "contact-form">
            <!-- Intercept incoming URL Data -->
            <?php
                if((isset($_GET["view"])) && ($_GET["view"] == "true")){
                    $query2 = "SELECT tbl_mail.mail_type, tbl_mail.mail_subj, tbl_mail.mail_content, tbl_mail.mail_time, tbl_mail.mail_attachment, tbl_mail.mail_stat, tbl_usermail.user_email, tbl_usermail.mail_is_user FROM tbl_usermail INNER JOIN tbl_mail ON tbl_mail.mail_id = tbl_usermail.mail_id LEFT JOIN tbl_user ON tbl_user.user_email = tbl_usermail.user_email WHERE tbl_usermail.mail_id = '".$_GET["id"]."'";
                        $result2 = mysqli_query($db_conn, $query2);
                        if($result2){
                            $num = mysqli_num_rows($result2);
                           //  Test for valid test result
                           if($num>0){
                             while($row = mysqli_fetch_array($result2)){
                                    echo '
                                    <h3>Mail Type: '.$row["mail_type"].'</h3>
                                    <h3>Subject: '.$row["mail_subj"].'</h3>
                                    <h3>Sender: '.$row["user_email"].'</h3>
                                    <h3>Time: '.$row["mail_time"].'</h3>
                                    <h4>Content: '.$row["mail_content"].'</h4>
                                    <h3>Attachment: <a href="contactfiles/'.$row["mail_attachment"].'">'.$row["mail_attachment"].'</a></h3>
                                    ';
                             }
                           }else{
                             // Echo out if there are no tiers listed.
                             echo '<tr><td>No Data</td><td>No Data</td><td>No Data</td><td>No Data</td><td>No Data</td></tr>';
                           }
                          }
                }
            ?>
		</div>
      </section>

<?php
    include_once("admin_footer.php");
?>
