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

$sql = "SELECT tb_registration.*, 
               tb_user.u_name AS student_name, tb_user.u_sno AS student_id,
               tb_course.c_name AS course_name, tb_course.c_lec AS lecturer_id,
               tb_status.s_decs AS status_desc,
               lecturer.u_name AS lecturer_name
        FROM tb_registration
        LEFT JOIN tb_user ON tb_registration.r_student = tb_user.u_sno
        LEFT JOIN tb_course ON tb_registration.r_course = tb_course.c_code
        LEFT JOIN tb_status ON tb_registration.r_status = tb_status.s_id
        LEFT JOIN tb_user AS lecturer ON tb_course.c_lec = lecturer.u_sno
        WHERE r_tid = '$tid'";

// Execute the SQL statement
$result = mysqli_query($con, $sql);
$row = mysqli_fetch_array($result);

// Retrieve all available courses
$course_sql = "SELECT * FROM tb_course";
$course_result = mysqli_query($con, $course_sql);

$action = isset($_GET['action']) ? $_GET['action'] : '';
?>

<div class="container">
    <br><br>
    <h5>Edit Course Registration</h5>

    <?php if ($action == 'resubmit'): ?>
        <div class="alert alert-warning">
            <?php echo $_SESSION['message']; ?>
            <br>
            <a href="courseregisterupdate.php" class="btn btn-success">Confirm Resubmit</a>
            <a href="courseview.php" class="btn btn-danger">Cancel</a>
        </div>
    <?php else: ?>
        <form method="POST" action="courseregisterupdate.php" onsubmit="return confirmUpdate()">
            <input type="hidden" name="tid" value="<?php echo $row['r_tid']; ?>">
            <br>
            <div class="form-group">
                <label>Transaction ID:</label>
                <input type="text" class="form-control" value="<?php echo $row['r_tid']; ?>" disabled>
            </div>
            <br>
            <div class="form-group">
                <label>Student ID:</label>
                <input type="text" class="form-control" value="<?php echo $row['student_id']; ?>" disabled>
            </div>
            <br>
            <div class="form-group">
                <label>Student Name:</label>
                <input type="text" class="form-control" value="<?php echo $row['student_name']; ?>" disabled>
            </div>
            <br>
            <div class="form-group">
                <label>Lecturer ID:</label>
                <input type="text" class="form-control" value="<?php echo $row['lecturer_id']; ?>" disabled>
            </div>
            <br>
            <div class="form-group">
                <label>Lecturer Name:</label>
                <input type="text" class="form-control" value="<?php echo $row['lecturer_name']; ?>" disabled>
            </div>
            <br>
            <div class="form-group">
                <label>Course:</label>
                <select class="form-select" name="fcourse" id="fcourse">
                    <?php while($course = mysqli_fetch_array($course_result)): ?>
                        <option value="<?php echo $course['c_code']; ?>" <?php if($course['c_code'] == $row['r_course']) echo 'selected'; ?>>
                            <?php echo $course['c_code'] . ' - ' . $course['c_name']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <br>
            <div class="form-group">
                <label>Semester:</label>
                <select class="form-select" name="fsem" id="fsem">
                    <option <?php if ($row['r_sem'] == '2024/2025-1') echo 'selected'; ?>>2024/2025-1</option>
                    <option <?php if ($row['r_sem'] == '2024/2025-2') echo 'selected'; ?>>2024/2025-2</option>
                    <option <?php if ($row['r_sem'] == '2024/2025-3') echo 'selected'; ?>>2024/2025-3</option>
                </select>
            </div>
            <br>
            <br>
            <button type="button" class="btn btn-danger" onclick="window.history.back()">Back</button>
            <button type="submit" class="btn btn-primary">Update Registration</button>
        </form>
    <?php endif; ?>
</div>
<br><br><br>

<script>
function confirmUpdate() {
    var selectedCourse = document.getElementById("fcourse").value;
    var selectedSemester = document.getElementById("fsem").value;
    
    <?php if ($row['r_status'] == 3): ?>
        if (selectedCourse === "<?php echo $row['r_course']; ?>" && selectedSemester === "<?php echo $row['r_sem']; ?>") {
            alert("You cannot resubmit with the same course and semester.");
            return false; // Prevent form submission
        } else {
            return confirm("Are you sure you want to resubmit the registration?");
        }
    <?php else: ?>
        return confirm("Are you sure you want to update your course registration?");
    <?php endif; ?>
}
</script>

<?php include 'footer.php' ?>
