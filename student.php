<?php 
include('crssession.php');

// Start the session if not already started
if (!session_id()) {
    session_start();
}
if ($_SESSION['u_type'] != 2) {
    header('Location: login.php'); 
    exit();
}

include 'headerstudent.php';
include('db_connect.php');

// Get User ID
$uic = $_SESSION['funame'];

$sql = "SELECT * FROM tb_user WHERE u_sno = '$uic'";

// Execute the query
$result = mysqli_query($con, $sql);

$userName = "Unknown User";

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $userName = $row['u_name'];
}
?>

<div class="image-section" style="position: relative; width: 100%; overflow: hidden; border-bottom: 5px solid white;">
    <img src="img/course.png" alt="Course Registration System" class="img-fluid" style="max-height: 550px; object-fit: cover;">
</div>

<div class="container-fluid text-center py-5 bg-primary text-white">
    <h1 class="display-4">
        Welcome, <?php echo htmlspecialchars($userName); ?>!
    </h1>
    <p class="lead">
        Don't forget to complete your course registration before the deadline!
    </p>
</div>

<br>
<?php 
include 'footer.php'; 
?>
