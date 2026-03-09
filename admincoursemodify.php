<?php
include('crssession.php');
if (!session_id()) {
    session_start();
}
if ($_SESSION['u_type'] != 3) {
    header('Location: login.php');
    exit();
}
include 'headerit.php';
include 'db_connect.php';

if (isset($_GET['id'])) {
    $c_code = $_GET['id'];

    $sql = "SELECT * FROM tb_course WHERE c_code = '$c_code'";
    $result = mysqli_query($con, $sql);
    $course = mysqli_fetch_assoc($result);

    if (!$course) {
        echo "<script>
            alert('Course not found.');
            window.location.href = 'adminpage.php';
        </script>";
        exit();
    }
}

$lecturers_sql = "SELECT u_sno, u_name FROM tb_user WHERE u_type = 1";
$lecturers_result = mysqli_query($con, $lecturers_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modify Course</title>
</head>
<body>
<div class="container mt-5">
    <h5>Modify Course</h5>
    <form method="POST" action="admincourseupdate.php" onsubmit="return confirmUpdate();">
        <input type="hidden" name="c_code" value="<?php echo $course['c_code']; ?>">
        <br>
        <div class="form-group">
            <label>Course Code:</label>
            <input type="text" class="form-control" value="<?php echo $course['c_code']; ?>" disabled>
        </div>
        <br>
        <div class="form-group">
            <label>Course Name:</label>
            <input type="text" class="form-control" name="c_name" value="<?php echo htmlspecialchars($course['c_name']); ?>" required>
        </div>
        <br>
        <div class="form-group">
            <label>Course Credit:</label>
            <input type="number" class="form-control" name="c_credit" value="<?php echo $course['c_credit']; ?>" required>
        </div>
        <br>
        <div class="form-group">
            <label>Lecturer:</label>
            <select class="form-select" name="c_lec">
                <?php while ($lecturer = mysqli_fetch_array($lecturers_result)): ?>
                    <option value="<?php echo $lecturer['u_sno']; ?>" 
                        <?php if ($lecturer['u_sno'] == $course['c_lec']) echo 'selected'; ?>>
                        <?php echo $lecturer['u_name']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <br>
        <div class="form-group">
            <label>Semester:</label>
            <select class="form-select" name="c_sem" required>
                <option value="" disabled selected>Select Semester</option>
                <option value="2024/2025-1" <?php if ($course['c_sem'] == '2024/2025-1') echo 'selected'; ?>>2024/2025-1</option>
                <option value="2024/2025-2" <?php if ($course['c_sem'] == '2024/2025-2') echo 'selected'; ?>>2024/2025-2</option>
                <option value="2024/2025-3" <?php if ($course['c_sem'] == '2024/2025-3') echo 'selected'; ?>>2024/2025-3</option>
            </select>
        </div>
        <br>
        <div class="form-group">
            <label>Maximum Students:</label>
            <input type="number" class="form-control" name="max_students" value="<?php echo $course['max_students']; ?>" required>
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Update Course</button>
        <a href="admincourselist.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

<script>
    function confirmUpdate() {
        return confirm("Are you sure you want to update this course?");
    }
</script>

</body>
</html>

<br><br><br>

<?php include 'footer.php'; ?>