<?php  
include('crssession.php');
if (!session_id()) {
    session_start();
}

if ($_SESSION['u_type'] != 3) {  
    header('Location: login.php'); 
    exit();
}

include 'db_connect.php';
include 'headerit.php';

// Get Transaction ID
if (isset($_GET['tid'])) {
    $tid = $_GET['tid'];
}

// Retrieve the registration details
$sql = "SELECT * FROM tb_registration
       LEFT JOIN tb_user ON tb_registration.r_student = tb_user.u_sno
       LEFT JOIN tb_course ON tb_registration.r_course = tb_course.c_code
       LEFT JOIN tb_status ON tb_registration.r_status = tb_status.s_id
       WHERE r_tid = '$tid'";

// Execute the SQL statement
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_array($result);

// Retrieve all available courses
$course_sql = "SELECT * FROM tb_course";
$course_result = mysqli_query($con, $course_sql);

// Retrieve all available lecturers
$lecturer_sql = "SELECT * FROM tb_user WHERE u_type = 1"; 
$lecturer_result = mysqli_query($con, $lecturer_sql);

// Retrieve all status options
$status_sql = "SELECT * FROM tb_status";
$status_result = mysqli_query($con, $status_sql);

// Display the message if it's set in the session
if (isset($_SESSION['message'])) {
    echo "<script>alert('" . $_SESSION['message'] . "');</script>";
    unset($_SESSION['message']); // Clear the message after displaying
}
?>

<div class="container">
    <br><br>
    <h5>Edit Course Registration</h5>
    <br>

    <form method="POST" action="adminamendupdate.php" onsubmit="return confirmUpdate()">
        <input type="hidden" name="tid" value="<?php echo $row['r_tid']; ?>">
        
        <div class="form-group">
            <label>Transaction ID:</label>
            <input type="text" class="form-control" value="<?php echo $row['r_tid']; ?>" disabled>
        </div>
        <br>
        
        <div class="form-group">
            <label>Student ID:</label>
            <input type="text" class="form-control" value="<?php echo $row['u_sno']; ?>" disabled>
        </div>
        <br>

        <div class="form-group">
            <label>Student Name:</label>
            <input type="text" class="form-control" value="<?php echo $row['u_name']; ?>" disabled>
        </div>
        <br>

        <div class="form-group">
            <label>Lecturer ID:</label>
            <select class="form-select" name="flecturer">
                <?php while ($lecturer = mysqli_fetch_array($lecturer_result)): ?>
                    <option value="<?php echo $lecturer['u_sno']; ?>" <?php if ($lecturer['u_sno'] == $row['c_lec']) echo 'selected'; ?>>
                        <?php echo $lecturer['u_sno'] . ' - ' . $lecturer['u_name']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <br>

        <div class="form-group">
            <label>Course:</label>
            <select class="form-select" name="fcourse">
                <?php while ($course = mysqli_fetch_array($course_result)): ?>
                    <option value="<?php echo $course['c_code']; ?>" <?php if ($course['c_code'] == $row['r_course']) echo 'selected'; ?>>
                        <?php echo $course['c_code'] . ' - ' . $course['c_name']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <br>

        <div class="form-group">
            <label>Semester:</label>
            <select class="form-select" name="fsem">
                <option <?php if ($row['r_sem'] == '2024/2025-1') echo 'selected'; ?>>2024/2025-1</option>
                <option <?php if ($row['r_sem'] == '2024/2025-2') echo 'selected'; ?>>2024/2025-2</option>
                <option <?php if ($row['r_sem'] == '2024/2025-3') echo 'selected'; ?>>2024/2025-3</option>
            </select>
        </div>
        <br>

        <div class="form-group">
            <label>Status:</label>
            <select class="form-select" name="fstatus">
                <?php while ($status = mysqli_fetch_array($status_result)): ?>
                    <option value="<?php echo $status['s_id']; ?>" <?php if ($status['s_id'] == $row['r_status']) echo 'selected'; ?>>
                        <?php echo $status['s_decs']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <br>

        <button type="submit" class="btn btn-primary">Update Registration</button>
    </form>
</div>
<br><br><br>
<script>
function confirmUpdate() {
    return confirm("Are you sure you want to update the registration details?");
}
</script>

<?php include 'footer.php'; ?>
