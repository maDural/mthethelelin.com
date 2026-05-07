<?php
session_start();
include 'includes/db.php';

// If reset_email is not set, redirect to forgot password page
if (!isset($_SESSION['reset_email'])) {
    header("Location: forgot.php");
    exit();
}

$error = '';
$success = '';

if (isset($_POST['reset'])) {
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validate password
    if (empty($password)) {
        $error = "Please enter a password";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $email = mysqli_real_escape_string($conn, $_SESSION['reset_email']);
        
        // Update password in database
        $query = "UPDATE users SET password='$hashed_password' WHERE email='$email'";
        
        if ($conn->query($query)) {
            // Check if any row was affected
            if ($conn->affected_rows > 0) {
                $success = "Password updated successfully! Redirecting to login...";
                // Clear the session variable
                unset($_SESSION['reset_email']);
                // Redirect after 2 seconds
                header("refresh:2;url=login.php");
            } else {
                $error = "User not found. Please request a new password reset.";
                unset($_SESSION['reset_email']);
                header("refresh:2;url=forgot.php");
            }
        } else {
            $error = "Failed to update password: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .error-message {
            color: red;
            text-align: center;
            background: #ffe6e6;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            border: 1px solid #ff9999;
        }
        
        .success-message {
            color: green;
            text-align: center;
            background: #e6ffe6;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
            border: 1px solid #99cc99;
        }
    </style>
</head>

<body>

<div class="form-container" style="background-image: url('sign.webp'); background-size: cover; background-position: center; background-repeat: no-repeat;">
    
    <form method="POST" class="form-box">
        
        <h2>Reset Password</h2>
        
        <?php if ($error): ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="success-message"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <input type="password" name="password" placeholder="New Password" required>
        <input type="password" name="confirm_password" placeholder="Confirm New Password" required>
        
        <button type="submit" name="reset">Update Password</button>
        
        <a href="login.php" class="btn-link">Back to Login</a>
        
    </form>
</div>

</body>
</html>