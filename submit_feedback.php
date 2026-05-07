<?php
session_start();
include 'includes/db.php';

$success = '';
$error = '';

// Check if user is logged in
$is_logged_in = isset($_SESSION['user_id']);
$user_name = '';
$user_email = '';

if ($is_logged_in) {
    $user_id = $_SESSION['user_id'];
    $user_query = $conn->query("SELECT fullname, email FROM users WHERE id='$user_id'");
    if ($user_query && $user_query->num_rows > 0) {
        $user = $user_query->fetch_assoc();
        $user_name = $user['fullname'];
        $user_email = $user['email'];
    }
}

if (isset($_POST['submit_feedback'])) {
    // Get user_id (can be NULL for guests)
    $user_id = isset($_SESSION['user_id']) && $_SESSION['user_id'] ? $_SESSION['user_id'] : NULL;
    
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $feedback_type = mysqli_real_escape_string($conn, $_POST['feedback_type']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    
    // For guests, user_id will be NULL
    if ($user_id === NULL || $user_id === '') {
        $query = "INSERT INTO feedback (user_id, fullname, email, phone, feedback_type, message, status, created_at) 
                  VALUES (NULL, '$fullname', '$email', '$phone', '$feedback_type', '$message', 'pending', NOW())";
    } else {
        $query = "INSERT INTO feedback (user_id, fullname, email, phone, feedback_type, message, status, created_at) 
                  VALUES ('$user_id', '$fullname', '$email', '$phone', '$feedback_type', '$message', 'pending', NOW())";
    }
    
    if ($conn->query($query)) {
        $success = "✅ Thank you for your feedback! We will review it and respond within 2-3 business days.";
        // Clear form after success
        $_POST = array();
        // Reset form values for guests
        $fullname = '';
        $email = '';
        $phone = '';
    } else {
        $error = "❌ Error submitting feedback: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Submit Feedback - Florida Medical Clinic</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }

        .top-bar {
            background: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .top-bar h2 {
            color: #2c3e50;
        }

        .back-btn, .logout-btn {
            padding: 8px 20px;
            border-radius: 5px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .back-btn {
            background: #667eea;
            color: white;
        }

        .logout-btn {
            background: #e74c3c;
            color: white;
            margin-left: 10px;
        }

        .container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 70px);
            padding: 40px 20px;
        }

        .form-box {
            background: white;
            border-radius: 16px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            width: 100%;
            max-width: 550px;
            overflow: hidden;
        }

        .form-inner {
            padding: 35px;
        }

        h2 {
            text-align: center;
            color: #2c3e50;
            font-size: 24px;
            margin-bottom: 8px;
        }

        .subtitle {
            text-align: center;
            color: #666;
            margin-bottom: 25px;
            font-size: 13px;
        }

        .welcome {
            text-align: center;
            color: #667eea;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .success {
            background: #d4edda;
            color: #155724;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 13px;
        }

        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 13px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 6px;
            font-size: 13px;
        }

        .required {
            color: #e74c3c;
        }

        select, input, textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            transition: all 0.3s ease;
        }

        select:focus, input:focus, textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 2px rgba(102, 126, 234, 0.1);
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }

        button {
            width: 100%;
            padding: 12px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .info-note {
            background: #f8f9fa;
            padding: 12px;
            border-radius: 8px;
            margin-top: 20px;
            font-size: 12px;
            color: #666;
            text-align: center;
        }

        @media (max-width: 550px) {
            .form-inner {
                padding: 25px;
            }
        }
    </style>
</head>
<body>

<div class="top-bar">
    <h2>📝 Feedback & Assistance</h2>
    <div>
        <a href="index.php" class="back-btn">← Home</a>
        <?php if ($is_logged_in): ?>
            <a href="dashboard.php" class="back-btn">Dashboard</a>
            <a href="logout.php" class="logout-btn">Logout</a>
        <?php endif; ?>
    </div>
</div>

<div class="container">
    <div class="form-box">
        <div class="form-inner">
            <h2>We Value Your Feedback</h2>
            <div class="subtitle">Your voice helps us improve our services</div>
            
            <?php if ($is_logged_in): ?>
                <div class="welcome">Welcome back, <?php echo htmlspecialchars($user_name); ?>!</div>
            <?php else: ?>
                <div class="welcome">You are submitting as a guest</div>
            <?php endif; ?>

            <?php if ($success): ?>
                <div class="success"><?php echo $success; ?></div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label>Full Name <span class="required">*</span></label>
                    <input type="text" name="fullname" value="<?php echo isset($_POST['fullname']) ? htmlspecialchars($_POST['fullname']) : htmlspecialchars($user_name); ?>" required>
                </div>

                <div class="form-group">
                    <label>Email Address <span class="required">*</span></label>
                    <input type="email" name="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : htmlspecialchars($user_email); ?>" required>
                </div>

                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="tel" name="phone" value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>" placeholder="(555) 123-4567">
                </div>

                <div class="form-group">
                    <label>Feedback Type <span class="required">*</span></label>
                    <select name="feedback_type" required>
                        <option value="general">General Feedback</option>
                        <option value="accessibility">Accessibility Issue</option>
                        <option value="suggestion">Suggestion</option>
                        <option value="complaint">Complaint</option>
                        <option value="assistance">Request Assistance</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Message <span class="required">*</span></label>
                    <textarea name="message" placeholder="Please describe your feedback, issue, or request in detail..." required><?php echo isset($_POST['message']) ? htmlspecialchars($_POST['message']) : ''; ?></textarea>
                </div>

                <button type="submit" name="submit_feedback">📤 Submit Feedback</button>

                <div class="info-note">
                    <strong>📌 What happens next?</strong><br>
                    We review all feedback within 2-3 business days. You may be contacted if we need clarification.
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>