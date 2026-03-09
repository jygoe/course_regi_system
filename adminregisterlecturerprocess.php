<?php
include('db_connect.php');
include('email_function.php');  // Include the email function

$funame = $_POST['funame'];
$fpwd = $_POST['fpwd'];
$femail = $_POST['femail'];
$fname = $_POST['fname'];
$fcontact = $_POST['fcontact'];
$fstate = $_POST['fstate'];

$hashed_password = password_hash($fpwd, PASSWORD_DEFAULT);

$sql_check = "SELECT * FROM tb_user WHERE u_sno = '$funame' OR u_email = '$femail'";
$result_check = mysqli_query($con, $sql_check);

if (mysqli_num_rows($result_check) > 0) {
    echo "<script>
        alert('Lecturer ID or email already exists.');
        window.location.href = 'adminregisterlecturer.php';
    </script>";
    exit();
}

$sql = "INSERT INTO tb_user(u_sno, u_pwd, u_email, u_name, u_contact, u_state, u_registration, u_type)
        VALUES ('$funame', '$hashed_password', '$femail', '$fname', '$fcontact', '$fstate', CURRENT_TIMESTAMP(), '1')";

// Execute SQL
if (mysqli_query($con, $sql)) {
    $emailSent = sendWelcomeEmail($femail, $fname, $funame, $fpwd);

    if ($emailSent) {
        $message = "Lecturer registration successful and email sent!";
    } else {
        $message = "Lecturer registration successful, but failed to send the email.";
    }
} else {
    $message = "Registration failed: " . mysqli_error($con);
}

// Close Connection
mysqli_close($con);

echo "<script>
    alert('$message');
    window.location.href = 'adminviewlecturers.php';
</script>";
exit();
?>
