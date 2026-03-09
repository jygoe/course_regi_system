<?php  
include('crssession.php');
if(!session_id()) {
    session_start();
}
if ($_SESSION['u_type'] != 3) {
    header('Location: login.php'); 
    exit();
}

include 'headerit.php'; 
include 'db_connect.php';

// Get User ID
$uic = $_SESSION['funame'];

$sql = "SELECT * FROM tb_course
        LEFT JOIN tb_user ON tb_course.c_lec = tb_user.u_sno";
       
$result = mysqli_query($con, $sql);

if (isset($_SESSION['message'])) {
    echo "<script>alert('".$_SESSION['message']."');</script>";
    unset($_SESSION['message']);
}
?>

<div class="container">
    <br>
    <h5>Course List</h5>
    <br>
    <table class="table table-striped table-hover">
    <thead>
        <tr class="table-info">
            <th scope="col">Course Code</th>
            <th scope="col">Course Name</th>
            <th scope="col">Course Credit</th>
            <th scope="col">Semester</th>
            <th scope="col">Lecturer ID</th>
            <th scope="col">Lecturer</th>
            <th scope="col">Maximum Students</th>
            <th scope="col">Operation</th>
        </tr>
    </thead>
    <tbody>

        <?php
        while ($row = mysqli_fetch_array($result)) {
            echo "<tr>";
            echo "<td>".$row['c_code']."</td>";
            echo "<td>".$row['c_name']."</td>";
            echo "<td>".$row['c_credit']."</td>";
            echo "<td>".$row['c_sem']."</td>";
            echo "<td>".$row['c_lec']."</td>";
            echo "<td>".$row['u_name']."</td>";
            echo "<td>".$row['max_students']."</td>";
            echo "<td>";
            echo "<a href='admincoursemodify.php?id=".$row['c_code']."' class='btn btn-primary'>Modify</a>";
            echo " ";

            echo "<form method='POST' action='admincoursedelete.php' onsubmit='return confirmDelete();' style='display:inline;'>";
            echo "<input type='hidden' name='c_code' value='".$row['c_code']."'>";
            echo "<button type='submit' class='btn btn-danger'>Delete</button>";
            echo "</form>";

            echo "</td>"; 
            echo "</tr>";
        }
        ?>
    </tbody>
    </table>
</div>

<script>
    function confirmDelete() {
        return confirm("Are you sure you want to delete this course?");
    }
</script>

<?php include 'footer.php'; ?>
