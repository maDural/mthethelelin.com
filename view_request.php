<?php
session_start();
include 'includes/db.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}

$request_id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : 0;

$query = "SELECT * FROM medical_record_requests WHERE id = '$request_id'";
$result = $conn->query($query);

if ($result->num_rows == 0) {
    header("Location: admin_medical_requests.php");
    exit();
}

$request = $result->fetch_assoc();

// Get user info
$user_query = "SELECT fullname, email FROM users WHERE id = '{$request['user_id']}'";
$user_result = $conn->query($user_query);
$user = $user_result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Request - Medical Records</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
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
        
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 0 20px;
        }
        
        .card {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .card h2 {
            color: #2c3e50;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #667eea;
        }
        
        .detail-row {
            display: flex;
            margin-bottom: 15px;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 8px;
        }
        
        .detail-label {
            width: 150px;
            font-weight: 600;
            color: #555;
        }
        
        .detail-value {
            flex: 1;
            color: #333;
        }
        
        .back-btn {
            background: #667eea;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
        }
        
        .status-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        
        .status-pending { background: #fff3cd; color: #856404; }
        .status-processing { background: #cce5ff; color: #004085; }
        .status-completed { background: #d4edda; color: #155724; }
    </style>
</head>
<body>

<div class="top-bar">
    <h1>📄 Medical Record Request Details</h1>
    <a href="admin_medical_requests.php" style="color: white;">← Back</a>
</div>

<div class="container">
    <div class="card">
        <h2>Request #<?php echo $request['id']; ?></h2>
        
        <div class="detail-row">
            <div class="detail-label">Patient Name:</div>
            <div class="detail-value"><?php echo htmlspecialchars($user['fullname'] ?? 'N/A'); ?></div>
        </div>
        
        <div class="detail-row">
            <div class="detail-label">Patient Email:</div>
            <div class="detail-value"><?php echo htmlspecialchars($user['email'] ?? 'N/A'); ?></div>
        </div>
        
        <div class="detail-row">
            <div class="detail-label">Record Type:</div>
            <div class="detail-value"><?php echo ucfirst($request['record_type']); ?></div>
        </div>
        
        <div class="detail-row">
            <div class="detail-label">Date Range:</div>
            <div class="detail-value"><?php echo $request['date_from'] ?? 'Start'; ?> to <?php echo $request['date_to'] ?? 'Present'; ?></div>
        </div>
        
        <div class="detail-row">
            <div class="detail-label">Delivery Method:</div>
            <div class="detail-value"><?php echo ucfirst($request['delivery_method']); ?></div>
        </div>
        
        <div class="detail-row">
            <div class="detail-label">Purpose:</div>
            <div class="detail-value"><?php echo ucfirst(str_replace('_', ' ', $request['purpose'])); ?></div>
        </div>
        
        <div class="detail-row">
            <div class="detail-label">Status:</div>
            <div class="detail-value">
                <span class="status-badge status-<?php echo $request['status']; ?>">
                    <?php echo ucfirst($request['status']); ?>
                </span>
            </div>
        </div>
        
        <div class="detail-row">
            <div class="detail-label">Request Date:</div>
            <div class="detail-value"><?php echo date('F d, Y h:i A', strtotime($request['request_date'])); ?></div>
        </div>
        
        <a href="admin_medical_requests.php" class="back-btn">← Back to Requests</a>
    </div>
</div>

</body>
</html>