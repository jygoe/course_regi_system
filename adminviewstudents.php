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

// Query to get all students from the tb_user table where u_type = 2
$sql = "SELECT * FROM tb_user WHERE u_type = 2 ORDER BY u_sno";

$result = mysqli_query($con, $sql);
?>

<div class="container">
    <br>
    <h5>List of All Students</h5>
    <?php if (mysqli_num_rows($result) > 0): ?>
        <table class="table table-striped table-hover">
            <thead>
                <tr class="table-info">
                    <th scope="col">Student ID</th>
                    <th scope="col">Student Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Phone Number</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo $row['u_sno']; ?></td>
                        <td><?php echo $row['u_name']; ?></td>
                        <td><?php echo $row['u_email']; ?></td>
                        <td><?php echo .0. $row['u_contact']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No students found.</p>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
