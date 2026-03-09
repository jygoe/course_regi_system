<?php
include('crssession.php');
if (!session_id()) {
    session_start();
}
if ($_SESSION['u_type'] != 2) {
    header('Location: login.php'); 
    exit();
}

include 'db_connect.php';

$tid = $_POST['tid']; // Get Transaction ID
$fcourse = $_POST['fcourse']; // New course code
$fsem = $_POST['fsem']; // New semester

// Step 1: Check if the course exists in the selected semester
$query = "SELECT max_students, current_students FROM tb_course WHERE c_code = ? AND c_sem = ?";
$stmt = mysqli_prepare($con, $query);
mysqli_stmt_bind_param($stmt, "ss", $fcourse, $fsem);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) == 0) {
    // Course does not exist in the selected semester
    echo "<script>
        alert('Error: The selected course does not exist in the selected semester.');
        window.location.href = 'courseregisteredit.php?tid=$tid'; // Redirect back to course edit page
    </script>";
    exit();
}

$row = mysqli_fetch_assoc($result);
$max_students = $row['max_students'];
$current_students = $row['current_students'];

// Step 2: Check if the course is full
if ($current_students >= $max_students) {
    // Course is full
    echo "<script>
        alert('This course is full. You cannot register.');
        window.location.href = 'courseregisteredit.php?tid=$tid'; // Redirect back to course edit page
    </script>";
    exit();
}

// Step 3: Check if the course or semester is being changed by the student
$existing_course = $_POST['existing_course']; // This will hold the original course from the registration record
$existing_sem = $_POST['existing_sem']; // This will hold the original semester from the registration record

// If the course or semester is changed, we proceed with the update
if ($fcourse != $existing_course || $fsem != $existing_sem) {
    // Step 4: Update the course registration in tb_registration table
    $update_sql = "UPDATE tb_registration SET r_course = ?, r_sem = ? WHERE r_tid = ?";
    $stmt = mysqli_prepare($con, $update_sql);
    mysqli_stmt_bind_param($stmt, "sss", $fcourse, $fsem, $tid);
    
    if (mysqli_stmt_execute($stmt)) {
        // Step 5: Update current_students count in tb_course
        $update_students_sql = "UPDATE tb_course SET current_students = current_students + 1 WHERE c_code = ? AND c_sem = ?";
        $stmt = mysqli_prepare($con, $update_students_sql);
        mysqli_stmt_bind_param($stmt, "ss", $fcourse, $fsem);
        
        if (mysqli_stmt_execute($stmt)) {
            // Step 6: Update current_students count for the old course (decrease by 1)
            $decrease_students_sql = "UPDATE tb_course SET current_students = current_students - 1 WHERE c_code = ? AND c_sem = ?";
            $stmt = mysqli_prepare($con, $decrease_students_sql);
            mysqli_stmt_bind_param($stmt, "ss", $existing_course, $existing_sem);
            
            if (mysqli_stmt_execute($stmt)) {
                echo "<script>
                    alert('Course registration updated successfully!');
                    window.location.href = 'courseview.php'; // Redirect to course view page
                </script>";
            } else {
                echo "<script>
                    alert('Error updating the old course registration.');
                    window.location.href = 'courseregisteredit.php?tid=$tid'; // Redirect back to course edit page
                </script>";
            }
        } else {
            echo "<script>
                alert('Error updating current students for the new course.');
                window.location.href = 'courseregisteredit.php?tid=$tid'; // Redirect back to course edit page
            </script>";
        }
    } else {
        echo "<script>
            alert('Error updating course registration.');
            window.location.href = 'courseregisteredit.php?tid=$tid'; // Redirect back to course edit page
        </script>";
    }
} else {
    // No change in course or semester, just display a message
    echo "<script>
        alert('No changes detected in the course or semester.');
        window.location.href = 'courseview.php'; // Redirect to course view page
    </script>";
}

// Close database connection
mysqli_close($con);
?>
