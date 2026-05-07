<?php
session_start();
include 'includes/db.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}

// Handle status update and message with file upload
if (isset($_POST['update_status'])) {
    $request_id = mysqli_real_escape_string($conn, $_POST['request_id']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $admin_reply = isset($_POST['admin_reply']) ? mysqli_real_escape_string($conn, $_POST['admin_reply']) : '';
    $admin_message = isset($_POST['admin_message']) ? mysqli_real_escape_string($conn, $_POST['admin_message']) : '';
    
    // Handle file upload
    $attachment_path = '';
    $attachment_type = '';
    $attachment_name = '';
    
    if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] == 0) {
        $upload_dir = 'uploads/medical_records/';
        
        // Create directory if not exists
        if (!file_exists($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        
        $file_name = time() . '_' . preg_replace('/[^a-zA-Z0-9._-]/', '', $_FILES['attachment']['name']);
        $file_tmp = $_FILES['attachment']['tmp_name'];
        $file_size = $_FILES['attachment']['size'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        
        // Allowed file types
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'txt'];
        
        if (in_array($file_ext, $allowed_ext) && $file_size <= 5000000) { // 5MB max
            $attachment_path = $upload_dir . $file_name;
            $attachment_type = $file_ext;
            $attachment_name = $_FILES['attachment']['name'];
            
            if (move_uploaded_file($file_tmp, $attachment_path)) {
                // File uploaded successfully
            } else {
                $error = "Failed to upload file.";
            }
        } else {
            $error = "Invalid file type or file too large. Allowed: JPG, PNG, GIF, PDF, DOC, TXT (Max 5MB)";
        }
    }
    
    // Build the update query
    $update_query = "UPDATE medical_record_requests SET status = '$status'";
    
    if (!empty($admin_reply)) {
        $update_query .= ", admin_reply = '$admin_reply'";
    }
    
    if (!empty($admin_message)) {
        $update_query .= ", admin_message = '$admin_message', message_sent_at = NOW()";
    }
    
    if (!empty($attachment_path)) {
        $update_query .= ", attachment = '$attachment_path', attachment_type = '$attachment_type', attachment_name = '$attachment_name'";
    }
    
    $update_query .= " WHERE id = '$request_id'";
    
    if ($conn->query($update_query)) {
        $success = "Request updated successfully!";
    } else {
        $error = "Error updating status: " . $conn->error;
    }
}

// Handle delete request with file removal
if (isset($_GET['delete'])) {
    $request_id = mysqli_real_escape_string($conn, $_GET['delete']);
    
    // Get attachment path to delete file
    $get_file = "SELECT attachment FROM medical_record_requests WHERE id = '$request_id'";
    $file_result = $conn->query($get_file);
    if ($file_result && $file_result->num_rows > 0) {
        $file_row = $file_result->fetch_assoc();
        if (!empty($file_row['attachment']) && file_exists($file_row['attachment'])) {
            unlink($file_row['attachment']); // Delete the file
        }
    }
    
    $delete_query = "DELETE FROM medical_record_requests WHERE id = '$request_id'";
    
    if ($conn->query($delete_query)) {
        $success = "Request deleted successfully!";
        header("refresh:1;url=admin_medical_requests.php");
    } else {
        $error = "Error deleting request: " . $conn->error;
    }
}

// Fetch all medical record requests
$query = "SELECT m.*, u.fullname as user_name, u.email as user_email 
          FROM medical_record_requests m 
          LEFT JOIN users u ON m.user_id = u.id 
          ORDER BY m.request_date DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Medical Record Requests - Admin Panel</title>
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

        .request-card {
            background: white;
            border-radius: 12px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .request-header {
            background: #f8f9fa;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            border-bottom: 1px solid #eee;
        }

        .request-info {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .request-info span {
            font-size: 13px;
            color: #666;
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-pending { background: #fff3cd; color: #856404; }
        .status-processing { background: #cce5ff; color: #004085; }
        .status-completed { background: #d4edda; color: #155724; }
        .status-cancelled { background: #f8d7da; color: #721c24; }

        .request-body {
            padding: 20px;
        }

        .detail-row {
            display: flex;
            margin-bottom: 10px;
            padding: 8px;
            background: #f8f9fa;
            border-radius: 8px;
            flex-wrap: wrap;
        }

        .detail-label {
            width: 130px;
            font-weight: 600;
            color: #555;
        }

        .detail-value {
            flex: 1;
            color: #333;
        }

        /* Attachment Styles */
        .attachment-box {
            background: #e8f0fe;
            padding: 15px;
            border-radius: 8px;
            margin-top: 15px;
            border-left: 4px solid #4285f4;
        }

        .attachment-link {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: #fff;
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
            color: #4285f4;
            margin-top: 10px;
            transition: all 0.3s ease;
        }

        .attachment-link:hover {
            background: #4285f4;
            color: white;
            transform: translateX(5px);
        }

        .reply-box {
            background: #e8f4f8;
            padding: 15px;
            border-radius: 8px;
            margin-top: 15px;
        }

        .reply-box strong {
            color: #004085;
        }

        .admin-message-box {
            background: #d4edda;
            padding: 15px;
            border-radius: 8px;
            margin-top: 15px;
            border-left: 4px solid #28a745;
        }

        .admin-message-box strong {
            color: #155724;
        }

        .form-inline {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin-top: 15px;
        }

        .form-row {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            align-items: center;
        }

        select, textarea, input[type="file"] {
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

        .message-label {
            font-weight: 600;
            margin-bottom: 5px;
            color: #2c3e50;
            font-size: 13px;
        }

        .file-info {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }

        .current-attachment {
            background: #f0f0f0;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        @media (max-width: 768px) {
            .request-header {
                flex-direction: column;
                gap: 10px;
            }
            
            .form-row {
                flex-direction: column;
            }
            
            .detail-row {
                flex-direction: column;
            }
            
            .detail-label {
                width: 100%;
                margin-bottom: 5px;
            }
        }
    </style>
</head>
<body>
    <div class="top-bar">
        <h1>📋 Medical Record Requests</h1>
        <div class="nav-links">
            <a href="admin_dashboard.php">Appointments</a>
            <a href="admin_medical_requests.php" style="background: rgba(255,255,255,0.2);">Medical Records</a>
            <a href="admin_feedback.php">Feedback</a>
            <a href="admin_contact_messages.php">Messages</a>
            <a href="admin_logout.php" class="logout-btn">Logout</a>
        </div>
    </div>

    <div class="container">
        <?php if (isset($success)): ?>
            <div class="success">✅ <?php echo $success; ?></div>
        <?php endif; ?>

        <?php if (isset($error)): ?>
            <div class="error">❌ <?php echo $error; ?></div>
        <?php endif; ?>

        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="request-card">
                    <div class="request-header">
                        <div class="request-info">
                            <span><strong>#<?php echo $row['id']; ?></strong></span>
                            <span>👤 <?php echo htmlspecialchars($row['user_name'] ?? 'Guest'); ?></span>
                            <span>📧 <?php echo htmlspecialchars($row['user_email'] ?? 'N/A'); ?></span>
                            <span>🕒 <?php echo date('M d, Y h:i A', strtotime($row['request_date'])); ?></span>
                        </div>
                        <span class="status-badge status-<?php echo $row['status']; ?>">
                            <?php echo ucfirst($row['status']); ?>
                        </span>
                    </div>
                    <div class="request-body">
                        <div class="detail-row">
                            <div class="detail-label">Record Type:</div>
                            <div class="detail-value">
                                <?php 
                                $types = [
                                    'full' => 'Complete Records',
                                    'summary' => 'Medical Summary',
                                    'lab' => 'Lab Results',
                                    'imaging' => 'Imaging Reports',
                                    'immunization' => 'Immunization Records',
                                    'prescription' => 'Prescription History'
                                ];
                                echo $types[$row['record_type']] ?? ucfirst($row['record_type']);
                                ?>
                            </div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Date Range:</div>
                            <div class="detail-value"><?php echo $row['date_from'] ?? 'All'; ?> to <?php echo $row['date_to'] ?? 'Present'; ?></div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Delivery Method:</div>
                            <div class="detail-value"><?php echo ucfirst($row['delivery_method']); ?></div>
                        </div>
                        <div class="detail-row">
                            <div class="detail-label">Purpose:</div>
                            <div class="detail-value"><?php echo ucfirst(str_replace('_', ' ', $row['purpose'])); ?></div>
                        </div>
                        
                        <!-- Display current attachment if exists -->
                        <?php if (!empty($row['attachment'])): ?>
                            <div class="attachment-box">
                                <strong>📎 Current Attachment:</strong>
                                <div>
                                    <a href="<?php echo $row['attachment']; ?>" target="_blank" class="attachment-link">
                                        <?php if (in_array($row['attachment_type'], ['jpg', 'jpeg', 'png', 'gif'])): ?>
                                            🖼️ View Image
                                        <?php else: ?>
                                            📄 Download File
                                        <?php endif; ?>
                                        - <?php echo htmlspecialchars($row['attachment_name'] ?? 'Document'); ?>
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($row['admin_reply'])): ?>
                            <div class="reply-box">
                                <strong>✏️ Admin Reply:</strong>
                                <p style="margin-top: 8px;"><?php echo nl2br(htmlspecialchars($row['admin_reply'])); ?></p>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (!empty($row['admin_message'])): ?>
                            <div class="admin-message-box">
                                <strong>📨 Message to Patient:</strong>
                                <p style="margin-top: 8px;"><?php echo nl2br(htmlspecialchars($row['admin_message'])); ?></p>
                                <?php if (!empty($row['message_sent_at'])): ?>
                                    <small style="color: #666;">Sent on: <?php echo date('M d, Y h:i A', strtotime($row['message_sent_at'])); ?></small>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        
                        <form method="POST" class="form-inline" enctype="multipart/form-data">
                            <input type="hidden" name="request_id" value="<?php echo $row['id']; ?>">
                            
                            <div class="form-row">
                                <select name="status">
                                    <option value="pending" <?php echo ($row['status'] ?? 'pending') == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                    <option value="processing" <?php echo ($row['status'] ?? '') == 'processing' ? 'selected' : ''; ?>>Processing</option>
                                    <option value="completed" <?php echo ($row['status'] ?? '') == 'completed' ? 'selected' : ''; ?>>Completed</option>
                                    <option value="cancelled" <?php echo ($row['status'] ?? '') == 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                </select>
                                <button type="submit" name="update_status" class="update-btn">Update Status</button>
                            </div>
                            
                            <div>
                                <div class="message-label">📝 Reply to Request (Optional):</div>
                                <textarea name="admin_reply" placeholder="Add a reply about the request..."><?php echo htmlspecialchars($row['admin_reply'] ?? ''); ?></textarea>
                            </div>
                            
                            <div>
                                <div class="message-label">💬 Message to Patient (Optional):</div>
                                <textarea name="admin_message" placeholder="Send a personal message to the patient..."><?php echo htmlspecialchars($row['admin_message'] ?? ''); ?></textarea>
                            </div>
                            
                            <div>
                                <div class="message-label">📎 Upload Attachment (Optional):</div>
                                <input type="file" name="attachment" accept="image/*,.pdf,.doc,.docx,.txt">
                                <div class="file-info">Allowed: Images, PDF, DOC, TXT (Max 5MB)</div>
                            </div>
                            
                            <div class="form-row">
                                <button type="submit" name="update_status" class="update-btn">Save All Changes</button>
                                <a href="?delete=<?php echo $row['id']; ?>" class="delete-btn" onclick="return confirm('Delete this request? This will also delete any attached files.')">Delete Request</a>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div style="text-align: center; padding: 50px; background: white; border-radius: 12px;">
                <p>📭 No medical record requests found.</p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>