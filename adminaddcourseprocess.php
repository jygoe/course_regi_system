<?php 
include('crssession.php');

// Start the session if not already started
if (!session_id()) {
    session_start();
}
if ($_SESSION['u_type'] != 3) { 
    header('Location: login.php'); 
    exit();
}

include('db_connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $c_code = mysqli_real_escape_string($con, $_POST['c_code']);
    $c_name = mysqli_real_escape_string($con, $_POST['c_name']);
    $c_credit = (int)$_POST['c_credit'];
    $c_sem = mysqli_real_escape_string($con, $_POST['c_sem']);
    $c_lec = mysqli_real_escape_string($con, $_POST['c_lec']);
    $max_students = (int)$_POST['max_students'];

    // Check if the course code already exists for the same semester
    $check_sql = "SELECT * FROM tb_course WHERE c_code = '$c_code' AND c_sem = '$c_sem'";
    $check_result = mysqli_query($con, $check_sql);

    if (mysqli_num_rows($check_result) > 0) {
        // Course code exists for the same semester
        echo "<script>alert('Error: The course code already exists for the selected semester.');</script>";
        echo "<script>window.location.href='adminaddcourse.php';</script>";  // Redirect to the correct page
    } else {
        $sql = "INSERT INTO tb_course (c_code, c_name, c_credit, c_sem, c_lec, max_students, current_students)
                VALUES ('$c_code', '$c_name', $c_credit, '$c_sem', '$c_lec', $max_students, 0)";

        if (mysqli_query($con, $sql)) {
            echo "<script>alert('Course added successfully!');</script>";
            echo "<script>window.location.href='adminaddcourse.php';</script>";  // Redirect to the correct page after successful addition
        } else {
            echo "<script>alert('Error adding course: " . mysqli_error($con) . "');</script>";
            echo "<script>window.location.href='adminaddcourse.php';</script>";  // Redirect on error
        }
    }
}
?>
