<?php
include('crssession.php');
if (!session_id()) {
    session_start();
}
if ($_SESSION['u_type'] != 1) { // Ensure only lecturers can access
    header('Location: login.php'); 
    exit();
}

include 'headeradvisor.php'; 
include 'db_connect.php';

// Get Lecturer ID
$lec_id = $_SESSION['funame'];

$c_code = mysqli_real_escape_string($con, $_GET['course']);
$c_sem = mysqli_real_escape_string($con, $_GET['sem']);

// Retrieve course details
$sql = "SELECT * FROM tb_course WHERE c_code = '$c_code' AND c_sem = '$c_sem' AND c_lec = '$lec_id'";
$result = mysqli_query($con, $sql);
$course = mysqli_fetch_assoc($result);

if (!$course) {
    echo "<script>alert('Course not found or you do not have access to this course.');</script>";
    echo "<script>window.location.href='lecviewstudent.php';</script>";
}
?>

<div class="container">
    <br>
    <h5>Course Details</h5>
    <table class="table table-striped table-hover">
        <tr>
            <th>Course Code</th>
            <td><?php echo $course['c_code']; ?></td>
        </tr>
        <tr>
            <th>Course Name</th>
            <td><?php echo $course['c_name']; ?></td>
        </tr>
        <tr>
            <th>Course Credit</th>
            <td><?php echo $course['c_credit']; ?></td>
        </tr>
        <tr>
            <th>Semester</th>
            <td><?php echo $course['c_sem']; ?></td>
        </tr>
        <tr>
            <th>Lecturer</th>
            <td><?php echo $course['c_lec']; ?></td>
        </tr>
        <tr>
            <th>Max Students</th>
            <td><?php echo $course['max_students']; ?></td>
        </tr>
        <tr>
            <th>Current Students</th>
            <td><?php echo $course['current_students']; ?></td>
        </tr>
    </table>
</div>

<?php include 'footer.php'; ?>
