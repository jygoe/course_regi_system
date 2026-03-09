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

if (isset($_POST['c_code'])) {
    $c_code = $_POST['c_code'];

    $sql = "SELECT * FROM tb_course WHERE c_code = '$c_code'";
    $result = mysqli_query($con, $sql);
    $course = mysqli_fetch_assoc($result);

    if ($course) {
        // Delete all registrations for this course
        $delete_registrations_sql = "DELETE FROM tb_registration WHERE r_course = '$c_code'";
        mysqli_query($con, $delete_registrations_sql);

        // Delete the course
        $delete_course_sql = "DELETE FROM tb_course WHERE c_code = '$c_code'";

        if (mysqli_query($con, $delete_course_sql)) {
            $_SESSION['message'] = 'Course and its registrations have been deleted successfully.';
        } else {
            $_SESSION['message'] = 'Error deleting course. Please try again.';
        }
    } else {
        $_SESSION['message'] = 'Course not found.';
    }
}

$sql = "SELECT * FROM tb_course LEFT JOIN tb_user ON tb_course.c_lec = tb_user.u_sno";
$result = mysqli_query($con, $sql);

mysqli_close($con);

header('Location: admincourselist.php');
exit();
?>
