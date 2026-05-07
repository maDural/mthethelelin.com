<?php
session_start();
include 'includes/db.php';

// Protect page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user's medical record requests
$query = "SELECT * FROM medical_record_requests WHERE user_id = '$user_id' ORDER BY request_date DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Requests - Florida Medical Clinic</title>
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
            max-width: 1000px;
            margin: 50px auto;
            padding: 0 20px;
        }

        h2 {
            color: #2c3e50;
            margin-bottom: 20px;
        }

        .request-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-left: 4px solid #667eea;
        }

        .request-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }

        .request-id {
            font-weight: bold;
            color: #667eea;
        }

        .request-date {
            color: #666;
            font-size: 13px;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-processing {
            background: #cce5ff;
            color: #004085;
        }

        .status-completed {
            background: #d4edda;
            color: #155724;
        }

        .status-cancelled {
            background: #f8d7da;
            color: #721c24;
        }

        .request-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 12px;
            margin-bottom: 15px;
        }

        .detail-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
        }

        .detail-label {
            font-weight: 600;
            color: #555;
        }

        /* Message Box Styles */
        .admin-message-box {
            background: #d4edda;
            padding: 15px;
            border-radius: 8px;
            margin-top: 15px;
            border-left: 4px solid #28a745;
        }

        .admin-message-box .message-label {
            font-weight: 600;
            color: #155724;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .admin-message-box .message-text {
            color: #333;
            line-height: 1.6;
        }

        .admin-message-box .message-date {
            font-size: 11px;
            color: #666;
            margin-top: 8px;
        }

        .reply-box {
            background: #e8f4f8;
            padding: 15px;
            border-radius: 8px;
            margin-top: 15px;
            border-left: 3px solid #667eea;
        }

        .reply-box .reply-label {
            font-weight: 600;
            color: #004085;
            margin-bottom: 8px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Attachment Box Styles */
        .attachment-box {
            background: #e8f0fe;
            padding: 15px;
            border-radius: 8px;
            margin-top: 15px;
            border-left: 4px solid #4285f4;
        }

        .attachment-label {
            font-weight: 600;
            color: #4285f4;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .attachment-preview {
            margin-top: 10px;
        }

        .attachment-preview img {
            max-width: 100%;
            max-height: 200px;
            border-radius: 8px;
            margin-bottom: 10px;
            cursor: pointer;
            border: 1px solid #ddd;
        }

        .download-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #4285f4;
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .download-link:hover {
            background: #3367d6;
            transform: translateX(5px);
        }

        .no-requests {
            text-align: center;
            padding: 50px;
            background: white;
            border-radius: 12px;
        }

        .new-request-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 25px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 8px;
        }

        @media (max-width: 768px) {
            .request-details {
                grid-template-columns: 1fr;
            }
            
            .request-header {
                flex-direction: column;
                gap: 10px;
                align-items: flex-start;
            }
            
            .attachment-preview img {
                max-height: 150px;
            }
        }
    </style>
</head>
<body>

<div class="top-bar">
    <h2>📋 My Medical Record Requests</h2>
    <div>
        <a href="dashboard.php" class="back-btn">← Back</a>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</div>

