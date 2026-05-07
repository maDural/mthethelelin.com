<?php
session_start();
include 'includes/db.php';

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}

// Handle appointment status update
if (isset($_POST['update_status'])) {
    $appointment_id = mysqli_real_escape_string($conn, $_POST['appointment_id']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $appointment_type = mysqli_real_escape_string($conn, $_POST['appointment_type']);
    
    if ($appointment_type == 'in_person') {
        $query = "UPDATE appointments SET status = '$status' WHERE id = '$appointment_id'";
    } else {
        $query = "UPDATE telehealth_appointments SET status = '$status' WHERE id = '$appointment_id'";
    }
    
    if ($conn->query($query)) {
        $success = "Appointment status updated successfully!";
        // Refresh the page to show updated data
        header("refresh:1;url=admin_dashboard.php");
    } else {
        $error = "Error updating status: " . $conn->error;
    }
}

// Fetch all appointments
$in_person_query = "SELECT * FROM appointments ORDER BY appointment_date DESC, appointment_time ASC";
$in_person_result = $conn->query($in_person_query);

$telehealth_query = "SELECT * FROM telehealth_appointments ORDER BY appointment_date DESC, appointment_time ASC";
$telehealth_result = $conn->query($telehealth_query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - Florida Medical Clinic</title>
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
        
        /* Top Bar */
        .top-bar {
            background: linear-gradient(135deg, #1a2980 0%, #26d0ce 100%);
            color: white;
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
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
        
        .logout-btn:hover {
            background: #c0392b;
        }
        
        /* Stats Section */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            padding: 30px;
            max-width: 1400px;
            margin: 0 auto;
        }
        
        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .stat-number {
            font-size: 36px;
            font-weight: bold;
            color: #667eea;
        }
        
        .stat-label {
            color: #666;
            margin-top: 5px;
        }
        
        /* Appointments Section */
        .appointments-section {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 30px 30px;
        }
        
        .section-title {
            font-size: 24px;
            color: #2c3e50;
            margin: 20px 0;
            padding-bottom: 10px;
            border-bottom: 3px solid #667eea;
        }
        
        .appointment-table {
            background: white;
            border-radius: 15px;
            overflow-x: auto;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 800px;
        }
        
        th {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px;
            text-align: left;
            font-weight: 600;
        }
        
        td {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
        }
        
        tr:hover {
            background: #f8f9fa;
        }
        
        .status-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
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
        
        select {
            padding: 5px 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
            font-size: 12px;
        }
        
        .update-btn {
            background: #667eea;
            color: white;
            border: none;
            padding: 5px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 12px;
        }
        
        .update-btn:hover {
            background: #764ba2;
        }
        
        .success {
            background: #d4edda;
            color: #155724;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
        }
        
        .no-data {
            text-align: center;
            padding: 40px;
            color: #666;
        }
        
        .doctor-name {
            font-size: 13px;
            color: #555;
        }
        
        @media (max-width: 768px) {
            .stats-container {
                padding: 20px;
                gap: 15px;
            }
            
            .appointments-section {
                padding: 0 20px 20px;
            }
            
            .top-bar h1 {
                font-size: 18px;
            }
            
            .nav-links a {
                margin-left: 8px;
                padding: 5px 10px;
                font-size: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="top-bar">
        <h1>👨‍⚕️ Admin Dashboard - Florida Medical Clinic</h1>
        <div class="nav-links">
            <a href="admin_dashboard.php" style="background: rgba(255,255,255,0.2);">Appointments</a>
            <a href="admin_medical_requests.php">Medical Records</a>
            <a href="admin_feedback.php">📝 Feedback</a>
            <a href="admin_contact_messages.php">📧 Messages</a>
            <a href="admin_logout.php" class="logout-btn">Logout</a>
        </div>
    </div>
    
    <?php
    // Calculate statistics
    $total_in_person = $in_person_result ? $in_person_result->num_rows : 0;
    $total_telehealth = $telehealth_result ? $telehealth_result->num_rows : 0;
    
    $pending_count = 0;
    $confirmed_count = 0;
    $completed_count = 0;
    $cancelled_count = 0;
    
    if ($in_person_result && $in_person_result->num_rows > 0) {
        $in_person_result->data_seek(0);
        while ($row = $in_person_result->fetch_assoc()) {
            $status = $row['status'] ?? 'pending';
            if ($status == 'pending') $pending_count++;
            if ($status == 'confirmed') $confirmed_count++;
            if ($status == 'completed') $completed_count++;
            if ($status == 'cancelled') $cancelled_count++;
        }
        $in_person_result->data_seek(0);
    }
    
    if ($telehealth_result && $telehealth_result->num_rows > 0) {
        $telehealth_result->data_seek(0);
        while ($row = $telehealth_result->fetch_assoc()) {
            $status = $row['status'] ?? 'pending';
            if ($status == 'pending') $pending_count++;
            if ($status == 'confirmed') $confirmed_count++;
            if ($status == 'completed') $completed_count++;
            if ($status == 'cancelled') $cancelled_count++;
        }
        $telehealth_result->data_seek(0);
    }
    ?>
    
    <div class="stats-container">
        <div class="stat-card">
            <div class="stat-number"><?php echo $total_in_person + $total_telehealth; ?></div>
            <div class="stat-label">Total Appointments</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" style="color: #856404;"><?php echo $pending_count; ?></div>
            <div class="stat-label">Pending Approval</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" style="color: #155724;"><?php echo $confirmed_count; ?></div>
            <div class="stat-label">Confirmed</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" style="color: #004085;"><?php echo $completed_count; ?></div>
            <div class="stat-label">Completed</div>
        </div>
        <div class="stat-card">
            <div class="stat-number" style="color: #721c24;"><?php echo $cancelled_count; ?></div>
            <div class="stat-label">Cancelled</div>
        </div>
    </div>
    
    <div class="appointments-section">
        <?php if (isset($success)): ?>
            <div class="success">✅ <?php echo $success; ?></div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
            <div class="error">❌ <?php echo $error; ?></div>
        <?php endif; ?>
        
        <!-- In-Person Appointments -->
        <h2 class="section-title">🏥 In-Person Appointments</h2>
        <div class="appointment-table">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Patient Name</th>
                        <th>Email</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Department</th>
                        <th>Doctor</th>
                        <th>Reason</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($in_person_result && $in_person_result->num_rows > 0): ?>
                        <?php while ($row = $in_person_result->fetch_assoc()): ?>
                            <?php 
                            $status = $row['status'] ?? 'pending';
                            $status_class = '';
                            switch($status) {
                                case 'confirmed': $status_class = 'status-confirmed'; break;
                                case 'completed': $status_class = 'status-completed'; break;
                                case 'cancelled': $status_class = 'status-cancelled'; break;
                                default: $status_class = 'status-pending';
                            }
                            ?>
                            <tr>
                                <td>#<?php echo $row['id']; ?></td>
                                <td><?php echo htmlspecialchars($row['fullname'] ?? 'N/A'); ?></td>
                                <td><?php echo htmlspecialchars($row['email'] ?? 'N/A'); ?></td>
                                <td><?php echo date('M d, Y', strtotime($row['appointment_date'])); ?></td>
                                <td><?php echo date('g:i A', strtotime($row['appointment_time'])); ?></td>
                                <td><?php echo ucfirst(str_replace('_', ' ', $row['department'] ?? 'N/A')); ?></td>
                                <td class="doctor-name"><?php echo htmlspecialchars($row['doctor'] ?? 'N/A'); ?></td>
                                <td><?php echo substr(htmlspecialchars($row['reason'] ?? ''), 0, 40); ?>...</td>
                                <td>
                                    <span class="status-badge <?php echo $status_class; ?>">
                                        <?php echo ucfirst($status); ?>
                                    </span>
                                </td>
                                <td>
                                    <form method="POST" style="display: flex; gap: 5px; flex-wrap: wrap;">
                                        <input type="hidden" name="appointment_id" value="<?php echo $row['id']; ?>">
                                        <input type="hidden" name="appointment_type" value="in_person">
                                        <select name="status">
                                            <option value="pending" <?php echo ($status == 'pending') ? 'selected' : ''; ?>>Pending</option>
                                            <option value="confirmed" <?php echo ($status == 'confirmed') ? 'selected' : ''; ?>>Confirm</option>
                                            <option value="completed" <?php echo ($status == 'completed') ? 'selected' : ''; ?>>Completed</option>
                                            <option value="cancelled" <?php echo ($status == 'cancelled') ? 'selected' : ''; ?>>Cancel</option>
                                        </select>
                                        <button type="submit" name="update_status" class="update-btn">Update</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="10" class="no-data">📭 No in-person appointments found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Telehealth Appointments -->
        <h2 class="section-title">💻 Telehealth Appointments</h2>
        <div class="appointment-table">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Patient Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Reason</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($telehealth_result && $telehealth_result->num_rows > 0): ?>
                        <?php while ($row = $telehealth_result->fetch_assoc()): ?>
                            <?php 
                            $status = $row['status'] ?? 'pending';
                            $status_class = '';
                            switch($status) {
                                case 'confirmed': $status_class = 'status-confirmed'; break;
                                case 'completed': $status_class = 'status-completed'; break;
                                case 'cancelled': $status_class = 'status-cancelled'; break;
                                default: $status_class = 'status-pending';
                            }
                            ?>
                            <tr>
                                <td>#<?php echo $row['id']; ?></td>
                                <td><?php echo htmlspecialchars($row['fullname'] ?? 'N/A'); ?></td>
                                <td><?php echo htmlspecialchars($row['email'] ?? 'N/A'); ?></td>
                                <td><?php echo htmlspecialchars($row['phone'] ?? 'N/A'); ?></td>
                                <td><?php echo date('M d, Y', strtotime($row['appointment_date'])); ?></td>
                                <td><?php echo date('g:i A', strtotime($row['appointment_time'])); ?></td>
                                <td><?php echo substr(htmlspecialchars($row['reason'] ?? ''), 0, 40); ?>...</td>
                                <td>
                                    <span class="status-badge <?php echo $status_class; ?>">
                                        <?php echo ucfirst($status); ?>
                                    </span>
                                </td>
                                <td>
                                    <form method="POST" style="display: flex; gap: 5px; flex-wrap: wrap;">
                                        <input type="hidden" name="appointment_id" value="<?php echo $row['id']; ?>">
                                        <input type="hidden" name="appointment_type" value="telehealth">
                                        <select name="status">
                                            <option value="pending" <?php echo ($status == 'pending') ? 'selected' : ''; ?>>Pending</option>
                                            <option value="confirmed" <?php echo ($status == 'confirmed') ? 'selected' : ''; ?>>Confirm</option>
                                            <option value="completed" <?php echo ($status == 'completed') ? 'selected' : ''; ?>>Completed</option>
                                            <option value="cancelled" <?php echo ($status == 'cancelled') ? 'selected' : ''; ?>>Cancel</option>
                                        </select>
                                        <button type="submit" name="update_status" class="update-btn">Update</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="9" class="no-data">📭 No telehealth appointments found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        
        <!-- Quick Links -->
        <div style="margin-top: 20px; text-align: center; display: flex; gap: 15px; justify-content: center; flex-wrap: wrap;">
            <a href="admin_medical_requests.php" style="background: #667eea; color: white; padding: 10px 20px; text-decoration: none; border-radius: 8px;">
                📋 View Medical Record Requests
            </a>
            <a href="admin_feedback.php" style="background: #28a745; color: white; padding: 10px 20px; text-decoration: none; border-radius: 8px;">
                📝 View Patient Feedback
            </a>
            <a href="admin_contact_messages.php" style="background: #17a2b8; color: white; padding: 10px 20px; text-decoration: none; border-radius: 8px;">
                ✉️ View Contact Messages
            </a>
        </div>
    </div>
</body>
</html>