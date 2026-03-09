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

// Get Transaction ID and form data
if (isset($_POST['tid'])) {
    $tid = $_POST['tid'];
    $fcourse = $_POST['fcourse'];
    $fsem = $_POST['fsem'];
    $flecturer = $_POST['flecturer'];
    $fstatus = $_POST['fstatus'];
}

$sql = "UPDATE tb_registration 
        SET r_course = '$fcourse', r_sem = '$fsem', r_status = '$fstatus'
        WHERE r_tid = '$tid'";

if (mysqli_query($con, $sql)) {
    $update_lecturer_sql = "UPDATE tb_course 
                            SET c_lec = '$flecturer' 
                            WHERE c_code = '$fcourse'";
    
    if (mysqli_query($con, $update_lecturer_sql)) {
        $_SESSION['message'] = "Registration updated successfully.";
    } else {
        $_SESSION['message'] = "Error updating the lecturer assignment.";
    }
} else {
    $_SESSION['message'] = "Error updating the course registration.";
}

header('Location: adminamend.php?tid=' . $tid);
exit();
?>
