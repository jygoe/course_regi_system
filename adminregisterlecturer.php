<?php  
include('crssession.php');
if(!session_id()) {
    session_start();
}
if ($_SESSION['u_type'] != 3) {
    header('Location: login.php'); 
    exit();
}

include 'headerit.php'; 
include 'db_connect.php';

// Get User ID
$uic = $_SESSION['funame'];
 ?>

<div class="container">
  <br><br><h5>Please fill in all the following details to register a lecturer</h5>
  <form method="POST" action="adminregisterlecturerprocess.php" onsubmit="return confirmSubmission();">
    <fieldset>
      <div>
        <label class="form-label mt-4">Staff ID</label>
        <input type="text" name="funame" class="form-control" placeholder="Enter lecturer ID" required>
      </div>

      <div>
        <label class="form-label mt-4">Create Password</label>
        <input type="password" name="fpwd" class="form-control" placeholder="Create password" autocomplete="off" required>
      </div>

      <div>
        <label class="form-label mt-4">Email</label>
        <input type="email" name="femail" class="form-control" placeholder="Enter lecturer email" required>
      </div>

      <div>
        <label class="form-label mt-4">Full Name</label>
        <input type="text" name="fname" class="form-control" placeholder="Enter lecturer's full name" required>
      </div>

      <div>
        <label class="form-label mt-4">Contact Number</label>
        <input type="text" name="fcontact" class="form-control" placeholder="Enter lecturer's contact number" required>
      </div>

      <div>
        <label class="form-label mt-4">State</label>
        <select class="form-select" name="fstate">
          <option>Johor</option>
          <option>Kedah</option>
          <option>Kelantan</option>
          <option>Melaka</option>
          <option>Negeri Sembilan</option>
          <option>Pahang</option>
          <option>Pulau Pinang</option>
          <option>Perak</option>
          <option>Perlis</option>
          <option>Sabah</option>
          <option>Sarawak</option>
          <option>Selangor</option>
          <option>Terengganu</option>
          <option>W.P. Labuan</option>
          <option>W.P. Kuala Lumpur</option>
          <option>W.P. Putrajaya</option>
        </select>
      </div><br>

      <button type="submit" class="btn btn-primary">Submit</button>
      <button type="reset" class="btn btn-danger">Clear Form</button>
    </fieldset>
  </form>
  <br><br><br>
</div>

<script>
  function confirmSubmission() {
    return confirm("Are you sure you want to submit this form?");
  }
</script>

<?php include 'footer.php'; ?>
