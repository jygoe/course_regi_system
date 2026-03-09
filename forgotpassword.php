<?php
session_start();
include('db_connect.php');
include('headermain.php');

date_default_timezone_set('Asia/Kuala_Lumpur');  
$current_time = date("Y-m-d H:i:s"); // Get current server time
echo "<script>console.log('Current Server Time: $current_time');</script>"; // Debugging: Show in browser console

if (isset($_SESSION['reset_error']) && $_SESSION['reset_error'] == true) {
    echo "<script>
        // Show the modal after the page loads
        window.onload = function() {
            var myModal = new bootstrap.Modal(document.getElementById('resetModal'));
            myModal.show();
        };
    </script>";
    unset($_SESSION['reset_error']); // Clear the error session
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    // Check if email exists
    $query = "SELECT * FROM tb_user WHERE u_email = '$email'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);

        $token = bin2hex(random_bytes(32));
        $expiry = date("Y-m-d H:i:s", strtotime('+1 hour'));

        $update_query = "UPDATE tb_user SET reset_token = '$token', token_expiry = '$expiry' WHERE u_email = '$email'";
        mysqli_query($con, $update_query);

        $reset_link = "http://localhost/crs/resetpassword.php?token=$token";
        $subject = "Password Reset Request";
        $message = "
        Hi,

        We received a request to reset your password. Click the link below to reset it:
        $reset_link

        This link will expire in 1 hour.

        If you did not request this, please ignore this email.

        Regards,
        Admin Team
        ";

        $headers = "From: admin@example.com\r\n";

        if (mail($email, $subject, $message, $headers)) {
            echo "<script>
                    alert('A password reset link has been sent to your email.');
                    window.location.href = 'login.php'; // Redirect to login page
                </script>";
        } else {
            echo "<script>
                    alert('Failed to send the email.');
                    window.location.href = 'login.php'; // Redirect to login page
                </script>";
        }
    } else {
        echo "<script>
                alert('No account found with that email.');
                window.location.href = 'login.php'; // Redirect to login page
            </script>";
    }
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h5 class="text-center">Forgot Password</h5>
            <form method="POST" action="" class="mt-4">
                <fieldset>
                    <div class="mb-3">
                        <label class="form-label">Enter your email address:</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Submit</button><br><br>
                </fieldset>
            </form>
        </div>
    </div>
</div>

<?php
// Closing connection
mysqli_close($con);
?>

<?php include 'footer.php'; ?>
