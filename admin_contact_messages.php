<?php
session_start();
include 'includes/db.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}

// Function to send email reply
function sendReplyEmail($to_email, $to_name, $subject, $reply_message, $original_message) {
    $email_subject = "Re: " . $subject;
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: Florida Medical Clinic <info@floridamedical.com>" . "\r\n";
    
    $email_body = "
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px; text-align: center; }
            .content { padding: 20px; background: #f8f9fa; }
            .reply-box { background: #e8f4f8; padding: 15px; border-left: 4px solid #667eea; margin: 15px 0; }
            .footer { text-align: center; padding: 15px; font-size: 12px; color: #666; }
            button { background: #667eea; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h2>Florida Medical Clinic</h2>
            </div>
            <div class='content'>
                <p>Dear <strong>$to_name</strong>,</p>
                <p>Thank you for contacting Florida Medical Clinic. We have reviewed your message and here is our response:</p>
                
                <div class='reply-box'>
                    <strong>📋 Admin Response:</strong>
                    <p style='margin-top: 10px;'>$reply_message</p>
                </div>
                
                <div class='reply-box' style='background: #f0f0f0;'>
                    <strong>📝 Your Original Message:</strong>
                    <p style='margin-top: 10px;'>$original_message</p>
                </div>
                
                <p>If you have any further questions, please don't hesitate to contact us.</p>
                <p>Best regards,<br><strong>Florida Medical Clinic Team</strong></p>
            </div>
            <div class='footer'>
                <p>123 Medical Drive, Florida, FL 33101 | (555) 123-4567 | info@floridamedical.com</p>
            </div>
        </div>
    </body>
    </html>
    ";
    
    return mail($to_email, $email_subject, $email_body, $headers);
}

// Handle status update and reply
if (isset($_POST['update_status'])) {
    $message_id = mysqli_real_escape_string($conn, $_POST['message_id']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $admin_reply = mysqli_real_escape_string($conn, $_POST['admin_reply']);
    
    // Get the message details for email
    $get_message = "SELECT fullname, email, subject, message FROM contact_messages WHERE id = '$message_id'";
    $msg_result = $conn->query($get_message);
    $msg = $msg_result->fetch_assoc();
    
    $update_query = "UPDATE contact_messages SET status = '$status', admin_reply = '$admin_reply' WHERE id = '$message_id'";
    
    if ($conn->query($update_query)) {
        // Send email notification if admin replied
        if (!empty($admin_reply)) {
            $email_sent = sendReplyEmail($msg['email'], $msg['fullname'], $msg['subject'], $admin_reply, $msg['message']);
            if ($email_sent) {
                $success = "Reply sent! Email notification sent to " . $msg['email'];
            } else {
                $success = "Reply saved but email could not be sent. Check your mail server settings.";
            }
        } else {
            $success = "Status updated successfully!";
        }
    } else {
        $error = "Error updating status: " . $conn->error;
    }
}

// Handle delete
if (isset($_GET['delete'])) {
    $message_id = mysqli_real_escape_string($conn, $_GET['delete']);
    $delete_query = "DELETE FROM contact_messages WHERE id = '$message_id'";
    
    if ($conn->query($delete_query)) {
        $success = "Message deleted successfully!";
        header("refresh:1;url=admin_contact_messages.php");
    } else {
        $error = "Error deleting message: " . $conn->error;
    }
}

// Fetch all contact messages
$query = "SELECT * FROM contact_messages ORDER BY created_at DESC";
$result = $conn->query($query);

// Calculate statistics
$total_query = "SELECT COUNT(*) as total FROM contact_messages";
$total_result = $conn->query($total_query);
$total = $total_result->fetch_assoc()['total'];

$unread_query = "SELECT COUNT(*) as unread FROM contact_messages WHERE status = 'unread'";
$unread_result = $conn->query($unread_query);
$unread = $unread_result->fetch_assoc()['unread'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Contact Messages - Admin Panel</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f0f2f5;
        }

        .top-bar {
            background: linear-gradient(135deg, #1a2980 0%, #26d0ce 100%);
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .top-bar h1 {
            font-size: 24px;
        }

        .nav-links a {
            color: white;
            text-decoration: none;
            margin-left: 15px;
            padding: 8px 15px;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .nav-links a:hover {
            background: rgba(255,255,255,0.2);
        }

        .logout-btn {
            background: #e74c3c;
        }

        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .stat-number {
            font-size: 32px;
            font-weight: bold;
            color: #667eea;
        }

        .stat-number.unread {
            color: #e74c3c;
        }

        .stat-label {
            color: #666;
            margin-top: 5px;
        }

        .success {
            background: #d4edda;
            color: #155724;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
        }

        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
        }

        .message-card {
            background: white;
            border-radius: 12px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .message-header {
            background: #f8f9fa;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            border-bottom: 1px solid #eee;
        }

        .message-info {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .message-info span {
            font-size: 13px;
            color: #666;
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-unread {
            background: #f8d7da;
            color: #721c24;
        }

        .status-read {
            background: #cce5ff;
            color: #004085;
        }

        .status-replied {
            background: #d4edda;
            color: #155724;
        }

        .message-body {
            padding: 20px;
        }

        .message-content {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin: 10px 0;
        }

        .reply-box {
            background: #e8f4f8;
            padding: 15px;
            border-radius: 8px;
            margin-top: 15px;
        }

        .form-inline {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            margin-top: 15px;
        }

        select, textarea {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        textarea {
            flex: 1;
            min-width: 200px;
            resize: vertical;
        }

        .update-btn {
            background: #667eea;
            color: white;
            border: none;
            padding: 8px 20px;
            border-radius: 5px;
            cursor: pointer;
        }

        .delete-btn {
            background: #dc3545;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }

        .email-note {
            font-size: 11px;
            color: #28a745;
            margin-top: 5px;
        }

        @media (max-width: 768px) {
            .message-header {
                flex-direction: column;
                gap: 10px;
            }
            
            .form-inline {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="top-bar">
        <h1>✉️ Contact Messages</h1>
        <div class="nav-links">
            <a href="admin_dashboard.php">Appointments</a>
            <a href="admin_medical_requests.php">Medical Records</a>
            <a href="admin_feedback.php">Feedback</a>
            <a href="admin_contact_messages.php" style="background: rgba(255,255,255,0.2);">Messages</a>
            <a href="admin_logout.php" class="logout-btn">Logout</a>
        </div>
    </div>

    <div class="container">
        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-number"><?php echo $total; ?></div>
                <div class="stat-label">Total Messages</div>
            </div>
            <div class="stat-card">
                <div class="stat-number unread"><?php echo $unread; ?></div>
                <div class="stat-label">Unread Messages</div>
            </div>
        </div>

        <?php if (isset($success)): ?>
            <div class="success">✅ <?php echo $success; ?></div>
        <?php endif; ?>

        <?php if (isset($error)): ?>
            <div class="error">❌ <?php echo $error; ?></div>
        <?php endif; ?>

        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="message-card">
                    <div class="message-header">
                        <div class="message-info">
                            <span><strong>#<?php echo $row['id']; ?></strong></span>
                            <span>👤 <?php echo htmlspecialchars($row['fullname']); ?></span>
                            <span>📧 <?php echo htmlspecialchars($row['email']); ?></span>
                            <?php if ($row['phone']): ?>
                                <span>📞 <?php echo htmlspecialchars($row['phone']); ?></span>
                            <?php endif; ?>
                            <span>📅 <?php echo date('M d, Y h:i A', strtotime($row['created_at'])); ?></span>
                        </div>
                        <span class="status-badge status-<?php echo $row['status']; ?>">
                            <?php echo ucfirst($row['status']); ?>
                        </span>
                    </div>
                    <div class="message-body">
                        <div class="message-content">
                            <strong>📋 Subject: <?php echo ucfirst(htmlspecialchars($row['subject'])); ?></strong>
                            <p style="margin-top: 10px;"><?php echo nl2br(htmlspecialchars($row['message'])); ?></p>
                        </div>
                        
                        <?php if ($row['admin_reply']): ?>
                            <div class="reply-box">
                                <strong>✏️ Admin Reply (Sent to patient):</strong>
                                <p style="margin-top: 8px;"><?php echo nl2br(htmlspecialchars($row['admin_reply'])); ?></p>
                                <div class="email-note">📧 An email notification was sent to the patient</div>
                            </div>
                        <?php endif; ?>
                        
                        <form method="POST" class="form-inline">
                            <input type="hidden" name="message_id" value="<?php echo $row['id']; ?>">
                            <select name="status">
                                <option value="unread" <?php echo $row['status'] == 'unread' ? 'selected' : ''; ?>>Unread</option>
                                <option value="read" <?php echo $row['status'] == 'read' ? 'selected' : ''; ?>>Read</option>
                                <option value="replied" <?php echo $row['status'] == 'replied' ? 'selected' : ''; ?>>Replied</option>
                                <option value="archived" <?php echo $row['status'] == 'archived' ? 'selected' : ''; ?>>Archived</option>
                            </select>
                            <textarea name="admin_reply" placeholder="Type your reply here... The patient will receive this via email"><?php echo htmlspecialchars($row['admin_reply'] ?? ''); ?></textarea>
                            <button type="submit" name="update_status" class="update-btn">Reply & Send Email</button>
                            <a href="?delete=<?php echo $row['id']; ?>" class="delete-btn" onclick="return confirm('Delete this message?')">Delete</a>
                        </form>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div style="text-align: center; padding: 50px; background: white; border-radius: 12px;">
                <p>📭 No contact messages yet.</p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>