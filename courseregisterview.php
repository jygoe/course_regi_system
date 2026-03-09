<?php 
include('crssession.php');
if (!session_id()) {
    session_start();
}
if ($_SESSION['u_type'] != 2) {
    header('Location: login.php'); 
    exit();
}

include 'headerstudent.php'; 
include 'db_connect.php';

// Get Transaction ID
if (isset($_GET['tid'])) {
    $tid = $_GET['tid'];
}

// Retrieve the registration details
$sql = "SELECT tb_registration.*, tb_user.u_name AS stud_name, 
               tb_user_lecturer.u_name AS lect_name, 
               tb_user.u_sno AS stud_id,
               tb_course.c_name 
        FROM tb_registration
        LEFT JOIN tb_user ON tb_registration.r_student = tb_user.u_sno
        LEFT JOIN tb_course ON tb_registration.r_course = tb_course.c_code
        LEFT JOIN tb_user AS tb_user_lecturer ON tb_course.c_lec = tb_user_lecturer.u_sno
        LEFT JOIN tb_status ON tb_registration.r_status = tb_status.s_id
        WHERE r_tid = '$tid'";

// Execute the SQL statement
$result = mysqli_query($con, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_array($result);
} else {
    echo "No registration details found for the provided Transaction ID.";
    exit; 
}

// Retrieve all available courses
$course_sql = "SELECT * FROM tb_course";
$course_result = mysqli_query($con, $course_sql);
?>

<div class="container">
    <br><br>
    <h5>Course Information</h5>
    <form method="POST" action="courseregisterupdate.php">
        <input type="hidden" name="tid" value="<?php echo isset($row['r_tid']) ? $row['r_tid'] : ''; ?>">
        <br>
        <div class="form-group">
            <label>Transaction ID:</label>
            <input type="text" class="form-control" value="<?php echo isset($row['r_tid']) ? $row['r_tid'] : ''; ?>" disabled>
        </div>
        <br>
        <div class="form-group">
            <label>Student ID:</label>
            <input type="text" class="form-control" value="<?php echo isset($row['stud_id']) ? $row['stud_id'] : ''; ?>" disabled>
        </div>
        <br>
        <div class="form-group">
            <label>Student Name:</label>
            <input type="text" class="form-control" value="<?php echo isset($row['stud_name']) ? $row['stud_name'] : ''; ?>" disabled>
        </div>
        <br>
        <div class="form-group">
            <label>Lecturer Name:</label>
            <input type="text" class="form-control" value="<?php echo isset($row['lect_name']) ? $row['lect_name'] : ''; ?>" disabled>
        </div>
        <br>
        <div class="form-group">
            <label>Course:</label>
            <input type="text" class="form-control" value="<?php echo isset($row['c_name']) ? $row['c_name'] : ''; ?>" disabled>
        </div>
        <br>
        <div class="form-group">
            <label>Semester:</label>
            <input type="text" class="form-control" value="<?php echo isset($row['r_sem']) ? $row['r_sem'] : ''; ?>" disabled>
        </div>
        <br>
        <br>
        <a href="courseview.php" class="btn btn-primary">Back</a>
    </form>
</div>
<br><br><br>

<?php include 'footer.php'; ?>
