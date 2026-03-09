<?php 
include('crssession.php');

if (!session_id()) {
    session_start();
}
if ($_SESSION['u_type'] != 3) { 
    header('Location: login.php'); 
    exit();
}

include 'headerit.php';  
include('db_connect.php');

$total_students_query = "SELECT COUNT(*) AS total_students FROM tb_user WHERE u_type = 2";
$total_courses_query = "SELECT COUNT(*) AS total_courses FROM tb_course"; // Total Courses
$total_lecturers_query = "SELECT COUNT(*) AS total_lecturers FROM tb_user WHERE u_type = 1";

$total_students_result = mysqli_query($con, $total_students_query);
$total_courses_result = mysqli_query($con, $total_courses_query);
$total_lecturers_result = mysqli_query($con, $total_lecturers_query);

$total_students = mysqli_fetch_assoc($total_students_result)['total_students'];
$total_courses = mysqli_fetch_assoc($total_courses_result)['total_courses'];
$total_lecturers = mysqli_fetch_assoc($total_lecturers_result)['total_lecturers'];
?>

<!-- Banner Section -->
<div class="image-section" style="position: relative; width: 100%; overflow: hidden; border-bottom: 5px solid #fff;">
    <img src="img/admin.png" alt="Lecture Banner" class="img-fluid" style="object-fit: cover;">
    <div class="overlay-text" style="position: absolute; bottom: 20px; left: 20px; right: 20px; padding: 20px;">
    </div>
</div>

<!-- Admin Dashboard Section -->
<div class="container text-center">
    <h2 class="text-primary">Admin Dashboard</h2>
    <div class="row">
        <!-- Card 1: Total Students -->
        <div class="col-md-4 mb-4">
            <div class="card text-white bg-warning">
                <div class="card-body">
                    <h4 class="card-title">Total Students</h4>
                    <p class="card-text"><?php echo $total_students; ?> Students</p>
                    <a href="adminviewstudents.php" class="btn btn-dark">View All Students</a>
                </div>
            </div>
        </div>

        <!-- Card 2: Total Courses -->
        <div class="col-md-4 mb-4">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <h4 class="card-title">Total Courses</h4>
                    <p class="card-text"><?php echo $total_courses; ?> Courses</p>
                    <a href="admincourselist.php" class="btn btn-dark">View All Courses</a>
                </div>
            </div>
        </div>

        <!-- Card 3: Total Lecturers -->
        <div class="col-md-4 mb-4">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h4 class="card-title">Total Lecturers</h4>
                    <p class="card-text"><?php echo $total_lecturers; ?> Lecturers</p>
                    <a href="adminviewlecturers.php" class="btn btn-dark">View All Lecturers</a>
                </div>
            </div>
        </div>

    </div>
    <br>
    <div class="row">
        <!-- Card 4: View Pending Registrations -->
        <div class="col-md-4 mb-4">
            <div class="card text-white bg-danger">
                <div class="card-body">
                    <h4 class="card-title">Pending Registrations</h4>
                    <p class="card-text">Review pending aprroved course registrations! Check it now!</p>
                    <a href="adminregister.php" class="btn btn-dark">View Pending</a>
                </div>
            </div>
        </div>

        <!-- Card 5: Add a New Course -->
        <div class="col-md-4 mb-4">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h4 class="card-title">Add a New Course</h4>
                    <p class="card-text">Create and add new courses to the system for the upcoming semester.</p>
                    <a href="adminaddcourse.php" class="btn btn-dark">Add Course</a>
                </div>
            </div>
        </div>

        <!-- Card 6: Register New Lecturer -->
        <div class="col-md-4 mb-4">
            <div class="card text-white bg-secondary">
                <div class="card-body">
                    <h4 class="card-title">Register New Lecturer</h4>
                    <p class="card-text">Add a new lecturer to the system by providing their details and credentials.</p>
                    <a href="adminregisterlecturer.php" class="btn btn-dark">Register Lecturer</a>
                </div>
            </div>
        </div>


    </div>
</div>
<br><br>
<!-- Footer Section -->
<?php 
include 'footer.php'; 
?>
