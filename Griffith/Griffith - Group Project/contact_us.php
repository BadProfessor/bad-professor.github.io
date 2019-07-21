<?php 
    require_once("header.php");
    require_once("connection.php");

    // Intercept HTTP Request
    if ((isset($_POST['name'])) && !empty($_POST['name'])
    && (isset($_POST['type'])) && !empty($_POST['type'])
    && (isset($_POST['email'])) && !empty($_POST['email'])
    && (isset($_POST['phone'])) && !empty($_POST['phone'])
    && (isset($_POST['subject'])) && !empty($_POST['subject'])
    && (isset($_POST['content'])) && !empty($_POST['content'])) {

    
        // Sanitation function
        function test_input($data)
        {
          $data = trim($data);
          $data = stripslashes($data);
          $data = htmlspecialchars($data);
          $data = ucwords(strtolower($data)); // Capitalize
          $data = mysqli_real_escape_string($GLOBALS["db_conn"], $data);
          return $data;
        }

    $name = test_input($_POST['name']);
    $type = test_input($_POST['type']);
    $email = test_input($_POST['email']);
    $phone = test_input($_POST['phone']);
    $subject = test_input($_POST['subject']);
    $content = test_input($_POST['content']);
    $location = "";

    // To be implemented if Globogym runs their own servers in the future
    // $to = "admin@globogym.com";
    // $headers = "From : " . $email;


    // File sanitation
    if (isset($_FILES['file']['tmp_name'])) {
        $file=$_FILES['file']['tmp_name'];
        $image= addslashes(file_get_contents($_FILES['file']['tmp_name']));
        $image_name= addslashes($_FILES['file']['name']);
        $image_size= filesize($_FILES['file']['tmp_name']);

    
        if ($image_size==FALSE) {
        
        header("Location: admin_class.php?failed=filefrmt");
        
        }else{
        // Move the file to the folder contactfiles.
        move_uploaded_file($_FILES["file"]["tmp_name"],"contactfiles/" .$_FILES["file"]["name"]);
        $location=$_FILES["file"]["name"];
        }
    }

    // if (mail($to, $subject, $message, $headers)) {
        $sql = "INSERT INTO tbl_mail(mail_subj, mail_type, mail_content, mail_attachment, mail_stat) VALUES('$subject', '$type', '$content', '$location', '0')";
        if (mysqli_query($db_conn, $sql)) {
            // Pull mail id for usermail linking
            $pull_mailid_query = "SELECT mail_id FROM tbl_mail WHERE mail_type = '$type' AND mail_content = '$content' AND mail_subj='$subject' LIMIT 1";
            $mailid = "";
            $pull_mailid_result = mysqli_query($db_conn, $pull_mailid_query);
                if($pull_mailid_result){
                    $num = mysqli_num_rows($pull_mailid_result);
                    //  Test for valid test result
                    if($num>0){
                        while($row = mysqli_fetch_array($pull_mailid_result)){
                            // Echo out the id
                            $mailid = $row["mail_id"];
                            $push_usermail = "";
                            if(isset($_SESSION["user_id"])){
                                $push_usermail = "INSERT INTO tbl_usermail VALUES('$email','$mailid','1')";
                            }else{
                                $push_usermail = "INSERT INTO tbl_usermail VALUES('$email','$mailid','0')";
                            }
                            if(mysqli_query($db_conn, $push_usermail)){
                                header("Location: contact_us.php?success=true");
                            }else{
                                header("Location: contact_us.php?failed=usermail");
                            }
                        }
                    }else{
                    // Echo out if there are no id listed.
                    header("Location: contact_us.php?error=noidlisted");
                    }
                }
            
        } else {
            header("Location: contact_us.php?failed=insert");
        }
    // } else {
    //     echo "Failed to send message, please try again.";
    // }
    }
?>
      <section class="contact_contain">
        <form action="contact_us.php" enctype="multipart/form-data" method="POST" class ="contact_form">
          <h1>Contact Us</h1>
          <p>For enquiries please complete the contact form below</p>
            <input type="text" placeholder="Your name..." name="name" id="name" class ="contact_control" size="20" maxlength="30">
            <select name="type" id="" class="contact_control">
                <option value="Inquiry">I have an Inquiry</option>
                <option value="Complaint">I want to file a Complaint</option>
                <option value="Careers">I want to apply for GloboGym!</option>
                <option value="Billing">Something involving my Billing</option>
                <option value="Others">It's not listed above...</option>
            </select>
            <!-- Find out if the user is logged in. We can use the Session email for this input -->
            <?php 
                if(isset($_SESSION["user_email"]) && isset($_SESSION["user_id"]) && isset($_SESSION["user_type"])){
                    echo '<input type="hidden" placeholder="Your email..." name="email" value="'.$_SESSION["user_email"].'" class ="contact_control">';
                }else{
                    echo '<input type="email" placeholder="Your email..." name="email" class ="contact_control"/>';     
                }
            ?>
            <input type="tel" name="phone" placeholder="And your number is?.." pattern="^0(83|85|86|87|88|89)\s?\d{1}\s?\d{1}\s?\d{1}\s?\d{1}\s?\d{1}\s?\d{1}\s?\d{1}$" class ="contact_control"/>
            <input type="text" placeholder="Subject line..." name="subject" class ="contact_control">
            <textarea class = "form_control" name="content">Hi Globogym, I just want to say...</textarea>
            <span>Add Supporting Documents</span>
            <input type="file" accept="image/png, image/jpeg, .pdf, .docx, .xlsx" name="file" id="" title="I accept .jpg, .png, .pdf, .docx and .xlsx files!">
            <input type="submit" name="submit" value="Send!" class ="send_message">
        </form>
        <div id="map"></div>
      </section>
      <script>
      function initMap(){
        var location = {lat: 53.352130, lng:-6.264950};
        var map = new google.maps.Map(document.getElementById("map"),{
          zoom: 15, center: location
        });
        var marker = new google.maps.Marker({
          position:location,
          map: map
        });
      }
    </script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDKojI-TEWoY7330QUBjZqQN-viaw0Ijbo&callback=initMap"></script>
<?php 
require_once("footer.php");
?>