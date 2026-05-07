<?php
session_start();
include 'includes/db.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}

// Handle status update
if (isset($_POST['update_status'])) {
    $feedback_id = mysqli_real_escape_string($conn, $_POST['feedback_id']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $admin_reply = mysqli_real_escape_string($conn, $_POST['admin_reply']);
    
    $query = "UPDATE feedback SET status = '$status', admin_reply = '$admin_reply' WHERE id = '$feedback_id'";
    
    if ($conn->query($query)) {
        $success = "Feedback status updated successfully!";
    } else {
        $error = "Error updating status: " . $conn->error;
    }
}

// Handle delete
if (isset($_GET['delete'])) {
    $feedback_id = mysqli_real_escape_string($conn, $_GET['delete']);
    $delete_query = "DELETE FROM feedback WHERE id = '$feedback_id'";
    
    if ($conn->query($delete_query)) {
        $success = "Feedback deleted successfully!";
        header("refresh:1;url=admin_feedback.php");
    } else {
        $error = "Error deleting feedback: " . $conn->error;
    }
}

// Fetch all feedback
$query = "SELECT * FROM feedback ORDER BY created_at DESC";
$result = $conn->query($query);

// Calculate statistics
$total_query = "SELECT COUNT(*) as total FROM feedback";
$total_result = $conn->query($total_query);
$total = $total_result->fetch_assoc()['total'];

$pending_query = "SELECT COUNT(*) as pending FROM feedback WHERE status = 'pending'";
$pending_result = $conn->query($pending_query);
$pending = $pending_result->fetch_assoc()['pending'];

$replied_query = "SELECT COUNT(*) as replied FROM feedback WHERE status = 'replied'";
$replied_result = $conn->query($replied_query);
$replied = $replied_result->fetch_assoc()['replied'];

$resolved_query = "SELECT COUNT(*) as resolved FROM feedback WHERE status = 'resolved'";
$resolved_result = $conn->query($resolved_query);
$resolved = $resolved_result->fetch_assoc()['resolved'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Feedback - Florida Medical Clinic</title>
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
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
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

        .stat-label {
            color: #666;
            margin-top: 5px;
            font-size: 14px;
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

        .feedback-card {
            background: white;
            border-radius: 12px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .feedback-header {
            background: #f8f9fa;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            border-bottom: 1px solid #eee;
        }

        .feedback-info {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .feedback-info span {
            font-size: 13px;
            color: #666;
        }

        .feedback-type {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .type-accessibility { background: #cce5ff; color: #004085; }
        .type-general { background: #e2e3e5; color: #383d41; }
        .type-suggestion { background: #d4edda; color: #155724; }
        .type-complaint { background: #f8d7da; color: #721c24; }
        .type-assistance { background: #fff3cd; color: #856404; }

        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-pending { background: #fff3cd; color: #856404; }
        .status-read { background: #cce5ff; color: #004085; }
        .status-replied { background: #d4edda; color: #155724; }
        .status-resolved { background: #c3e6cb; color: #155724; }

        .feedback-body {
            padding: 20px;
        }

        .message-box {
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
        }

        .update-btn {
            background: #667eea;
            color: white;
            border: none;
            padding: 8px 15px;
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

        @media (max-width: 768px) {
            .feedback-header {
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
        <h1>📝 Feedback Management</h1>
        <div class="nav-links">
            <a href="admin_dashboard.php">Appointments</a>
            <a href="admin_medical_requests.php">Medical Records</a>
            <a href="admin_feedback.php" style="background: rgba(255,255,255,0.2);">Feedback</a>
            <a href="admin_logout.php" class="logout-btn">Logout</a>
        </div>
    </div>

    <div class="container">
        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-number"><?php echo $total; ?></div>
                <div class="stat-label">Total Feedback</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" style="color: #856404;"><?php echo $pending; ?></div>
                <div class="stat-label">Pending Review</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" style="color: #004085;"><?php echo $replied; ?></div>
                <div class="stat-label">Replied</div>
            </div>
            <div class="stat-card">
                <div class="stat-number" style="color: #155724;"><?php echo $resolved; ?></div>
                <div class="stat-label">Resolved</div>
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
                <?php 
                $type_class = '';
                switch($row['feedback_type']) {
                    case 'accessibility': $type_class = 'type-accessibility'; break;
                    case 'general': $type_class = 'type-general'; break;
                    case 'suggestion': $type_class = 'type-suggestion'; break;
                    case 'complaint': $type_class = 'type-complaint'; break;
                    case 'assistance': $type_class = 'type-assistance'; break;
                }
                ?>
                <div class="feedback-card">
                    <div class="feedback-header">
                        <div class="feedback-info">
                            <span><strong>#<?php echo $row['id']; ?></strong></span>
                            <span>👤 <?php echo htmlspecialchars($row['fullname']); ?></span>
                            <span>📧 <?php echo htmlspecialchars($row['email']); ?></span>
                            <?php if ($row['phone']): ?>
                                <span>📞 <?php echo htmlspecialchars($row['phone']); ?></span>
                            <?php endif; ?>
                            <span>🕒 <?php echo date('M d, Y h:i A', strtotime($row['created_at'])); ?></span>
                        </div>
                        <div>
                            <span class="feedback-type <?php echo $type_class; ?>"><?php echo ucfirst($row['feedback_type']); ?></span>
                            <span class="status-badge status-<?php echo $row['status']; ?>"><?php echo ucfirst($row['status']); ?></span>
                        </div>
                    </div>
                    <div class="feedback-body">
                        <div class="message-box">
                            <strong>💬 Message:</strong>
                            <p style="margin-top: 8px;"><?php echo nl2br(htmlspecialchars($row['message'])); ?></p>
                        </div>
                        
                        <?php if ($row['admin_reply']): ?>
                            <div class="reply-box">
                                <strong>✏️ Admin Reply:</strong>
                                <p style="margin-top: 8px;"><?php echo nl2br(htmlspecialchars($row['admin_reply'])); ?></p>
                            </div>
                        <?php endif; ?>
                        
                        <form method="POST" class="form-inline">
                            <input type="hidden" name="feedback_id" value="<?php echo $row['id']; ?>">
                            <select name="status">
                                <option value="pending" <?php echo $row['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                <option value="read" <?php echo $row['status'] == 'read' ? 'selected' : ''; ?>>Read</option>
                                <option value="replied" <?php echo $row['status'] == 'replied' ? 'selected' : ''; ?>>Replied</option>
                                <option value="resolved" <?php echo $row['status'] == 'resolved' ? 'selected' : ''; ?>>Resolved</option>
                            </select>
                            <textarea name="admin_reply" placeholder="Add a reply to this feedback..."><?php echo htmlspecialchars($row['admin_reply'] ?? ''); ?></textarea>
                            <button type="submit" name="update_status" class="update-btn">Update</button>
                            <a href="?delete=<?php echo $row['id']; ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this feedback?')">Delete</a>
                        </form>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div style="text-align: center; padding: 50px; background: white; border-radius: 12px;">
                <p>📭 No feedback submissions yet.</p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>