<div class="container">
    <h2>Your Requests</h2>

    <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
            <?php 
            $status = $row['status'];
            $status_class = '';
            switch($status) {
                case 'processing': $status_class = 'status-processing'; break;
                case 'completed': $status_class = 'status-completed'; break;
                case 'cancelled': $status_class = 'status-cancelled'; break;
                default: $status_class = 'status-pending';
            }
            
            $record_types = [
                'full' => '📄 Complete Medical Records',
                'summary' => '📋 Medical Summary',
                'lab' => '🔬 Lab Results',
                'imaging' => '📷 Imaging Reports',
                'immunization' => '💉 Immunization Records',
                'prescription' => '💊 Prescription History'
            ];
            ?>
            <div class="request-card">
                <div class="request-header">
                    <div class="request-id">Request #<?php echo $row['id']; ?></div>
                    <div class="request-date">Submitted: <?php echo date('F d, Y', strtotime($row['request_date'])); ?></div>
                    <span class="status-badge <?php echo $status_class; ?>">
                        <?php echo ucfirst($status); ?>
                    </span>
                </div>
                
                <div class="request-details">
                    <div class="detail-item">
                        <span>📄</span>
                        <span class="detail-label">Record Type:</span>
                        <span><?php echo $record_types[$row['record_type']] ?? ucfirst($row['record_type']); ?></span>
                    </div>
                    <div class="detail-item">
                        <span>📅</span>
                        <span class="detail-label">Date Range:</span>
                        <span><?php echo $row['date_from'] ?? 'All records'; ?> - <?php echo $row['date_to'] ?? 'Present'; ?></span>
                    </div>
                    <div class="detail-item">
                        <span>📬</span>
                        <span class="detail-label">Delivery Method:</span>
                        <span><?php echo ucfirst($row['delivery_method']); ?></span>
                    </div>
                    <div class="detail-item">
                        <span>🎯</span>
                        <span class="detail-label">Purpose:</span>
                        <span><?php echo ucfirst(str_replace('_', ' ', $row['purpose'])); ?></span>
                    </div>
                </div>
                
                <!-- Admin Message Box - Personal message from admin -->
                <?php if (!empty($row['admin_message'])): ?>
                    <div class="admin-message-box">
                        <div class="message-label">
                            💬 Message from Admin:
                        </div>
                        <div class="message-text">
                            <?php echo nl2br(htmlspecialchars($row['admin_message'])); ?>
                        </div>
                        <?php if (!empty($row['message_sent_at'])): ?>
                            <div class="message-date">
                                Sent: <?php echo date('F d, Y h:i A', strtotime($row['message_sent_at'])); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                
                <!-- Admin Reply Box -->
                <?php if (!empty($row['admin_reply'])): ?>
                    <div class="reply-box">
                        <div class="reply-label">
                            ✏️ Admin Reply:
                        </div>
                        <div class="message-text">
                            <?php echo nl2br(htmlspecialchars($row['admin_reply'])); ?>
                        </div>
                    </div>
                <?php endif; ?>
                
                <!-- Attachment Box - Doctor's uploaded files -->
                <?php if (!empty($row['attachment']) && file_exists($row['attachment'])): ?>
                    <div class="attachment-box">
                        <div class="attachment-label">
                            📎 Doctor's Attachment:
                        </div>
                        <div class="attachment-preview">
                            <?php 
                            $file_ext = strtolower(pathinfo($row['attachment'], PATHINFO_EXTENSION));
                            $image_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'bmp'];
                            ?>
                            
                            <?php if (in_array($file_ext, $image_extensions)): ?>
                                <!-- Display image preview -->
                                <img src="<?php echo $row['attachment']; ?>" alt="Medical Document" onclick="window.open(this.src)">
                            <?php endif; ?>
                            
                            <!-- Download link -->
                            <a href="<?php echo $row['attachment']; ?>" download class="download-link">
                                <?php if (in_array($file_ext, $image_extensions)): ?>
                                    🖼️ Download Image
                                <?php elseif ($file_ext == 'pdf'): ?>
                                    📕 Download PDF
                                <?php elseif (in_array($file_ext, ['doc', 'docx'])): ?>
                                    📘 Download Document
                                <?php else: ?>
                                    📄 Download File
                                <?php endif; ?>
                                - <?php echo htmlspecialchars($row['attachment_name'] ?? 'Attachment'); ?>
                            </a>
                        </div>
                        <div style="font-size: 11px; color: #666; margin-top: 8px;">
                            Uploaded by doctor on <?php echo !empty($row['message_sent_at']) ? date('F d, Y', strtotime($row['message_sent_at'])) : date('F d, Y', strtotime($row['request_date'])); ?>
                        </div>
                    </div>
                <?php endif; ?>
                
                <!-- Status Message -->
                <?php if ($status == 'pending'): ?>
                    <div style="margin-top: 12px; font-size: 13px; color: #856404; background: #fff3cd; padding: 8px; border-radius: 5px;">
                        ⏳ Your request is pending review. We'll update you soon.
                    </div>
                <?php elseif ($status == 'processing'): ?>
                    <div style="margin-top: 12px; font-size: 13px; color: #004085; background: #cce5ff; padding: 8px; border-radius: 5px;">
                        🔄 Your request is being processed. You will receive a response shortly.
                    </div>
                <?php elseif ($status == 'completed'): ?>
                    <div style="margin-top: 12px; font-size: 13px; color: #155724; background: #d4edda; padding: 8px; border-radius: 5px;">
                        ✅ Your request has been completed. Your records have been sent via your selected delivery method.
                    </div>
                <?php elseif ($status == 'cancelled'): ?>
                    <div style="margin-top: 12px; font-size: 13px; color: #721c24; background: #f8d7da; padding: 8px; border-radius: 5px;">
                        ❌ This request has been cancelled. Please contact support if you have questions.
                    </div>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="no-requests">
            <p>📭 You haven't made any medical record requests yet.</p>
            <a href="request_medical_records.php" class="new-request-btn">+ Request Medical Records</a>
        </div>
    <?php endif; ?>

    <div style="text-align: center; margin-top: 20px;">
        <a href="request_medical_records.php" style="color: #667eea;">← Make a New Request</a>
    </div>
</div>

</body>
</html>