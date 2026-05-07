<?php
session_start();
include 'includes/db.php';

// Protect page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Get user name for welcome message
$user_query = $conn->query("SELECT fullname FROM users WHERE id='$user_id'");
$user = $user_query->fetch_assoc();
$user_name = $user['fullname'];

// Fetch appointments for the logged-in user
$query = "SELECT * FROM appointments WHERE user_id = '$user_id' ORDER BY appointment_date DESC";
$result = $conn->query($query);

// Fetch telehealth appointments
$telehealth_query = "SELECT * FROM telehealth_appointments WHERE user_id = '$user_id' ORDER BY appointment_date DESC";
$telehealth_result = $conn->query($telehealth_query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Appointments - Florida Medical Clinic</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
        }
        
        .top-bar {
            background: rgba(255, 255, 255, 0.95);
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #2c3e50;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        
        .top-bar h2 {
            margin: 0;
        }
        
        .back-btn, .logout-btn {
            padding: 8px 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 25px;
            transition: all 0.3s ease;
            margin-left: 10px;
        }
        
        .back-btn:hover, .logout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        .container {
            max-width: 1200px;
            margin: 50px auto;
            padding: 0 20px;
        }
        
        .welcome-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            text-align: center;
        }
        
        .welcome-card h1 {
            color: #2c3e50;
            margin-bottom: 10px;
        }
        
        .welcome-card p {
            color: #666;
        }
        
        .appointments-section {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        
        .appointments-section h2 {
            color: #2c3e50;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #667eea;
        }
        
        .appointment-card {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 15px;
            transition: all 0.3s ease;
            border-left: 4px solid #667eea;
        }
        
        .appointment-card:hover {
            transform: translateX(5px);
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }
        
        .appointment-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 15px;
        }
        
        .detail-item {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }
        
        .detail-icon {
            font-size: 20px;
        }
        
        .detail-label {
            font-weight: 600;
            color: #555;
        }
        
        .detail-value {
            color: #333;
        }
        
        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }
        
        .status-pending {
            background: #fff3cd;
            color: #856404;
        }
        
        .status-confirmed {
            background: #d4edda;
            color: #155724;
        }
        
        .status-completed {
            background: #cce5ff;
            color: #004085;
        }
        
        .status-cancelled {
            background: #f8d7da;
            color: #721c24;
        }
        
        .status-message {
            font-size: 12px;
            margin-top: 10px;
            padding: 8px;
            border-radius: 5px;
        }
        
        .status-message.pending {
            background: #fff3cd;
            color: #856404;
        }
        
        .status-message.confirmed {
            background: #d4edda;
            color: #155724;
        }
        
        .status-message.cancelled {
            background: #f8d7da;
            color: #721c24;
        }
        
        .no-appointments {
            text-align: center;
            padding: 40px;
            color: #666;
        }
        
        .book-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 25px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 25px;
            transition: all 0.3s ease;
        }
        
        .book-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        /* Video Call Button */
        .video-call-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #28a745;
            color: white;
            padding: 8px 20px;
            border-radius: 25px;
            text-decoration: none;
            font-size: 14px;
            margin-top: 10px;
            transition: all 0.3s ease;
        }
        
        .video-call-btn:hover {
            background: #218838;
            transform: translateY(-2px);
        }
        
        @media (max-width: 768px) {
            .appointment-details {
                grid-template-columns: 1fr;
            }
            
            .top-bar h2 {
                font-size: 18px;
            }
            
            .appointments-section {
                padding: 20px;
            }
        }
    </style>
</head>
<body>

<div class="top-bar">
    <h2>📋 My Appointments</h2>
    <div>
        <a href="dashboard.php" class="back-btn">← Back to Dashboard</a>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</div>

