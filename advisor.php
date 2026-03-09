<?php 
include('crssession.php');

// Start the session if not already started
if (!session_id()) {
    session_start();
}
if ($_SESSION['u_type'] != 1) {
    header('Location: login.php'); 
    exit();
}

include 'headeradvisor.php';  
include('db_connect.php');

// Get User ID from the session
$uic = $_SESSION['funame'];

$sql = "SELECT * FROM tb_user WHERE u_sno = '$uic'";

$result = mysqli_query($con, $sql);

$userName = "Unknown User";

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $userName = $row['u_name'];
}
?>

<!-- Banner Section for Lecturer -->
<div class="image-section" style="position: relative; width: 100%; overflow: hidden; border-bottom: 5px solid #fff;">
    <img src="img/lec.png" alt="Lecture Banner" class="img-fluid" style="object-fit: cover;">
    <div class="overlay-text" style="position: absolute; bottom: 20px; left: 20px; right: 20px; padding: 20px;">
        <h1 class="display-4 text-primary">Welcome, <?php echo htmlspecialchars($userName); ?>!</h1>
        <p class="lead text-primary">Your teaching journey begins here. Stay updated with your courses and tasks!</p>
    </div>
</div>

        <!-- Lecturer Dashboard Section -->
        <div class="container text-center">
            <h2 class="text-primary">Lecturer Dashboard</h2>
            <div class="row">
                <!-- Card 1: Grading Reminder -->
                <div class="col-md-4 mb-4">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h4 class="card-title">View Assigned Courses</h4>
                    <p class="card-text">Check out all the courses assigned to you for the current and upcoming semesters.</p>
                    <a href="leccourselist.php" class="btn btn-dark">View Assigned Courses</a>
                </div>
            </div>
        </div>

        <!-- Card 2: View All Student List -->
        <div class="col-md-4 mb-4">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <h4 class="card-title">View All Students</h4>
                    <p class="card-text">View the list of all students enrolled in your courses. Click the button to check it out!</p>
                    <a href="lecstudentlist.php" class="btn btn-dark">View All Students</a>
                </div>
            </div>
        </div>

        <!-- Card 3: View All Course List -->
        <div class="col-md-4 mb-4">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h4 class="card-title">View All Courses</h4>
                    <p class="card-text">Explore all available courses for the current and upcoming semesters.</p>
                    <a href="lecallcourselist.php" class="btn btn-dark">View All Courses</a>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Reminder Section -->
<div class="container-fluid text-center py-5 bg-primary text-white">
    <h3>Don't Forget!</h3>
    <p>Check you course update and student list from time to time!!</p>
</div>

<!-- Footer Section -->
<?php 
include 'footer.php'; 
?>
