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

$sql = "SELECT * FROM tb_registration
       LEFT JOIN tb_course ON tb_registration.r_course = tb_course.c_code
       LEFT JOIN tb_status ON tb_registration.r_status = tb_status.s_id";

$result = mysqli_query($con, $sql);

if (isset($_SESSION['message'])) {
    echo "<script>alert('" . $_SESSION['message'] . "');</script>";
    unset($_SESSION['message']); // Clear the message after displaying
}
?>

<div class="container">
    <br>
    <h5>Manage Course Registrations</h5>
    <br>
    <table class="table table-striped table-hover">
    <thead>
        <tr class="table-info">
        <th scope="col">Transaction ID</th>
        <th scope="col">Student</th>
        <th scope="col">Semester</th>
        <th scope="col">Course</th>
        <th scope="col">Course Name</th>
        <th scope="col">Status</th>
        <th scope="col" style="text-align: center;">Operation</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_array($result)) {
                echo "<tr>";
                echo "<td>" . $row['r_tid'] . "</td>";
                echo "<td>" . $row['r_student'] . "</td>"; // Added student ID
                echo "<td>" . $row['r_sem'] . "</td>";
                echo "<td>" . $row['r_course'] . "</td>";
                echo "<td>" . $row['c_name'] . "</td>";
                echo "<td>" . $row['s_decs'] . "</td>";

                echo "<td style='width: 150px; text-align: center;'>
                    <a href='adminamend.php?tid=" . $row['r_tid'] . "' class='btn btn-primary btn-sm'>Amend</a>
                    </td>";

                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7' style='text-align: center;'>No course registrations found.</td></tr>";
        }
        ?>
    </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>
