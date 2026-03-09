<?php 
include('crssession.php');
if (!session_id()) {
    session_start();
}
if ($_SESSION['u_type'] != 1) { 
    header('Location: login.php'); 
    exit();
}

include 'headeradvisor.php'; 
include 'db_connect.php';

// Get Lecturer ID
$lec_id = $_SESSION['funame'];

$sql = "SELECT tb_course.c_code, tb_course.c_name, tb_course.c_sem, COUNT(tb_registration.r_student) AS student_count
        FROM tb_course
        LEFT JOIN tb_registration ON tb_course.c_code = tb_registration.r_course
        WHERE tb_course.c_lec = '$lec_id'
        GROUP BY tb_course.c_code, tb_course.c_name, tb_course.c_sem
        ORDER BY tb_course.c_sem ASC";

$result = mysqli_query($con, $sql);

// Group courses by semester
$courses_by_semester = [];
while ($row = mysqli_fetch_assoc($result)) {
    $semester = $row['c_sem'];
    if (!isset($courses_by_semester[$semester])) {
        $courses_by_semester[$semester] = [];
    }
    $courses_by_semester[$semester][] = $row;
}
?>

<div class="container">
    <br>
    <h5>Assigned Courses by Semester</h5>
    <?php if (!empty($courses_by_semester)): ?>
        <?php foreach ($courses_by_semester as $semester => $courses): ?>
            <h6>Semester: <?php echo $semester; ?></h6>
            <table class="table table-striped table-hover">
                <thead>
                    <tr class="table-info">
                        <th scope="col">Course Code</th>
                        <th scope="col">Course Name</th>
                        <th scope="col">Student Count</th>
                        <th scope="col" style="text-align: center;">Operation</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($courses as $course): ?>
                        <tr>
                            <td><?php echo $course['c_code']; ?></td>
                            <td><?php echo $course['c_name']; ?></td>
                            <td><?php echo $course['student_count']; ?></td>
                            <td style="text-align: center;">
                                <a href="lecviewcourse.php?course=<?php echo $course['c_code']; ?>&sem=<?php echo $semester; ?>" 
                                class="btn btn-primary btn-sm" style="margin-left: 10px;">View Details</a>
                                <a href="lecviewstudents.php?course=<?php echo $course['c_code']; ?>&sem=<?php echo $semester; ?>" 
                                   class="btn btn-primary btn-sm">View Students</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <br>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No assigned courses found.</p>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
