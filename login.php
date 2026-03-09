<?php 
session_start();
include 'headermain.php'; 

// Check if there was a login error
if (isset($_SESSION['login_error']) && $_SESSION['login_error'] == true) {
    echo "<script>
        window.onload = function() {
            var myModal = new bootstrap.Modal(document.getElementById('loginModal'));
            myModal.show();
        };
    </script>";
    unset($_SESSION['login_error']);
}
?>

<div class="container">
  <br><br><h5>Login</h5>
  <form method="POST" action="loginprocess.php">
    <fieldset>
      <div>
        <label class="form-label mt-4">Staff/Student ID</label>
        <input type="text" name="funame" class="form-control" aria-describedby="emailHelp" placeholder="Enter your staff or student number" required>
      </div>

      <div>
        <label class="form-label mt-4">Password</label>
        <input type="password" name="fpwd" class="form-control" placeholder="Enter your password" autocomplete="off" required>
      </div>

      <br><button type="submit" class="btn btn-primary">Login</button><br><br>
      <small><a href='forgotpassword.php'>Forgot Password?</a></small>
    </fieldset>
  </form>
  <br><br><br>
</div>

<!-- Modal for incorrect login -->
<div class="modal" tabindex="-1" id="loginModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Login Failed</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>Your username or password is incorrect. Please choose an option:</p>
      </div>
      <div class="modal-footer">
        <a href="login.php" class="btn btn-primary">Try Again</a>
        <a href="register.php" class="btn btn-success">Register Now</a>
      </div>
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>
