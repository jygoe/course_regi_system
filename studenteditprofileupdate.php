<?php
include('crssession.php');
if (!session_id()) {
    session_start();
}

include 'headerstudent.php'; 
include 'db_connect.php';

$uic = $_SESSION['funame']; 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $u_email = mysqli_real_escape_string($con, $_POST['u_email']);
    $u_contact = mysqli_real_escape_string($con, $_POST['u_contact']);
    $u_state = mysqli_real_escape_string($con, $_POST['fstate']);

    $update_sql = "UPDATE tb_user 
                   SET u_email = '$u_email', u_contact = '$u_contact', u_state = '$u_state' 
                   WHERE u_sno = '$uic'";

    if (mysqli_query($con, $update_sql)) {
        $_SESSION['message'] = 'Profile updated successfully!';
        header('Location: studenteditprofile.php'); 
        exit;
    } else {
        $_SESSION['message'] = 'Error updating profile. Please try again.';
        header('Location: studenteditprofile.php'); 
        exit;
    }
}

// Close connection
mysqli_close($con);
?>
