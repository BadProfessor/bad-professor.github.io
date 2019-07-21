<?php
// call the header.php
require_once("header.php");
// Check if the user is logged in
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    // if not, log in
    header("location: login.php");
    exit;
}
?>
<script type="text/javascript">
    $(document).ready(function() {
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
<div class="wrapper">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class=" clearfix">
                    <h2 class="float-left">Reviews Details</h2>
                    <a href="create.php" class="btn btn-success float-right">Add New review</a>
                </div>
                <?php
                // Attempt select query execution
                $sql = "SELECT * FROM reviews";
                if ($result = mysqli_query($link, $sql)) {
                    if (mysqli_num_rows($result) > 0) {
                        echo "<table class='table table-bordered table-striped'>";
                        echo "<thead class='thead-dark'>";
                        echo "<tr scope='col'>";
                        echo "<th scope='col'>#</th>";
                        echo "<th scope='col'>Username</th>";
                        echo "<th scope='col'>Comment</th>";
                        echo "<th scope='col'>Rating</th>";
                        echo "<th scope='col'>Action</th>";
                        echo "</tr>";
                        echo "</thead>";
                        echo "<tbody>";
                        while ($row = mysqli_fetch_array($result)) {
                            echo "<tr>";
                            echo "<td>" . $row['id'] . "</td>";
                            echo "<td>" . $row['username'] . "</td>";
                            echo "<td>" . $row['comment'] . "</td>";
                            echo "<td>" . $row['rating'] . "</td>";
                            echo "<td>";
                            echo "<a href='read.php?id=" . $row['id'] . "' title='View Record' data-toggle='tooltip'><i class='fas fa-eye'></i></a>";
                            echo "<a href='update.php?id=" . $row['id'] . "' title='Update Record' data-toggle='tooltip'><i class='fas fa-pencil-alt'></i></a>";
                            echo "<a href='delete.php?id=" . $row['id'] . "' title='Delete Record' data-toggle='tooltip'><i class='fas fa-trash'></i></a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                        echo "</tbody>";
                        echo "</table>";
                        // Free result set
                        mysqli_free_result($result);
                    } else {
                        echo "<p class='lead'><em>No records were found.</em></p>";
                    }
                } else {
                    echo "ERROR: Could not able to execute $sql. " . mysqli_error($link);
                }
                ?>
            </div>
        </div>
    </div>
</div>
<?php
require_once("footer.php");
?>