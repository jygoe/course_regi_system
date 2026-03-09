<?php include 'headermain.php'; ?>

<div class="container">
  <br><br><h5>Please fill in all following details</h5><br>
  <form method="POST" action="registerprocess.php" onsubmit="return confirmSubmission();">
    <fieldset>
      <div>
        <label class="form-label mt-4">Please enter your staff or student number</label>
        <input type="text" name="funame" class="form-control" aria-describedby="emailHelp" placeholder="Enter your staff or student ID" required>
      </div>

      <div>
        <label class="form-label mt-4">Create your password</label>
        <input type="password" name="fpwd" class="form-control" placeholder="Create your password" autocomplete="off" required>
        <!--<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>-->
      </div>

      <div>
        <label class="form-label mt-4">Email</label>
        <input type="text" name="femail" class="form-control" aria-describedby="emailHelp" placeholder="Enter your email" required>
      </div>

      <div>
        <label class="form-label mt-4">Enter your full name: </label>
        <input type="text" name="fname" class="form-control" aria-describedby="emailHelp" placeholder="Enter your full name" required>
      </div>

      <div>
        <label class="form-label mt-4">Enter your contact number: </label>
        <input type="text" name="fcontact" class="form-control" aria-describedby="emailHelp" placeholder="Enter your contact number" required>
      </div>

      <div>
        <label class="form-label mt-4">Select your state</label>
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
