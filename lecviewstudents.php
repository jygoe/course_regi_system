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

$course_code = mysqli_real_escape_string($con, $_GET['course']);
$semester = mysqli_real_escape_string($con, $_GET['sem']);

$sql = "SELECT tb_user.u_sno, tb_user.u_name, tb_user.u_email
        FROM tb_registration
        LEFT JOIN tb_user ON tb_registration.r_student = tb_user.u_sno
        WHERE tb_registration.r_course = '$course_code' AND tb_registration.r_sem = '$semester'";

$result = mysqli_query($con, $sql);
?>

<div class="container">
    <br>
    <h5>Students Enrolled in <?php echo $course_code . ' - ' . $semester; ?></h5>
    <?php if (mysqli_num_rows($result) > 0): ?>
        <table class="table table-striped table-hover">
            <thead>
                <tr class="table-info">
                    <th scope="col">Student ID</th>
                    <th scope="col">Student Name</th>
                    <th scope="col">Email</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $row['u_sno']; ?></td>
                        <td><?php echo $row['u_name']; ?></td>
                        <td><?php echo $row['u_email']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No students enrolled in this course for the selected semester.</p>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
