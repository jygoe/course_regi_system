<?php
// Connect to the DB
include('db_connect.php');

// Retrieve data from form
$funame = $_POST['funame'];
$fpwd = password_hash($_POST['fpwd'], PASSWORD_DEFAULT);  
$femail = $_POST['femail'];
$fname = $_POST['fname'];
$fcontact = $_POST['fcontact'];
$fstate = $_POST['fstate'];

$sql_check = "SELECT * FROM tb_user WHERE u_sno = '$funame'";
$result_check = mysqli_query($con, $sql_check);

if (mysqli_num_rows($result_check) > 0) {
    echo "<script>
        alert('Registration failed: User ID already exists.');
        window.location.href = 'register.php';  // Redirect back to the registration page
    </script>";
    exit();
}

$sql = "INSERT INTO tb_user(u_sno, u_pwd, u_email, u_name, u_contact, u_state, u_registration, u_type)
        VALUES ('$funame', '$fpwd', '$femail', '$fname', '$fcontact', '$fstate', CURRENT_TIMESTAMP(), '2')";

// Execute SQL
if (mysqli_query($con, $sql)) {
    $message = "Registration successful!";
} else {
    $message = "Registration failed: " . mysqli_error($con);
}

// Close Connection
mysqli_close($con);

echo "<script>
    alert('$message');
    window.location.href = 'login.php';
</script>";
exit();
?>
