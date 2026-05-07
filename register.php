<?php
include 'includes/db.php';

// Check if email already exists
if (isset($_POST['register'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    
    // Check if email already registered
    $check_email = "SELECT email FROM users WHERE email = '$email'";
    $result = $conn->query($check_email);
    
    if ($result->num_rows > 0) {
        $error = "Email already registered!";
    } else {
        $query = "INSERT INTO users (fullname, email, password) VALUES ('$name', '$email', '$password')";
        
        if ($conn->query($query)) {
            header("Location: login.php");
            exit();
        } else {
            $error = "Registration failed: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<div class="form-container" style="background-image: url('booking.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat;">
    
    <?php if(isset($error)): ?>
        <p style="color:red; text-align:center; background:white; padding:10px; border-radius:5px;">
            <?php echo $error; ?>
        </p>
    <?php endif; ?>
    
    <form method="POST" class="form-box">
        <h2>Create Account</h2>
        
        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        
        <button type="submit" name="register">Register</button>
        
        <a href="login.php" class="btn-link">Already have an account? Login</a>
        <a href="index.php" class="home-btn">Home</a>
        
    </form>
</div>

</body>
</html>