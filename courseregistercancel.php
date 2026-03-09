<?php
include('crssession.php');
if (!session_id()) {
    session_start();
}

include 'db_connect.php';

// Get Transaction ID (r_tid)
if (isset($_GET['tid'])) {
    $tid = $_GET['tid'];

    $course_sql = "SELECT r_course, r_sem FROM tb_registration WHERE r_tid = '$tid'";
    $course_result = mysqli_query($con, $course_sql);
    $course_row = mysqli_fetch_array($course_result);

    if ($course_row) {
        $fcourse = $course_row['r_course'];
        $fsem = $course_row['r_sem'];

        $status_sql = "SELECT r_status FROM tb_registration WHERE r_tid = '$tid'";
        $status_result = mysqli_query($con, $status_sql);
        $status_row = mysqli_fetch_array($status_result);

        $sql = "UPDATE tb_registration SET r_status = 4 WHERE r_tid = '$tid'";

        if (mysqli_query($con, $sql)) {
            $update_sql = "UPDATE tb_course 
                           SET current_students = current_students - 1 
                           WHERE c_code = '$fcourse' AND c_sem = '$fsem'";
            if (mysqli_query($con, $update_sql)) {
                $_SESSION['message'] = 'Course registration cancelled successfully.';
            } else {
                $_SESSION['message'] = 'Error updating the course student count. Please try again.';
            }
            } else {
                $_SESSION['message'] = 'Error canceling registration. Please try again.';
            }
    } else {
        $_SESSION['message'] = 'Invalid course registration transaction.';
    }

    header('Location: courseview.php');
}

// Close connection
mysqli_close($con);
?>
