<?php
session_start();
include 'includes/db.php';

$is_logged_in = isset($_SESSION['user_id']);
$success_message = '';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['request_records'])) {
    if ($is_logged_in) {
        $user_id = $_SESSION['user_id'];
        $record_type = mysqli_real_escape_string($conn, $_POST['record_type']);
        $date_from = mysqli_real_escape_string($conn, $_POST['date_from']);
        $date_to = mysqli_real_escape_string($conn, $_POST['date_to']);
        $delivery_method = mysqli_real_escape_string($conn, $_POST['delivery_method']);
        $purpose = mysqli_real_escape_string($conn, $_POST['purpose']);
        
        $query = "INSERT INTO medical_record_requests (user_id, record_type, date_from, date_to, delivery_method, purpose, status, request_date) 
                  VALUES ('$user_id', '$record_type', '$date_from', '$date_to', '$delivery_method', '$purpose', 'pending', NOW())";
        
        if ($conn->query($query)) {
            $success_message = "Your request has been submitted. You will receive your records within 7-14 business days.";
        } else {
            $error_message = "Something went wrong. Please try again.";
        }
    } else {
        header("Location: login.php");
        exit();
    }
}

include 'includes/header.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Medical Records - Florida Medical Clinic</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .records-hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-align: center;
            padding: 80px 20px;
            margin-bottom: 50px;
        }
        
        .records-hero h1 {
            font-size: 48px;
            margin-bottom: 20px;
            animation: fadeInDown 1s ease;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .records-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-bottom: 60px;
        }
        
        .request-form {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        
        .request-form h2 {
            color: #2c3e50;
            margin-bottom: 10px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: #2c3e50;
        }
        
        .form-group input, .form-group select, .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
        }
        
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        
        .submit-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 14px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
        }
        
        .info-card {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 25px;
        }
        
        .info-card h3 {
            color: #2c3e50;
            margin-bottom: 15px;
        }
        
        .info-list {
            list-style: none;
            padding: 0;
        }
        
        .info-list li {
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
            display: flex;
            align-items: center;
        }
        
        .info-list li:before {
            content: "📄";
            margin-right: 10px;
        }
        
        .success-message {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        .error-message {
            background: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        @media (max-width: 768px) {
            .records-grid { grid-template-columns: 1fr; }
            .form-row { grid-template-columns: 1fr; gap: 0; }
        }
        
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-30px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<div class="records-hero">
    <h1>Medical Records</h1>
    <p>Request and access your health information securely</p>
</div>

<div class="container">
    <div class="records-grid">
        <div class="request-form">
            <h2>Request Medical Records</h2>
            <p style="color: #666; margin-bottom: 20px;">Fill out the form below to request your records</p>
            
            <?php if ($success_message): ?>
                <div class="success-message"><?php echo $success_message; ?></div>
            <?php endif; ?>
            
            <?php if ($error_message): ?>
                <div class="error-message"><?php echo $error_message; ?></div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-group">
                    <label>Type of Records *</label>
                    <select name="record_type" required>
                        <option value="full">Complete Medical Records</option>
                        <option value="summary">Medical Summary</option>
                        <option value="lab">Lab Results</option>
                        <option value="imaging">Imaging Reports</option>
                        <option value="immunization">Immunization Records</option>
                        <option value="prescription">Prescription History</option>
                    </select>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Date From</label>
                        <input type="date" name="date_from">
                    </div>
                    <div class="form-group">
                        <label>Date To</label>
                        <input type="date" name="date_to">
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Delivery Method *</label>
                    <select name="delivery_method" required>
                        <option value="portal">Patient Portal (Free)</option>
                        <option value="email">Email (Free)</option>
                        <option value="pickup">Pickup In Person (Free)</option>
                        <option value="mail">Mail ($15 Fee)</option>
                        <option value="fax">Fax ($10 Fee)</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Purpose of Request *</label>
                    <select name="purpose" required>
                        <option value="personal">Personal Use</option>
                        <option value="new_doctor">New Doctor</option>
                        <option value="insurance">Insurance</option>
                        <option value="legal">Legal Purposes</option>
                        <option value="employment">Employment</option>
                    </select>
                </div>
                
                <button type="submit" name="request_records" class="submit-btn">Submit Request</button>
            </form>
        </div>
        
        <div>
            <div class="info-card">
                <h3>📋 Information About Medical Records</h3>
                <ul class="info-list">
                    <li>Processing time: 7-14 business days</li>
                    <li>Records are confidential and protected by HIPAA</li>
                    <li>You have the right to access your records</li>
                    <li>Fees may apply for copies and mailing</li>
                    <li>Records available for up to 7 years</li>
                </ul>
            </div>
            
            <div class="info-card">
                <h3>🔒 Patient Portal Access</h3>
                <p>Access your records instantly through our secure patient portal. View test results, request prescriptions, and message your doctor.</p>
                <p style="margin-top: 15px;">
                    <a href="login.php" style="color: #667eea;">Login to Portal →</a>
                </p>
            </div>
            
            <div class="info-card">
                <h3>📞 Need Help?</h3>
                <p>Contact our Medical Records Department:</p>
                <p>Phone: (555) 123-4567<br>Email: records@floridamedical.com<br>Hours: Mon-Fri, 9am - 5pm</p>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
</body>
</html>