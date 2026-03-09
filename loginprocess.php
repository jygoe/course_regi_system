<?php
session_start();
include('db_connect.php');

function cleanPost($data) {
    $cleanData = [];
    foreach ($data as $key => $value) {
        $cleanData[$key] = htmlspecialchars(trim($value));
    }
    return $cleanData;
}


$funame = $_POST['funame']; 
$fpwd = $_POST['fpwd'];  
$fpwd = trim($fpwd);

$errors = []; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cleanPost = cleanPost($_POST);
    $funame = $cleanPost['funame'];
    $fpwd = $cleanPost['fpwd'];  

    if (empty($errors)) {
        $sql = "SELECT * FROM tb_user WHERE u_sno = ?";
        $stmt = mysqli_prepare($con, $sql);
        
        mysqli_stmt_bind_param($stmt, 's', $funame);  
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($result);

        if ($user) {
            if (password_verify($fpwd, $user['u_pwd'])) {
                $_SESSION['u_sno'] = $user['u_sno'];  
                $_SESSION['funame'] = $user['u_sno'];  
                $_SESSION['u_type'] = $user['u_type'];

                if ($user['u_type'] == 1) { // Lecturer
                    header('Location: advisor.php');
                    exit();
                } elseif ($user['u_type'] == 2) { // Student
                    header('Location: student.php');
                    exit();
                } elseif ($user['u_type'] == 3) { // IT Staff
                    header('Location: staff.php');
                    exit();
                } else {
                    echo "<script>alert('Invalid user type!'); window.location.href = 'login.php';</script>";
                    exit();
                }
            } else {
                echo "<script>alert('Incorrect password.'); window.location.href = 'login.php';</script>";
                exit();
            }
        } else {
            echo "<script>alert('User does not exist.'); window.location.href = 'login.php';</script>";
            exit();
        }
    }
}

mysqli_close($con);
?>
