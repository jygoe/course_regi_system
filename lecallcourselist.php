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

// Get Lecturer ID from session
$lec_id = $_SESSION['funame'];

// Query to get all courses assigned to the lecturer
$sql = "SELECT * FROM tb_course";

$result = mysqli_query($con, $sql);
?>

<div class="container">
    <br>
    <h5>All Courses</h5>
    <?php if (mysqli_num_rows($result) > 0): ?>
        <table class="table table-striped table-hover">
            <thead>
                <tr class="table-info">
                    <th scope="col">Course Code</th>
                    <th scope="col">Course Name</th>
                    <th scope="col">Semester</th>
                    <!-- <th scope="col" style="text-align: center;">Operation</th> -->
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $row['c_code']; ?></td>
                        <td><?php echo $row['c_name']; ?></td>
                        <td><?php echo $row['c_sem']; ?></td>
                        <!-- <td style="text-align: center;">
                            <a href="lecviewstudents.php?course=<?php echo $row['c_code']; ?>&sem=<?php echo $row['c_sem']; ?>" class="btn btn-primary btn-sm">View Students</a>
                        </td> -->
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No courses assigned yet.</p>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
