<?php 
    include_once("connection.php");
    include_once("session_validate.php");
    include_once("header.php");

    // Intercept URL http requests
    if(isset($_POST["update"])){
        // Sanitize the input
        $id = test_input($_POST["id"]);
        $title = test_input($_POST["title"]);
        $desc = test_input($_POST["desc"]);
        $link = test_input($_POST["link"]);
        $stat = test_input($_POST["status"]);

        // Image Manipulation and Insertion.
        if (!isset($_FILES['image']['tmp_name'])) {
            header("Location: admin_index.php?failed=noimg");
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
                move_uploaded_file($_FILES["image"]["tmp_name"],"img/featuredimg/" .$_FILES["image"]["name"]);
                
                $location=$_FILES["image"]["name"];
                // Query to add the update featured.
                $update_featured = "UPDATE tbl_featured SET featured_title = '$title', featured_desc = '$desc', featured_link = '$link', featured_image = '$location', featured_stat = '$stat' WHERE featured_id = '$id'";
                if(mysqli_query($db_conn, $update_featured)){
                    header("Location: admin_index.php?success=update");
                }else{
                    header("Location: admin_index.php?dberror=update");
                }
            }
        }else{
            header("Location: admin_index.php?failed=addimg");
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
	<section class="form_container">
        <!-- We need to include enctype for forms that accept images -->
      <form id="class_add" action="admin_index.php" method="POST" enctype="multipart/form-data" class="form">
        <h1>ADMIN MENU - EDIT Featured 1</h1>
        <?php 
        // Pull all featured from database
        $pull_featured = "SELECT * FROM tbl_featured WHERE featured_id = '1'";
        $pull_featured_result = mysqli_query($db_conn, $pull_featured);
        if($pull_featured_result){
          $num = mysqli_num_rows($pull_featured_result);
          //  Test for valid test result
          if($num>0){
            while($row = mysqli_fetch_array($pull_featured_result)){
              // Echo out the classes
              echo '<input type="number" name="id" id="" value="1" required hidden>
                    <label>Featured Title</label><input type="text" value="'.$row["featured_title"].'" name="title" class="form_control" size="20" maxlength="50" required>
                    <label>Featured Description</label><textarea class = "form_control" name="desc" minlength="20" maxlength="255" title="Alphanumerics only, max of 255 characters" required>'.$row["featured_desc"].'</textarea>
                    <label>Featured Link (Paste the page URL here)</label><input type="text" value="'.$row["featured_link"].'" name="link" class="form_control" size="20" maxlength="50" required>
                    <label>Featured Image</label><input type="file" id="image" value="'.$row["featured_image"].'" class="itemFileInput" accept="image/png, image/jpeg" name="image" required>
                    <select name="status" class = "form_control">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                    <input type="submit" name="update" value="Update" class="formBtn" required>';
            }
          }else{
            // Echo out if there are no classes listed.
            echo '<input type="text" name="id" id="" value="1" required hidden>
                <label>Featured Title</label><input type="text" name="title" class="form_control" size="20" maxlength="50" required>
                <label>Featured Description</label><textarea class = "form_control" name="desc" minlength="20" maxlength="255" title="Alphanumerics only, max of 255 characters" required></textarea>
                <label>Featured Link (Paste the page URL here)</label><input type="text" name="link" class="form_control" size="20" maxlength="50" required>
                <label>Featured Image</label><input type="file" id="image" class="itemFileInput" accept="image/png, image/jpeg" name="image" required>
                <select name="status" class = "form_control">
                <option value="1">Active</option>
                <option value="0">Inactive</option>
                </select>
                <input type="submit" name="update" value="Update" class="formBtn" required>';
          }
        }
        ?>
        
      </form>
    </section>

    <section class="form_container">
        <!-- We need to include enctype for forms that accept images -->
      <form id="class_add" action="admin_index.php" method="POST" enctype="multipart/form-data" class="form">
        <h1>ADMIN MENU - EDIT Featured 2</h1>
        <?php 
        // Pull all featured from database
        $pull_featured = "SELECT * FROM tbl_featured WHERE featured_id = '2'";
        $pull_featured_result = mysqli_query($db_conn, $pull_featured);
        if($pull_featured_result){
          $num = mysqli_num_rows($pull_featured_result);
          //  Test for valid test result
          if($num>0){
            while($row = mysqli_fetch_array($pull_featured_result)){
              // Echo out the classes
              echo '<input type="number" name="id" id="" value="2" required hidden>
                    <label>Featured Title</label><input type="text" value="'.$row["featured_title"].'" name="title" class="form_control" size="20" maxlength="50" required>
                    <label>Featured Description</label><textarea class = "form_control" name="desc" minlength="20" maxlength="255" title="Alphanumerics only, max of 255 characters" required>'.$row["featured_desc"].'</textarea>
                    <label>Featured Link (Paste the page URL here)</label><input type="text" value="'.$row["featured_link"].'" name="link" class="form_control" size="20" maxlength="50" required>
                    <label>Featured Image</label><input type="file" id="image" value="'.$row["featured_image"].'" class="itemFileInput" accept="image/png, image/jpeg" name="image" required>
                    <select name="status" class = "form_control">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                    <input type="submit" name="update" value="Update" class="formBtn" required>';
            }
          }else{
            // Echo out if there are no classes listed.
            echo '<input type="text" name="id" id="" value="1" required hidden>
                <label>Featured Title</label><input type="text" name="title" class="form_control" size="20" maxlength="50" required>
                <label>Featured Description</label><textarea class = "form_control" name="desc" minlength="20" maxlength="255" title="Alphanumerics only, max of 255 characters" required></textarea>
                <label>Featured Link (Paste the page URL here)</label><input type="text" name="link" class="form_control" size="20" maxlength="50" required>
                <label>Featured Image</label><input type="file" id="image" class="itemFileInput" accept="image/png, image/jpeg" name="image" required>
                <select name="status" class = "form_control">
                <option value="1">Active</option>
                <option value="0">Inactive</option>
                </select>
                <input type="submit" name="update" value="Update" class="formBtn" required>';
          }
        }
        ?>
        
      </form>
    </section>
<?php 
	include_once("admin_footer.php");
?>