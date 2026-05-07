<?php
session_start();
include 'includes/db.php';

// protect page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get user info
$user_id = $_SESSION['user_id'];
$user_query = $conn->query("SELECT fullname FROM users WHERE id='$user_id'");
$user = $user_query->fetch_assoc();
$user_name = $user['fullname'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Florida Medical Clinic</title>
    <link rel="stylesheet" href="css/style.css">
    
    <style>
        /* Dashboard specific styles */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: url('dash.jpg') no-repeat center center fixed;
            background-size: cover;
            position: relative;
        }
        
        /* Optional: Add dark overlay for better text readability */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: -1;
        }
        
        .top-bar {
            background: linear-gradient(135deg, #1a2980 0%, #26d0ce 100%);
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: white;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        
        .top-bar h2 {
            margin: 0;
            font-size: 24px;
        }
        
        .logout-btn {
            padding: 8px 20px;
            background: rgba(255,255,255,0.2);
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: all 0.3s ease;
        }
        
        .logout-btn:hover {
            background: rgba(255,255,255,0.3);
            transform: translateY(-2px);
        }
        
        .dashboard-container {
            max-width: 1200px;
            margin: 80px auto;
            padding: 40px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            backdrop-filter: blur(5px);
            text-align: center;
        }
        
        .dashboard-container h1 {
            color: #2c3e50;
            margin-bottom: 10px;
            font-size: 36px;
        }
        
        .welcome-text {
            color: #667eea;
            margin-bottom: 30px;
            font-size: 16px;
        }
        
        .dashboard-container p {
            color: #666;
            margin-bottom: 40px;
            font-size: 18px;
        }
        
        .dashboard-cards {
            display: flex;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap;
            margin-top: 30px;
        }
        
        .card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            padding: 40px 50px;
            border-radius: 15px;
            font-size: 18px;
            font-weight: 600;
            transition: all 0.3s ease;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 12px;
            min-width: 220px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            text-align: center;
        }
        
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.3);
        }
        
        .card-icon {
            font-size: 48px;
        }
        
        .card-title {
            font-size: 18px;
        }
        
        .card-desc {
            font-size: 12px;
            opacity: 0.8;
            font-weight: normal;
        }
        
        /* Different colors for each card */
        .card:nth-child(1) {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .card:nth-child(2) {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        
        .card:nth-child(3) {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }
        
        .card:nth-child(4) {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }
        
        .card:nth-child(5) {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        }
        
        /* Responsive Design */
        @media (max-width: 768px) {
            .dashboard-container {
                margin: 40px 20px;
                padding: 30px;
            }
            
            .dashboard-container h1 {
                font-size: 28px;
            }
            
            .card {
                padding: 30px 40px;
                min-width: 180px;
            }
            
            .card-icon {
                font-size: 36px;
            }
        }
        
        @media (max-width: 480px) {
            .dashboard-container {
                margin: 20px 15px;
                padding: 20px;
            }
            
            .dashboard-container h1 {
                font-size: 24px;
            }
            
            .card {
                padding: 20px 25px;
                min-width: 100%;
            }
        }
    </style>
</head>

<body>

<!-- TOP BAR -->
<div class="top-bar">
    <h2>🏥 Patient Dashboard</h2>
    <a href="logout.php" class="logout-btn">Logout</a>
</div>

<!-- DASHBOARD CONTENT -->
<div class="dashboard-container">
    <h1>Welcome, <?php echo htmlspecialchars($user_name); ?>! 👋</h1>
    <div class="welcome-text">Manage your healthcare needs from one place</div>
    <p>What would you like to do today?</p>

    <div class="dashboard-cards">
        <!-- BOOK APPOINTMENT CARD -->
        <a href="appointment.php" class="card">
            <div class="card-icon">📅</div>
            <div class="card-title">Book Appointment</div>
            <div class="card-desc">Schedule in-person or telehealth visit</div>
        </a>

        <!-- MY APPOINTMENTS CARD -->
        <a href="my_appointments.php" class="card">
            <div class="card-icon">📋</div>
            <div class="card-title">My Appointments</div>
            <div class="card-desc">View and track your appointments</div>
        </a>

        <!-- REQUEST MEDICAL RECORDS CARD -->
        <a href="request_medical_records.php" class="card">
            <div class="card-icon">📄</div>
            <div class="card-title">Medical Records</div>
            <div class="card-desc">Request your medical records</div>
        </a>

        <!-- MY REQUESTS CARD -->
        <a href="my_requests.php" class="card">
            <div class="card-icon">📬</div>
            <div class="card-title">My Requests</div>
            <div class="card-desc">Track your medical record requests & responses</div>
        </a>

        <!-- MY MESSAGES CARD - NEW! -->
        <a href="my_messages.php" class="card">
            <div class="card-icon">💬</div>
            <div class="card-title">My Messages</div>
            <div class="card-desc">View responses from our team</div>
        </a>
    </div>
</div>

</body>
</html>