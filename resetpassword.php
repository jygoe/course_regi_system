<?php
include('db_connect.php');
include('headermain.php');

// Set timezone
date_default_timezone_set('Asia/Kuala_Lumpur');
$current_time = date("Y-m-d H:i:s");

if (isset($_GET['token'])) {
    $token = $_GET['token'];

    // Verify the token using prepared statement
    $query = "SELECT * FROM tb_user WHERE reset_token = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "s", $token);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($user = mysqli_fetch_assoc($result)) {
        $token_expiry = $user['token_expiry'];

        if ($token_expiry > $current_time) { // Token is still valid
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $new_password = $_POST['password'];
                $confirm_password = $_POST['confirm_password'];

                // Check if the passwords match
                if ($new_password !== $confirm_password) {
                    echo "<script>alert('Passwords do not match. Please try again.');</script>";
                } else {
                    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

                    // Update the password and clear the token using prepared statement
                    $update_query = "UPDATE tb_user SET u_pwd = ?, reset_token = NULL, token_expiry = NULL WHERE reset_token = ?";
                    $stmt = mysqli_prepare($con, $update_query);
                    mysqli_stmt_bind_param($stmt, "ss", $hashed_password, $token);
                    if (mysqli_stmt_execute($stmt)) {
                        echo "<script>alert('Password reset successful. You can now log in with your new password.'); window.location.href = 'login.php';</script>";
                    } else {
                        echo "<script>alert('Failed to reset password. Please try again.');</script>";
                    }
                }
            }
        } else {
            echo "<script>alert('Token has expired. Please request a new password reset link.'); window.location.href = 'forgotpassword.php';</script>";
        }
    } else {
        echo "<script>alert('Invalid token. Please check the link or request a new one.'); window.location.href = 'forgotpassword.php';</script>";
    }
} else {
    echo "<script>alert('No token provided. Please request a new password reset link.'); window.location.href = 'forgotpassword.php';</script>";
}

// Close connection
mysqli_close($con);
?>

<!-- Reset Password Form -->
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h5 class="text-center">Reset Password</h5>
            <form method="POST" action="" class="mt-4">
                <fieldset>
                    <div class="mb-3">
                        <label class="form-label">Enter your new password:</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Confirm your new password:</label>
                        <input type="password" name="confirm_password" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Reset Password</button>
                </fieldset>
            </form>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
