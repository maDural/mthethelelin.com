<?php
session_start();
include 'includes/db.php';

// Protect page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_query = $conn->query("SELECT fullname, email FROM users WHERE id='$user_id'");
$user = $user_query->fetch_assoc();
$user_email = $user['email'];

// Fetch messages from this user
$query = "SELECT * FROM contact_messages WHERE email = '$user_email' ORDER BY created_at DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Messages - Florida Medical Clinic</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            background: #f0f2f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .top-bar {
            background: linear-gradient(135deg, #1a2980 0%, #26d0ce 100%);
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
        }

        .back-btn, .logout-btn {
            padding: 8px 20px;
            border-radius: 5px;
            text-decoration: none;
            color: white;
        }

        .back-btn {
            background: #667eea;
        }

        .logout-btn {
            background: #e74c3c;
            margin-left: 10px;
        }

        .container {
            max-width: 900px;
            margin: 50px auto;
            padding: 0 20px;
        }

        h2 {
            color: #2c3e50;
            margin-bottom: 20px;
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

        .message-subject {
            font-weight: bold;
            color: #2c3e50;
        }

        .message-date {
            color: #666;
            font-size: 12px;
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }

        .status-unread { background: #f8d7da; color: #721c24; }
        .status-read { background: #cce5ff; color: #004085; }
        .status-replied { background: #d4edda; color: #155724; }

        .message-content {
            padding: 20px;
        }

        .user-message {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .admin-reply {
            background: #e8f4f8;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #667eea;
        }

        .reply-label {
            font-weight: 600;
            color: #004085;
            margin-bottom: 8px;
        }

        .no-messages {
            text-align: center;
            padding: 50px;
            background: white;
            border-radius: 12px;
        }

        .new-message-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 25px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 8px;
        }

        @media (max-width: 768px) {
            .message-header {
                flex-direction: column;
                gap: 10px;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>

<div class="top-bar">
    <h2>📬 My Messages</h2>
    <div>
        <a href="dashboard.php" class="back-btn">← Back</a>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</div>

<div class="container">
    <h2>Your Conversation History</h2>

    <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="message-card">
                <div class="message-header">
                    <div class="message-subject">📋 <?php echo ucfirst(htmlspecialchars($row['subject'])); ?></div>
                    <div>
                        <span class="status-badge status-<?php echo $row['status']; ?>">
                            <?php echo ucfirst($row['status']); ?>
                        </span>
                        <span class="message-date">Sent: <?php echo date('M d, Y h:i A', strtotime($row['created_at'])); ?></span>
                    </div>
                </div>
                <div class="message-content">
                    <div class="user-message">
                        <strong>📝 Your Message:</strong>
                        <p style="margin-top: 8px;"><?php echo nl2br(htmlspecialchars($row['message'])); ?></p>
                    </div>
                    
                    <?php if ($row['admin_reply']): ?>
                        <div class="admin-reply">
                            <div class="reply-label">✏️ Admin Response:</div>
                            <p><?php echo nl2br(htmlspecialchars($row['admin_reply'])); ?></p>
                            <div style="margin-top: 10px; font-size: 12px; color: #28a745;">
                                ✅ Response received on <?php echo date('M d, Y', strtotime($row['updated_at'] ?? $row['created_at'])); ?>
                            </div>
                        </div>
                    <?php elseif ($row['status'] == 'unread'): ?>
                        <div style="background: #fff3cd; padding: 10px; border-radius: 8px; font-size: 13px;">
                            ⏳ Your message is pending review. We'll respond within 24 hours.
                        </div>
                    <?php elseif ($row['status'] == 'read'): ?>
                        <div style="background: #cce5ff; padding: 10px; border-radius: 8px; font-size: 13px;">
                            👀 Your message has been read. A response is being prepared.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="no-messages">
            <p>📭 You haven't sent any messages yet.</p>
            <a href="contact.php" class="new-message-btn">📧 Contact Us</a>
        </div>
    <?php endif; ?>
</div>

</body>
</html>