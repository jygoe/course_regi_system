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

// Get User ID from the session
$uic = $_SESSION['funame'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $c_code = mysqli_real_escape_string($con, $_POST['c_code']);
    $c_name = mysqli_real_escape_string($con, $_POST['c_name']);
    $c_credit = (int)$_POST['c_credit'];
    $c_sem = mysqli_real_escape_string($con, $_POST['c_sem']);
    $c_lec = mysqli_real_escape_string($con, $_POST['c_lec']);
    $max_students = (int)$_POST['max_students'];

    $sql = "INSERT INTO tb_course (c_code, c_name, c_credit, c_sem, c_lec, max_students, current_students)
            VALUES ('$c_code', '$c_name', $c_credit, '$c_sem', '$c_lec', $max_students, 0)";

    if (mysqli_query($con, $sql)) {
        echo "<script>alert('Course added successfully!');</script>";
    } else {
        echo "<script>alert('Error adding course.');</script>";
    }
}
?>

<div class="container">
  <br><br><h5>Add New Course</h5> 
  <form method="POST" action="adminaddcourseprocess.php" onsubmit="return confirmAddCourse();">
    <fieldset>
      <div>
        <label class="form-label mt-4">Course Code:</label>
        <input type="text" name="c_code" class="form-control" placeholder="Enter Course Code" required>
      </div>

      <div>
        <label class="form-label mt-4">Course Name:</label>
        <input type="text" name="c_name" class="form-control" placeholder="Enter Course Name" required>
      </div>

      <div>
        <label class="form-label mt-4">Course Credit:</label>
        <input type="number" name="c_credit" class="form-control" placeholder="Enter Course Credit" required>
      </div>
      
      <div>
        <label class="form-label mt-4">Select Semester:</label>
        <select class="form-select" name="c_sem" required>
          <option value="2024/2025-1">2024/2025-1</option>
          <option value="2024/2025-2">2024/2025-2</option>
          <option value="2024/2025-3">2024/2025-3</option>
        </select>
      </div>

      <div>
        <label class="form-label mt-4">Lecturer:</label>
        <select class="form-select" name="c_lec" required>
          <option value="" disabled selected>Select Lecturer</option>
          <?php

          $lecturer_sql = "SELECT u_sno, u_name FROM tb_user WHERE u_type = 1";
          $result = mysqli_query($con, $lecturer_sql);
          while ($row = mysqli_fetch_assoc($result)) {
              echo "<option value='" . $row['u_sno'] . "'>" . $row['u_name'] . "</option>";
          }
          ?>
        </select>
      </div>

      <div>
        <label class="form-label mt-4">Maximum Students:</label>
        <input type="number" name="max_students" class="form-control" placeholder="Enter Maximum Students" required>
      </div><br>

      <button type="submit" class="btn btn-primary">Add Course</button>
      <button type="reset" class="btn btn-danger">Clear Form</button>
    </fieldset>
  </form>
  <br><br><br>
</div>

<script>
  function confirmAddCourse() {
    return confirm("Are you sure you want to add this course?");
  }
</script>

<br>
<?php 
include 'footer.php'; 
?>
