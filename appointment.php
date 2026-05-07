<?php
session_start();
include 'includes/db.php';

// protect page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get user info for personalized greeting
$user_id = $_SESSION['user_id'];
$user_query = $conn->query("SELECT fullname, email FROM users WHERE id='$user_id'");
$user = $user_query->fetch_assoc();
$user_name = $user['fullname'];
$user_email = $user['email'];

$success = '';
$error = '';

if (isset($_POST['book'])) {
    $appointment_type = mysqli_real_escape_string($conn, $_POST['appointment_type']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $time = mysqli_real_escape_string($conn, $_POST['time']);
    $reason = mysqli_real_escape_string($conn, $_POST['reason']);
    $user_id = $_SESSION['user_id'];
    
    if ($appointment_type == 'in_person') {
        $department = mysqli_real_escape_string($conn, $_POST['department']);
        $doctor = mysqli_real_escape_string($conn, $_POST['doctor']);
        
        $query = "INSERT INTO appointments (user_id, fullname, email, appointment_type, appointment_date, appointment_time, department, doctor, reason, status, created_at) 
                  VALUES ('$user_id', '$user_name', '$user_email', 'in_person', '$date', '$time', '$department', '$doctor', '$reason', 'pending', NOW())";
        
        if ($conn->query($query)) {
            $success = "✅ In-person appointment booked successfully!";
        } else {
            $error = "Error: " . $conn->error;
        }
    } 
    elseif ($appointment_type == 'telehealth') {
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
        $video_link = "https://teams.floridamedical.com/meet/" . uniqid() . "_" . $user_id;
        
        $query = "INSERT INTO telehealth_appointments (user_id, fullname, email, phone, appointment_date, appointment_time, reason, video_link, status, created_at) 
                  VALUES ('$user_id', '$user_name', '$user_email', '$phone', '$date', '$time', '$reason', '$video_link', 'pending', NOW())";
        
        if ($conn->query($query)) {
            $success = "✅ Telehealth appointment booked successfully!";
        } else {
            $error = "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book Appointment - Florida Medical Clinic</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-image: url('appointment.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            min-height: 100vh;
        }

        /* Top Bar */
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
            margin: 0;
            font-size: 22px;
        }

        .back-btn, .logout-btn {
            padding: 8px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 500;
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

        .back-btn:hover, .logout-btn:hover {
            transform: translateY(-2px);
        }

        /* Form Container - Centered */
        .form-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 70px);
            padding: 30px 20px;
        }

        /* Form Box - Fixed width, no overflow */
        .form-box {
            background: white;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 500px;
            padding: 0;
            overflow: hidden;
        }

        /* Form Inner Content */
        .form-inner {
            padding: 30px;
        }

        .form-box h2 {
            text-align: center;
            color: #2c3e50;
            font-size: 24px;
            margin-bottom: 5px;
        }

        .welcome-message {
            text-align: center;
            color: #667eea;
            margin-bottom: 20px;
            font-size: 13px;
        }

        .success {
            background: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 15px;
            text-align: center;
            font-size: 13px;
        }

        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 15px;
            text-align: center;
            font-size: 13px;
        }

        /* Appointment Type - Side by side */
        .appointment-type {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }

        .type-option {
            flex: 1;
            text-align: center;
            padding: 12px;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            background: white;
        }

        .type-option:hover {
            border-color: #667eea;
            background: #f8f9fa;
        }

        .type-option.selected {
            border-color: #667eea;
            background: #e8eaff;
        }

        .type-icon {
            font-size: 28px;
            display: block;
            margin-bottom: 5px;
        }

        .type-title {
            font-weight: 600;
            color: #2c3e50;
            font-size: 14px;
        }

        .type-desc {
            font-size: 10px;
            color: #666;
            margin-top: 3px;
        }

        /* Form Elements */
        input, select, textarea {
            width: 100%;
            padding: 12px 14px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 2px rgba(102, 126, 234, 0.1);
        }

        textarea {
            resize: vertical;
            min-height: 80px;
        }

        /* Conditional Fields */
        .conditional-fields {
            display: none;
        }

        .conditional-fields.active {
            display: block;
        }

        /* Time Slots Grid */
        .quick-times {
            margin-bottom: 15px;
        }

        .quick-times label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #2c3e50;
            font-size: 13px;
        }

        .time-slots {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 8px;
            margin-bottom: 12px;
        }

        .time-slot {
            padding: 8px 5px;
            background: #f0f2f5;
            text-align: center;
            border-radius: 6px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 12px;
        }

        .time-slot:hover {
            background: #667eea;
            color: white;
        }

        .time-slot.selected {
            background: #667eea;
            color: white;
        }

        .custom-time-label {
            display: block;
            margin-bottom: 6px;
            font-weight: 600;
            color: #2c3e50;
            font-size: 12px;
        }

        /* Submit Button */
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
            margin-top: 5px;
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        /* Info Boxes */
        .info-box {
            background: #f8f9fa;
            padding: 12px;
            border-radius: 8px;
            margin-top: 15px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 12px;
            color: #666;
        }

        .info-icon {
            font-size: 20px;
        }

        .info-text strong {
            color: #2c3e50;
            display: block;
            margin-bottom: 3px;
        }

        /* Telehealth info */
        .telehealth-info {
            background: #e8f4f8;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 15px;
            font-size: 12px;
        }

        /* Responsive */
        @media (max-width: 550px) {
            .form-inner {
                padding: 20px;
            }
            
            .time-slots {
                grid-template-columns: repeat(3, 1fr);
            }
            
            .appointment-type {
                flex-direction: column;
                gap: 10px;
            }
        }

        @media (max-width: 400px) {
            .time-slots {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>
</head>
<body>

<div class="top-bar">
    <h2>📅 Book Appointment</h2>
    <div>
        <a href="dashboard.php" class="back-btn">← Back</a>
        <a href="logout.php" class="logout-btn">Logout</a>
    </div>
</div>

<div class="form-container">
    <div class="form-box">
        <div class="form-inner">
            <h2>Make an Appointment</h2>
            <div class="welcome-message">
                Welcome back, <?php echo htmlspecialchars($user_name); ?>!
            </div>

            <?php if ($success): ?>
                <div class="success"><?php echo $success; ?></div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="error">❌ <?php echo $error; ?></div>
            <?php endif; ?>

            <form method="POST" id="appointmentForm">
                <!-- Appointment Type Selection -->
                <div class="appointment-type">
                    <div class="type-option selected" data-type="in_person">
                        <div class="type-icon">🏥</div>
                        <div class="type-title">In-Person Visit</div>
                        <div class="type-desc">Visit us at our clinic</div>
                    </div>
                    <div class="type-option" data-type="telehealth">
                        <div class="type-icon">💻</div>
                        <div class="type-title">Telehealth Visit</div>
                        <div class="type-desc">Video consultation from home</div>
                    </div>
                </div>

                <input type="hidden" name="appointment_type" id="appointment_type" value="in_person">

                <!-- Date Input -->
                <input type="date" name="date" id="appointmentDate" required>

                <!-- Time Selection -->
                <div class="quick-times">
                    <label>⏰ Select Time</label>
                    <div class="time-slots">
                        <div class="time-slot" data-time="09:00">9:00 AM</div>
                        <div class="time-slot" data-time="10:00">10:00 AM</div>
                        <div class="time-slot" data-time="11:00">11:00 AM</div>
                        <div class="time-slot" data-time="12:00">12:00 PM</div>
                        <div class="time-slot" data-time="13:00">1:00 PM</div>
                        <div class="time-slot" data-time="14:00">2:00 PM</div>
                        <div class="time-slot" data-time="15:00">3:00 PM</div>
                        <div class="time-slot" data-time="16:00">4:00 PM</div>
                    </div>
                    <div class="custom-time-label">Or enter custom time:</div>
                    <input type="time" name="time" id="appointmentTime" step="1800">
                </div>

                <!-- In-Person Fields -->
                <div id="inPersonFields" class="conditional-fields active">
                    <select name="department" id="department" required>
                        <option value="">Select Department</option>
                        <option value="primary_care">Primary Care</option>
                        <option value="cardiology">Cardiology</option>
                        <option value="pediatrics">Pediatrics</option>
                        <option value="womens_health">Women's Health</option>
                        <option value="neurology">Neurology</option>
                        <option value="orthopedics">Orthopedics</option>
                        <option value="dental">Dental Care</option>
                    </select>

                    <select name="doctor" id="doctor" required>
                        <option value="">Select Doctor</option>
                        <option value="dr_roberts">Dr. Mthetheleli Ndlovu - Primary Care</option>
                        <option value="dr_martinez">Dr. Nompumelelo Phungula - Cardiology</option>
                        <option value="dr_johnson">Dr. Likhona Mgaga - Pediatrics</option>
                        <option value="dr_williams">Dr. Sebenza Ngobese - Surgery</option>
                        <option value="dr_anderson">Dr. Amahle Phungula - Women's Health</option>
                        <option value="dr_patel">Dr. Silindile Gabuza - Neurology</option>
                    </select>
                </div>

                <!-- Telehealth Fields -->
                <div id="telehealthFields" class="conditional-fields">
                    <input type="tel" name="phone" id="phone" placeholder="📞 Phone Number">
                    <div class="telehealth-info">
                        <strong>📹 How Telehealth Works:</strong>
                        You will receive a secure video link via email before your appointment.
                    </div>
                </div>

                <!-- Reason -->
                <textarea name="reason" placeholder="📝 Reason for visit / Symptoms" required></textarea>

                <!-- Submit Button -->
                <button type="submit" name="book">✅ Book Appointment</button>

                <!-- Info Boxes -->
                <div class="info-box">
                    <div class="info-icon">ℹ️</div>
                    <div class="info-text">
                        <strong>Need to reschedule?</strong>
                        Please call us at least 24 hours in advance.
                    </div>
                </div>

                <div class="info-box">
                    <div class="info-icon">📍</div>
                    <div class="info-text">
                        <strong>Location:</strong>
                        123 Medical Drive, Florida, FL 33101
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('appointmentDate').setAttribute('min', today);

    const typeOptions = document.querySelectorAll('.type-option');
    const appointmentTypeInput = document.getElementById('appointment_type');
    const inPersonFields = document.getElementById('inPersonFields');
    const telehealthFields = document.getElementById('telehealthFields');
    const departmentSelect = document.getElementById('department');
    const doctorSelect = document.getElementById('doctor');
    const phoneInput = document.getElementById('phone');

    typeOptions.forEach(option => {
        option.addEventListener('click', function() {
            typeOptions.forEach(opt => opt.classList.remove('selected'));
            this.classList.add('selected');
            
            const type = this.dataset.type;
            appointmentTypeInput.value = type;
            
            if (type === 'in_person') {
                inPersonFields.classList.add('active');
                telehealthFields.classList.remove('active');
                if (departmentSelect) departmentSelect.required = true;
                if (doctorSelect) doctorSelect.required = true;
                if (phoneInput) phoneInput.required = false;
            } else {
                inPersonFields.classList.remove('active');
                telehealthFields.classList.add('active');
                if (departmentSelect) departmentSelect.required = false;
                if (doctorSelect) doctorSelect.required = false;
                if (phoneInput) phoneInput.required = true;
            }
        });
    });

    const timeSlots = document.querySelectorAll('.time-slot');
    const timeInput = document.getElementById('appointmentTime');

    timeSlots.forEach(slot => {
        slot.addEventListener('click', function() {
            timeSlots.forEach(s => s.classList.remove('selected'));
            this.classList.add('selected');
            timeInput.value = this.dataset.time;
        });
    });

    timeInput.addEventListener('input', function() {
        timeSlots.forEach(slot => slot.classList.remove('selected'));
    });

    document.getElementById('appointmentForm').addEventListener('submit', function(e) {
        const date = document.getElementById('appointmentDate').value;
        const time = timeInput.value;
        const reason = document.querySelector('textarea[name="reason"]').value;
        const appointmentType = appointmentTypeInput.value;

        if (!date || !time || !reason) {
            e.preventDefault();
            alert('Please fill in all fields: Date, Time, and Reason for visit.');
            return;
        }

        if (appointmentType === 'in_person') {
            const department = departmentSelect ? departmentSelect.value : '';
            const doctor = doctorSelect ? doctorSelect.value : '';
            if (!department || !doctor) {
                e.preventDefault();
                alert('Please select both Department and Doctor for your in-person appointment.');
            }
        } else {
            const phone = phoneInput ? phoneInput.value : '';
            if (!phone) {
                e.preventDefault();
                alert('Please enter your phone number for the telehealth appointment.');
            }
        }
    });
</script>

</body>
</html>