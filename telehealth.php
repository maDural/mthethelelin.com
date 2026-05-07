<?php
session_start();
include 'includes/db.php';

$is_logged_in = isset($_SESSION['user_id']);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['schedule_telehealth'])) {
    if ($is_logged_in) {
        $user_id = $_SESSION['user_id'];
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
        $date = mysqli_real_escape_string($conn, $_POST['date']);
        $time = mysqli_real_escape_string($conn, $_POST['time']);
        $concern = mysqli_real_escape_string($conn, $_POST['concern']);
        
        $query = "INSERT INTO telehealth_appointments (user_id, name, email, phone, appointment_date, appointment_time, concern, status, created_at) 
                  VALUES ('$user_id', '$name', '$email', '$phone', '$date', '$time', '$concern', 'pending', NOW())";
        
        if ($conn->query($query)) {
            $success_message = "Your telehealth appointment has been scheduled! You will receive a video link via email before your appointment.";
        } else {
            $error_message = "Something went wrong. Please try again.";
        }
    } else {
        $_SESSION['telehealth_data'] = $_POST;
        header("Location: login.php");
        exit();
    }
}

include 'includes/header.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Telehealth - Florida Medical Clinic</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .telehealth-hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-align: center;
            padding: 80px 20px;
            margin-bottom: 50px;
        }
        
        .telehealth-hero h1 {
            font-size: 48px;
            margin-bottom: 20px;
            animation: fadeInDown 1s ease;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .telehealth-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-bottom: 60px;
        }
        
        .benefits-section {
            background: #f8f9fa;
            padding: 40px;
            border-radius: 15px;
            margin-bottom: 50px;
        }
        
        .benefits-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 25px;
            margin-top: 30px;
        }
        
        .benefit-card {
            text-align: center;
            padding: 20px;
            background: white;
            border-radius: 10px;
            transition: transform 0.3s ease;
        }
        
        .benefit-card:hover {
            transform: translateY(-5px);
        }
        
        .benefit-icon {
            font-size: 40px;
            margin-bottom: 15px;
        }
        
        .appointment-form {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
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
        
        .info-box {
            background: #e8f4f8;
            padding: 25px;
            border-radius: 10px;
            margin-bottom: 25px;
            border-left: 4px solid #667eea;
        }
        
        .requirements-list {
            list-style: none;
            padding: 0;
        }
        
        .requirements-list li {
            padding: 8px 0;
            display: flex;
            align-items: center;
        }
        
        .requirements-list li:before {
            content: "✓";
            color: #28a745;
            font-weight: bold;
            margin-right: 10px;
        }
        
        .success-message {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        
        @media (max-width: 768px) {
            .telehealth-grid { grid-template-columns: 1fr; }
            .form-row { grid-template-columns: 1fr; gap: 0; }
        }
        
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-30px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<div class="telehealth-hero">
    <h1>Telehealth Services</h1>
    <p>Quality healthcare from the comfort of your home</p>
</div>

<div class="container">
    <div class="benefits-section">
        <h2 style="text-align: center; color: #2c3e50;">Why Choose Telehealth?</h2>
        <div class="benefits-grid">
            <div class="benefit-card">
                <div class="benefit-icon">🏠</div>
                <h3>Stay Home</h3>
                <p>No travel or waiting rooms</p>
            </div>
            <div class="benefit-card">
                <div class="benefit-icon">🕒</div>
                <h3>Save Time</h3>
                <p>Shorter wait times</p>
            </div>
            <div class="benefit-card">
                <div class="benefit-icon">💰</div>
                <h3>Cost Effective</h3>
                <p>Lower out-of-pocket costs</p>
            </div>
            <div class="benefit-card">
                <div class="benefit-icon">🔒</div>
                <h3>Secure & Private</h3>
                <p>HIPAA compliant platform</p>
            </div>
        </div>
    </div>
    
    <div class="telehealth-grid">
        <div class="appointment-form">
            <h2>Schedule Telehealth Visit</h2>
            <p style="color: #666; margin-bottom: 20px;">Book your virtual appointment today</p>
            
            <?php if (isset($success_message)): ?>
                <div class="success-message"><?php echo $success_message; ?></div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-group">
                    <label>Full Name *</label>
                    <input type="text" name="name" required>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Email *</label>
                        <input type="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label>Phone *</label>
                        <input type="tel" name="phone" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Preferred Date *</label>
                        <input type="date" name="date" id="telehealthDate" required>
                    </div>
                    <div class="form-group">
                        <label>Preferred Time *</label>
                        <select name="time" required>
                            <option value="">Select time</option>
                            <option value="09:00">9:00 AM</option>
                            <option value="10:00">10:00 AM</option>
                            <option value="11:00">11:00 AM</option>
                            <option value="13:00">1:00 PM</option>
                            <option value="14:00">2:00 PM</option>
                            <option value="15:00">3:00 PM</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Reason for Visit *</label>
                    <textarea name="concern" rows="4" placeholder="Please describe your symptoms or reason for visit..." required></textarea>
                </div>
                
                <button type="submit" name="schedule_telehealth" class="submit-btn">Schedule Virtual Visit</button>
            </form>
        </div>
        
        <div>
            <div class="info-box">
                <h3>📋 Conditions We Treat via Telehealth</h3>
                <ul class="requirements-list">
                    <li>Cold, Flu & Allergies</li>
                    <li>Sinus Infections</li>
                    <li>Urinary Tract Infections</li>
                    <li>Skin Rashes & Conditions</li>
                    <li>Follow-up Appointments</li>
                    <li>Medication Management</li>
                    <li>Mental Health Counseling</li>
                    <li>Prescription Refills</li>
                </ul>
            </div>
            
            <div class="info-box">
                <h3>💻 Technical Requirements</h3>
                <ul class="requirements-list">
                    <li>Smartphone, tablet, or computer</li>
                    <li>Camera and microphone</li>
                    <li>Stable internet connection</li>
                    <li>Private, quiet space</li>
                    <li>Valid email address</li>
                </ul>
            </div>
            
            <div class="info-box">
                <h3>🎥 How It Works</h3>
                <ul class="requirements-list">
                    <li>Schedule your appointment online</li>
                    <li>Receive video link via email/SMS</li>
                    <li>Click link at appointment time</li>
                    <li>Consult with your doctor virtually</li>
                    <li>Get prescriptions sent to your pharmacy</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('telehealthDate').setAttribute('min', today);
</script>

<?php include 'includes/footer.php'; ?>
</body>
</html>