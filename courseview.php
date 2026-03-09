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

// Get User ID
$uic = $_SESSION['funame'];

$sql = "SELECT DISTINCT tb_registration.r_tid, tb_registration.r_sem, tb_registration.r_course, 
                tb_course.c_name, tb_status.s_decs, tb_registration.r_status
        FROM tb_registration
        LEFT JOIN tb_course ON tb_registration.r_course = tb_course.c_code
        LEFT JOIN tb_status ON tb_registration.r_status = tb_status.s_id
        WHERE r_student='$uic'";

// Execute the SQL statement on DB
$result = mysqli_query($con, $sql);

// Display the message if it's set in the session
if (isset($_SESSION['message'])) {
    echo "<script>alert('" . $_SESSION['message'] . "');</script>";
    unset($_SESSION['message']); // Clear the message after displaying
}
?>

<div class="container">
    <br>
    <h5>Course Registered</h5>
    <table class="table table-striped table-hover">
    <thead>
        <tr class="table-info">
        <th scope="col">Transaction ID</th>
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
                $status = isset($row['r_status']) ? $row['s_decs'] : 'N/A';

                echo "<tr>";
                echo "<td>" . $row['r_tid'] . "</td>";
                echo "<td>" . $row['r_sem'] . "</td>";
                echo "<td>" . $row['r_course'] . "</td>";
                echo "<td>" . $row['c_name'] . "</td>";
                echo "<td>" . $status . "</td>";

                if ($row['r_status'] != 4) {
                    echo "<td style='width: 150px; text-align: center;'>
                          <a href='courseregisteredit.php?tid=" . $row['r_tid'] . "' class='btn btn-primary btn-sm'>Edit</a>
                          <a href='courseregistercancel.php?tid=" . $row['r_tid'] . "' 
                             class='btn btn-danger btn-sm' 
                             onclick='return confirm(\"Are you sure you want to cancel this registration?\")'>Cancel</a>
                          </td>";
                } else {
                    echo "<td style='text-align: center;'>N/A</td>";
                }

                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6' style='text-align: center;'>There is no course registration submitted yet.</td></tr>";
        }
        ?>
    </tbody>
    </table>
</div>

<?php include 'footer.php'; ?>
