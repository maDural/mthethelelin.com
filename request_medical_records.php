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
$user_name = $user['fullname'];
$user_email = $user['email'];

$success = '';
$error = '';

if (isset($_POST['submit_request'])) {
    $record_type = mysqli_real_escape_string($conn, $_POST['record_type']);
    $date_from = !empty($_POST['date_from']) ? mysqli_real_escape_string($conn, $_POST['date_from']) : NULL;
    $date_to = !empty($_POST['date_to']) ? mysqli_real_escape_string($conn, $_POST['date_to']) : NULL;
    $delivery_method = mysqli_real_escape_string($conn, $_POST['delivery_method']);
    $purpose = mysqli_real_escape_string($conn, $_POST['purpose']);
    
    $query = "INSERT INTO medical_record_requests (user_id, record_type, date_from, date_to, delivery_method, purpose, status, request_date) 
              VALUES ('$user_id', '$record_type', '$date_from', '$date_to', '$delivery_method', '$purpose', 'pending', NOW())";
    
    if ($conn->query($query)) {
        $success = "✅ Your medical record request has been submitted successfully! You will be notified once it's processed.";
    } else {
        $error = "❌ Error submitting request: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Request Medical Records - Florida Medical Clinic</title>
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
            min-height: 80px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .info-box {
            background: #e8f4f8;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 12px;
            color: #666;
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
            
            .form-row {
                grid-template-columns: 1fr;
                gap: 0;
            }
        }
    </style>
</head>
<body>

<div class="top-bar">
    <h2>📄 Request Medical Records</h2>
    <div>
        <a href="dashboard.php" class="back-btn">← Back</a>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</div>

<div class="container">
    <div class="form-box">
        <div class="form-inner">
            <h2>Medical Records Request</h2>
            <div class="subtitle">Request access to your health information</div>
            <div class="welcome">Welcome, <?php echo htmlspecialchars($user_name); ?>!</div>

            <?php if ($success): ?>
                <div class="success"><?php echo $success; ?></div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="form-group">
                    <label>📋 Type of Records *</label>
                    <select name="record_type" required>
                        <option value="">Select record type</option>
                        <option value="full">Complete Medical Records</option>
                        <option value="summary">Medical Summary</option>
                        <option value="lab">Lab Results</option>
                        <option value="imaging">Imaging Reports (X-ray, MRI, CT Scan)</option>
                        <option value="immunization">Immunization Records</option>
                        <option value="prescription">Prescription History</option>
                    </select>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>📅 Date From (Optional)</label>
                        <input type="date" name="date_from" id="date_from">
                    </div>
                    <div class="form-group">
                        <label>📅 Date To (Optional)</label>
                        <input type="date" name="date_to" id="date_to">
                    </div>
                </div>

                <div class="form-group">
                    <label>📬 Delivery Method *</label>
                    <select name="delivery_method" required>
                        <option value="">Select delivery method</option>
                        <option value="portal">Patient Portal (Free - Instant Access)</option>
                        <option value="email">Email (Free)</option>
                        <option value="pickup">Pickup In Person (Free)</option>
                        <option value="mail">Mail ($15 Fee)</option>
                        <option value="fax">Fax ($10 Fee)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>🎯 Purpose of Request *</label>
                    <select name="purpose" required>
                        <option value="">Select purpose</option>
                        <option value="personal">Personal Use</option>
                        <option value="new_doctor">New Healthcare Provider</option>
                        <option value="insurance">Insurance Purposes</option>
                        <option value="legal">Legal Purposes</option>
                        <option value="employment">Employment Requirements</option>
                    </select>
                </div>

                <div class="info-box">
                    <strong>📌 Important Information:</strong>
                    <ul style="margin-top: 8px; margin-left: 20px;">
                        <li>Processing time: 7-14 business days</li>
                        <li>Records are confidential and protected by HIPAA</li>
                        <li>Fees may apply for copies and mailing</li>
                    </ul>
                </div>

                <button type="submit" name="submit_request">📄 Submit Request</button>

                <div class="info-note">
                    <strong>Need help?</strong> Call our Medical Records Department at (555) 123-4567
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Set max date to today
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('date_from').setAttribute('max', today);
    document.getElementById('date_to').setAttribute('max', today);
    
    // Date validation: date_to cannot be less than date_from
    document.getElementById('date_from').addEventListener('change', function() {
        const dateTo = document.getElementById('date_to');
        if (dateTo.value && this.value > dateTo.value) {
            dateTo.value = '';
            alert('Date To cannot be earlier than Date From');
        }
        dateTo.setAttribute('min', this.value);
    });
    
    document.getElementById('date_to').addEventListener('change', function() {
        const dateFrom = document.getElementById('date_from');
        if (dateFrom.value && this.value < dateFrom.value) {
            this.value = '';
            alert('Date To cannot be earlier than Date From');
        }
    });
</script>

</body>
</html>