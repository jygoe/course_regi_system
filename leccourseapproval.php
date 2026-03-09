<?php 
include('crssession.php');
if(!session_id())
{
    session_start();
}
if ($_SESSION['u_type'] != 1) {
    header('Location: login.php'); 
    exit();
}

include 'headeradvisor.php'; 
include 'db_connect.php';

// Get User ID
$uic = $_SESSION['funame'];

$sql = "SELECT * FROM tb_registration
       LEFT JOIN tb_user ON tb_registration.r_student = tb_user.u_sno
       LEFT JOIN tb_course ON tb_registration.r_course = tb_course.c_code
       LEFT JOIN tb_status ON tb_registration.r_status = tb_status.s_id
       WHERE r_status = '1'";

$result = mysqli_query($con, $sql);
?>

<div class="container">
    <br>
    <table class="table table_striped table-hover">
    <thead>
        <tr class="table-info">
        <th scope="col">Transaction ID</th>
        <th scope="col">Semester</th>
        <th scope="col">Student ID</th>
        <th scope="col">Student Name</th>
        <th scope="col">Course</th>
        <th scope="col">Course Name</th>
        <th scope="col">Status</th>
        <th scope="col">Operation</th>
        </tr>
    </thead>
    <tbody>

        <?php
        while($row = mysqli_fetch_array($result))
        {
            echo "<tr>";
            echo "<td>".$row['r_tid']."</td>";
            echo "<td>".$row['r_sem']."</td>";
            echo "<td>".$row['u_sno']."</td>";
            echo "<td>".$row['u_name']."</td>";
            echo "<td>".$row['r_course']."</td>";
            echo "<td>".$row['c_name']."</td>";
            echo "<td>".$row['s_decs']."</td>";
            echo "<td>";
            echo "<a href = 'leccourseapprovalprocess.php?id=".$row['r_tid']."' class='btn btn-primary'>Approval</a>";
            echo "</td>";    
            echo "</tr>";
        }
        ?>
    </tbody>
    </table>


</div>


<?php include 'footer.php'; ?>