<div class="container">
    <!-- Welcome Card -->
    <div class="welcome-card">
        <h1>Welcome, <?php echo htmlspecialchars($user_name); ?>! 👋</h1>
        <p>Here you can track the status of your appointments. The admin will review and confirm your bookings.</p>
    </div>
    
    <!-- In-Person Appointments -->
    <div class="appointments-section">
        <h2>🏥 In-Person Appointments</h2>
        
        <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <?php 
                // Check if status exists, if not set default
                $status = isset($row['status']) ? $row['status'] : 'pending';
                
                // Set status class and message
                $status_class = '';
                $status_message = '';
                switch($status) {
                    case 'confirmed':
                        $status_class = 'status-confirmed';
                        $status_message = '✅ Your appointment has been confirmed! Please arrive on time.';
                        break;
                    case 'completed':
                        $status_class = 'status-completed';
                        $status_message = '✔️ This appointment has been completed. Thank you for visiting us!';
                        break;
                    case 'cancelled':
                        $status_class = 'status-cancelled';
                        $status_message = '❌ This appointment has been cancelled. Please book a new one if needed.';
                        break;
                    default:
                        $status_class = 'status-pending';
                        $status = 'pending';
                        $status_message = '⏳ Your appointment is pending admin approval. You will receive a confirmation once approved.';
                }
                ?>
                <div class="appointment-card">
                    <div class="appointment-details">
                        <div class="detail-item">
                            <span class="detail-icon">📅</span>
                            <span class="detail-label">Date:</span>
                            <span class="detail-value"><?php echo date('F d, Y', strtotime($row['appointment_date'])); ?></span>
                        </div>
                        <div class="detail-item">
                            <span class="detail-icon">⏰</span>
                            <span class="detail-label">Time:</span>
                            <span class="detail-value"><?php echo date('g:i A', strtotime($row['appointment_time'])); ?></span>
                        </div>
                        <?php if (isset($row['department']) && $row['department']): ?>
                        <div class="detail-item">
                            <span class="detail-icon">🏥</span>
                            <span class="detail-label">Department:</span>
                            <span class="detail-value"><?php echo ucfirst(str_replace('_', ' ', htmlspecialchars($row['department']))); ?></span>
                        </div>
                        <?php endif; ?>
                        <?php if (isset($row['doctor']) && $row['doctor']): ?>
                        <div class="detail-item">
                            <span class="detail-icon">👨‍⚕️</span>
                            <span class="detail-label">Doctor:</span>
                            <span class="detail-value"><?php echo ucfirst(str_replace('_', ' ', htmlspecialchars($row['doctor']))); ?></span>
                        </div>
                        <?php endif; ?>
                        <div class="detail-item">
                            <span class="detail-icon">📋</span>
                            <span class="detail-label">Status:</span>
                            <span class="status-badge <?php echo $status_class; ?>">
                                <?php echo ucfirst($status); ?>
                            </span>
                        </div>
                    </div>
                    <?php if (isset($row['reason']) && $row['reason']): ?>
                    <div class="detail-item">
                        <span class="detail-icon">💬</span>
                        <span class="detail-label">Reason:</span>
                        <span class="detail-value"><?php echo htmlspecialchars($row['reason']); ?></span>
                    </div>
                    <?php endif; ?>
                    
                    <!-- Status Message -->
                    <div class="status-message <?php echo $status; ?>">
                        <?php echo $status_message; ?>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="no-appointments">
                <p>📭 No in-person appointments found.</p>
                <a href="appointment.php" class="book-btn">📅 Book an Appointment</a>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Telehealth Appointments -->
    <?php if ($telehealth_result && $telehealth_result->num_rows > 0): ?>
    <div class="appointments-section">
        <h2>💻 Telehealth Appointments</h2>
        
        <?php while ($row = $telehealth_result->fetch_assoc()): ?>
            <?php 
            $status = isset($row['status']) ? $row['status'] : 'pending';
            
            $status_class = '';
            $status_message = '';
            switch($status) {
                case 'confirmed':
                    $status_class = 'status-confirmed';
                    $status_message = '✅ Your telehealth appointment has been confirmed! Click the button below to join the video call.';
                    break;
                case 'completed':
                    $status_class = 'status-completed';
                    $status_message = '✔️ This telehealth appointment has been completed.';
                    break;
                case 'cancelled':
                    $status_class = 'status-cancelled';
                    $status_message = '❌ This telehealth appointment has been cancelled.';
                    break;
                default:
                    $status_class = 'status-pending';
                    $status = 'pending';
                    $status_message = '⏳ Your telehealth appointment is pending admin approval. You will receive a video link once confirmed.';
            }
            ?>
            <div class="appointment-card">
                <div class="appointment-details">
                    <div class="detail-item">
                        <span class="detail-icon">📅</span>
                        <span class="detail-label">Date:</span>
                        <span class="detail-value"><?php echo date('F d, Y', strtotime($row['appointment_date'])); ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-icon">⏰</span>
                        <span class="detail-label">Time:</span>
                        <span class="detail-value"><?php echo date('g:i A', strtotime($row['appointment_time'])); ?></span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-icon">💻</span>
                        <span class="detail-label">Type:</span>
                        <span class="detail-value">Virtual Visit</span>
                    </div>
                    <div class="detail-item">
                        <span class="detail-icon">📋</span>
                        <span class="detail-label">Status:</span>
                        <span class="status-badge <?php echo $status_class; ?>">
                            <?php echo ucfirst($status); ?>
                        </span>
                    </div>
                </div>
                <?php if (isset($row['reason']) && $row['reason']): ?>
                <div class="detail-item">
                    <span class="detail-icon">💬</span>
                    <span class="detail-label">Reason:</span>
                    <span class="detail-value"><?php echo htmlspecialchars($row['reason']); ?></span>
                </div>
                <?php endif; ?>
                
                <!-- Status Message -->
                <div class="status-message <?php echo $status; ?>">
                    <?php echo $status_message; ?>
                </div>
                
                <!-- Video Call Button (only for confirmed appointments) -->
                <?php if ($status == 'confirmed'): ?>
                <div style="margin-top: 15px;">
                    <a href="#" class="video-call-btn" onclick="alert('Video link will be sent to your email before the appointment. This is a demo.'); return false;">
                        🎥 Join Video Call
                    </a>
                </div>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    </div>
    <?php endif; ?>
    
    <!-- Quick Action Buttons -->
    <div style="display: flex; gap: 15px; justify-content: center; margin-top: 20px;">
        <a href="appointment.php" class="book-btn" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%);">
            📅 Book New Appointment
        </a>
        <a href="dashboard.php" class="book-btn" style="background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);">
            📊 Go to Dashboard
        </a>
    </div>
</div>

</body>
</html>