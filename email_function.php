<?php
function sendWelcomeEmail($toEmail, $toName, $username, $temppw) {
    $resetLink = "http://yourdomain.com/reset_password.php?username=$username"; 

    // Email content
    $subject = "Welcome to Our System! Please reset your password.";
    $message = "
        <h1>Welcome, $toName!</h1>
        <p>Thank you for registering with us.</p>
        <p>Your account has been created successfully. Below are your account details:</p>
        <p><strong>Username:</strong> $username</p>
        <p><strong>Password:</strong> $temppw</p>
        <p>Click the link below to reset your password:</p>
        <p><a href='$resetLink'>$resetLink</a></p>
        <p>If you did not request this, please ignore this email.</p>
    ";

    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8" . "\r\n";
    $headers .= "From: admin@crssystem.com" . "\r\n";  

    return mail($toEmail, $subject, $message, $headers);
}
?>
