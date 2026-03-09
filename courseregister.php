<?php 
include('crssession.php');
if(!session_id()) {
    session_start();
}
if ($_SESSION['u_type'] != 2) {
  header('Location: login.php'); 
  exit();
}

include 'headerstudent.php'; 
include 'db_connect.php'; 
?>

<div class="container">
  <br><br><h5>Course Registration Form</h5>
  <form method="POST" action="courseregisterprocess.php" onsubmit="return confirmPassword();">
    <fieldset>
      <div>
        <label class="form-label mt-4">Select Course</label>
        <select class="form-select" name="fcourse" id="fcourse" required>
        <?php
        $sql = "SELECT DISTINCT c_code, c_name FROM tb_course";
        $result = mysqli_query($con, $sql);
        
        while ($row = mysqli_fetch_array($result)) {
            echo "<option value='" . $row['c_code'] . "'>" . $row['c_name'] . "</option>";
        }        
        ?>
        </select>
      </div><br>

      <div>
        <label class="form-label mt-4">Select Semester</label>
        <select class="form-select" name="fsem" required>
          <option>2024/2025-1</option>
          <option>2024/2025-2</option>
          <option>2024/2025-3</option>
        </select>
      </div><br>

      <button type="reset" class="btn btn-danger">Clear Form</button>
      <button type="submit" class="btn btn-primary">Register</button>
    </fieldset>
  </form>
  <br><br><br>
</div>

<script>
  function confirmPassword() {
    var password = prompt("Please enter your password to confirm registration:");
    
    if (password == null || password == "") {
      alert("Password is required to complete registration.");
      return false;
    }
    
    var passwordInput = document.createElement("input");
    passwordInput.type = "hidden";
    passwordInput.name = "password";
    passwordInput.value = password;
    document.forms[0].appendChild(passwordInput);
    
    return true;
  }
</script>

<?php include 'footer.php'; ?>
