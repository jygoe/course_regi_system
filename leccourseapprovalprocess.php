<?php 
include('crssession.php');
if(!session_id())
{
    session_start();
}

include 'headeradvisor.php'; 
include 'db_connect.php';

// Get Transaction ID
if(isset($_GET['id']))
{
    $tid = $_GET['id'];
}

$sql = "SELECT * FROM tb_registration
       LEFT JOIN tb_user ON tb_registration.r_student = tb_user.u_sno
       LEFT JOIN tb_course ON tb_registration.r_course = tb_course.c_code
       LEFT JOIN tb_status ON tb_registration.r_status = tb_status.s_id
       WHERE r_tid = '$tid'";

$result = mysqli_query($con, $sql);
$row = mysqli_fetch_array($result);
?>

<div class="container">
    <br>
    <table class="table table_striped table-hover">
    <tr>
        <td>Transaction ID</td>
        <td><?php echo $row['r_tid']; ?></td>
    </tr>
    <tr>
        <td>Semester</td>
        <td><?php echo $row['r_sem']; ?></td>
    </tr>
    <tr>
        <td>Student ID</td>
        <td><?php echo $row['u_sno']; ?></td>
    </tr>
    <tr>
        <td>Student Name</td>
        <td><?php echo $row['u_name']; ?></td>
    </tr>
    <tr>
        <td>Course</td>
        <td><?php echo $row['c_code']; ?></td>
    </tr>
    <tr>
        <td>Course Name</td>
        <td><?php echo $row['c_name']; ?></td>
    </tr>
    <tr>
        <td>Approval</td>
        <td></td>
    </tr>

    <tbody>

    </tbody>
    </table>


</div>


<?php include 'footer.php'; ?>
