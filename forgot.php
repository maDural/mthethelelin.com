<?php
session_start();
include 'includes/db.php';

$error = '';
$success = '';

if (isset($_POST['forgot'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    
    // Check if email exists
    $query = "SELECT email FROM users WHERE email='$email'";
    $result = $conn->query($query);
    
    if ($result && $result->num_rows > 0) {
        // Set session variable with the email
        $_SESSION['reset_email'] = $email;
        
        // Redirect to reset password page
        header("Location: reset_password.php");
        exit();
    } else {
        $error = "Email not found in our records";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<div class="form-container" style="background-image: url('dash.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat;">
    
    <form method="POST" class="form-box">
        
        <h2>Forgot Password</h2>
        
        <?php if ($error): ?>
            <p style="color:red; text-align:center; background:white; padding:10px; border-radius:5px;">
                <?php echo $error; ?>
            </p>
        <?php endif; ?>
        
        <input type="email" name="email" placeholder="Enter your email" required>
        
        <button type="submit" name="forgot">Reset Password</button>
        
        <a href="login.php" class="btn-link">Back to Login</a>
        
    </form>
</div>

</body>
</html>