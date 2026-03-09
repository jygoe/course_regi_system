<?php 
include('crssession.php');
if (!session_id()) {
    session_start();
}

include 'db_connect.php'; 

$uic = $_SESSION['funame'];
$fcourse = $_POST['fcourse']; 
$fsem = $_POST['fsem']; 
$input_password = $_POST['password']; 

// Step 1: Check if course exists in the selected semester
$query = "SELECT max_students, current_students FROM tb_course WHERE c_code = ? AND c_sem = ?";
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, "ss", $fcourse, $fsem);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) == 0) {
    echo "<script>
        alert('Error: The selected course does not exist in the selected semester. Please choose another course.');
        window.location.href = 'courseregister.php'; // Redirect back to course registration page
    </script>";
    exit();
}

$row = mysqli_fetch_assoc($result);
$max_students = $row['max_students'];
$current_students = $row['current_students'];

// Step 2: Check if the student is already registered for this course in the same semester
$check_registration = "SELECT 1 FROM tb_registration WHERE r_student = ? AND r_course = ? AND r_sem = ?";
$stmt = mysqli_prepare($con, $check_registration);
mysqli_stmt_bind_param($stmt, "sss", $uic, $fcourse, $fsem);
mysqli_stmt_execute($stmt);
$registration_result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($registration_result) > 0) {
    echo "<script>
        alert('Error: You are already registered for this course in the selected semester.');
        window.location.href = 'courseregister.php'; // Redirect back to course registration page
    </script>";
    exit();
}

// Step 3: Check if the course is full
if ($current_students >= $max_students) {
    echo "<script>
        alert('This course is full. You cannot register.');
        window.location.href = 'courseregister.php'; // Redirect back to course registration page
    </script>";
    exit();
}

// Step 4: Check password
$query = "SELECT u_pwd FROM tb_user WHERE u_sno = ?";
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, "s", $uic);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

if ($row && password_verify($input_password, $row['u_pwd'])) { // Use u_pwd here
    // Password is correct, proceed with registration

    // Step 5: Insert into registration table
    $status = '2'; // Approved
    $sql = "INSERT INTO tb_registration (r_student, r_course, r_sem, r_status) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $sql);

    if (!$stmt) {
        die("Prepare failed: " . mysqli_error($con));
    }

    mysqli_stmt_bind_param($stmt, "ssss", $uic, $fcourse, $fsem, $status);

    if (mysqli_stmt_execute($stmt)) {
        echo "<script>console.log('Registration inserted successfully');</script>";

        // Step 6: Update current_students count
        $update_sql = "UPDATE tb_course SET current_students = current_students + 1 WHERE c_code = ? AND c_sem = ?";
        $stmt = mysqli_prepare($con, $update_sql);
        if (!$stmt) {
            die("Prepare failed: " . mysqli_error($con));
        }
        mysqli_stmt_bind_param($stmt, "ss", $fcourse, $fsem);

        if (mysqli_stmt_execute($stmt)) {
            echo "<script>console.log('current_students updated successfully');</script>";
        } else {
            echo "<script>console.log('Error updating current_students: " . mysqli_error($con) . "');</script>";
        }

        // Registration success alert
        echo "<script>
            alert('Registration successful!');
            window.location.href = 'courseview.php';
        </script>";
    } else {
        echo "<script>
            alert('Registration failed: " . mysqli_error($con) . "');
            window.location.href = 'courseregister.php'; // Redirect back to course registration page
        </script>";
    }
} else {
    // Invalid password
    echo "<script>
        alert('Error: Invalid password.');
        window.location.href = 'courseregister.php'; // Redirect back to course registration page
    </script>";
}

// Close database connection
mysqli_close($con);
?>
