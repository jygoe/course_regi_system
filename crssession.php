<?php
if (!session_id()) {
    session_start(); 
}

if (!isset($_SESSION['u_sno'])) {
    header('Location: login.php'); 
    exit();
}

if (!isset($_SESSION['u_type'])) {
    header('Location: login.php');
    exit();
}
?>
