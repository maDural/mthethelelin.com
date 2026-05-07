<?php
include 'includes/db.php';
include 'includes/header.php';

$success = '';
$error = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['send_message'])) {
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    
    $query = "INSERT INTO contact_messages (fullname, email, phone, subject, message, status, created_at) 
              VALUES ('$fullname', '$email', '$phone', '$subject', '$message', 'unread', NOW())";
    
    if ($conn->query($query)) {
        $success = "✅ Thank you for your message! We will get back to you within 24 hours.";
    } else {
        $error = "❌ Error sending message. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Contact Us - Florida Medical Clinic</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Contact Page Styles */
        .contact-hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-align: center;
            padding: 80px 20px;
            margin-bottom: 50px;
        }
        
        .contact-hero h1 {
            font-size: 48px;
            margin-bottom: 20px;
            animation: fadeInDown 1s ease;
        }
        
        .contact-hero p {
            font-size: 20px;
            max-width: 600px;
            margin: 0 auto;
            animation: fadeInUp 1s ease;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        /* Contact Grid */
        .contact-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-bottom: 60px;
        }
        
        /* Contact Info Section */
        .contact-info-section {
            background: #f8f9fa;
            padding: 40px;
            border-radius: 15px;
        }
        
        .contact-info-section h2 {
            color: #2c3e50;
            font-size: 28px;
            margin-bottom: 30px;
        }
        
        .info-item {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
            padding: 15px;
            background: white;
            border-radius: 10px;
            transition: transform 0.3s ease;
        }
        
        .info-item:hover {
            transform: translateX(10px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .info-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 25px;
            margin-right: 20px;
            color: white;
        }
        
        .info-details h3 {
            color: #2c3e50;
            margin-bottom: 5px;
            font-size: 18px;
        }
        
        .info-details p {
            color: #666;
            margin: 0;
            line-height: 1.5;
        }
        
        .info-details a {
            color: #666;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .info-details a:hover {
            color: #667eea;
        }
        
        /* Business Hours */
        .business-hours {
            background: white;
            padding: 25px;
            border-radius: 10px;
            margin-top: 20px;
        }
        
        .business-hours h3 {
            color: #2c3e50;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .hours-list {
            list-style: none;
            padding: 0;
        }
        
        .hours-list li {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }
        
        .hours-list li:last-child {
            border-bottom: none;
        }
        
        .day {
            color: #2c3e50;
            font-weight: 600;
        }
        
        .time {
            color: #667eea;
        }
        
        /* Contact Form Section */
        .contact-form-section {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        
        .contact-form-section h2 {
            color: #2c3e50;
            font-size: 28px;
            margin-bottom: 10px;
        }
        
        .form-subtitle {
            color: #666;
            margin-bottom: 30px;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        .form-group label {
            display: block;
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 8px;
        }
        
        .required {
            color: #e74c3c;
        }
        
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 5px rgba(102, 126, 234, 0.3);
        }
        
        .form-group textarea {
            resize: vertical;
            min-height: 120px;
        }
        
        .submit-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 14px 30px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            transition: all 0.3s ease;
        }
        
        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        
        .success {
            background: #d4edda;
            color: #155724;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            border-left: 4px solid #28a745;
        }
        
        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            text-align: center;
            border-left: 4px solid #dc3545;
        }
        
        /* Map Section */
        .map-section {
            margin-bottom: 60px;
        }
        
        .map-section h2 {
            text-align: center;
            color: #2c3e50;
            font-size: 32px;
            margin-bottom: 30px;
        }
        
        .map-container {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        
        .map-placeholder {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-align: center;
            padding: 80px;
        }
        
        .map-placeholder h3 {
            font-size: 24px;
            margin-bottom: 10px;
        }
        
        /* FAQ Section */
        .faq-section {
            background: #f8f9fa;
            padding: 60px;
            border-radius: 15px;
            margin-bottom: 50px;
        }
        
        .faq-section h2 {
            text-align: center;
            color: #2c3e50;
            font-size: 32px;
            margin-bottom: 40px;
        }
        
        .faq-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }
        
        .faq-item {
            background: white;
            padding: 25px;
            border-radius: 10px;
            transition: all 0.3s ease;
        }
        
        .faq-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        
        .faq-item h3 {
            color: #667eea;
            margin-bottom: 15px;
            font-size: 18px;
        }
        
        .faq-item p {
            color: #666;
            line-height: 1.6;
        }
        
        /* CTA Section */
        .cta-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-align: center;
            padding: 60px 20px;
            border-radius: 15px;
            margin-bottom: 50px;
        }
        
        .cta-section h2 {
            font-size: 32px;
            margin-bottom: 20px;
        }
        
        .cta-section p {
            font-size: 18px;
            margin-bottom: 30px;
        }
        
        .cta-button {
            display: inline-block;
            padding: 15px 40px;
            background: white;
            color: #667eea;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .cta-button:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
        }
        
        /* Feedback Button */
        .feedback-btn {
            display: inline-block;
            padding: 12px 30px;
            background: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
            margin-top: 15px;
        }
        
        .feedback-btn:hover {
            transform: scale(1.05);
            background: #218838;
            box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
        }
        
        /* Animations */
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        /* Responsive */
        @media (max-width: 768px) {
            .contact-hero h1 {
                font-size: 32px;
            }
            
            .contact-grid {
                grid-template-columns: 1fr;
            }
            
            .contact-info-section,
            .contact-form-section {
                padding: 25px;
            }
            
            .info-item {
                flex-direction: column;
                text-align: center;
            }
            
            .info-icon {
                margin-right: 0;
                margin-bottom: 15px;
            }
            
            .faq-section {
                padding: 30px;
            }
            
            .map-placeholder {
                padding: 40px;
            }
        }
    </style>
</head>
<body>

<!-- Contact Hero Section -->
<div class="contact-hero">
    <h1>Contact Us</h1>
    <p>We're here to help. Reach out to us anytime</p>
</div>

<div class="container">
    <div class="contact-grid">
        <!-- Contact Info Section -->
        <div class="contact-info-section">
            <h2>Get in Touch</h2>
            
            <div class="info-item">
                <div class="info-icon">📍</div>
                <div class="info-details">
                    <h3>Our Location</h3>
                    <p>123 Medical Drive<br>Florida, FL 33101<br>United States</p>
                </div>
            </div>
            
            <div class="info-item">
                <div class="info-icon">📞</div>
                <div class="info-details">
                    <h3>Phone Number</h3>
                    <p>Main: (555) 123-4567<br>Emergency: (555) 123-4568<br>Fax: (555) 123-4569</p>
                </div>
            </div>
            
            <div class="info-item">
                <div class="info-icon">✉️</div>
                <div class="info-details">
                    <h3>Email Address</h3>
                    <p><a href="mailto:info@floridamedical.com">info@floridamedical.com</a><br>
                    <a href="mailto:appointments@floridamedical.com">appointments@floridamedical.com</a></p>
                </div>
            </div>
            
            <div class="business-hours">
                <h3>🕒 Business Hours</h3>
                <ul class="hours-list">
                    <li><span class="day">Monday - Friday</span><span class="time">8:00 AM - 8:00 PM</span></li>
                    <li><span class="day">Saturday</span><span class="time">9:00 AM - 5:00 PM</span></li>
                    <li><span class="day">Sunday</span><span class="time">9:00 AM - 3:00 PM</span></li>
                    <li><span class="day">Emergency</span><span class="time">24/7 Available</span></li>
                </ul>
            </div>
            
            <!-- Feedback Button -->
            <div style="margin-top: 30px; text-align: center;">
                <a href="submit_feedback.php" class="feedback-btn">📝 Give Us Feedback</a>
            </div>
        </div>
        
        <!-- Contact Form Section -->
        <div class="contact-form-section">
            <h2>Send Us a Message</h2>
            <p class="form-subtitle">We'll get back to you within 24 hours</p>
            
            <?php if ($success): ?>
                <div class="success">✅ <?php echo $success; ?></div>
            <?php endif; ?>
            
            <?php if ($error): ?>
                <div class="error">❌ <?php echo $error; ?></div>
            <?php endif; ?>
            
            <form method="POST" action="">
                <div class="form-group">
                    <label>Full Name <span class="required">*</span></label>
                    <input type="text" name="fullname" required>
                </div>
                
                <div class="form-group">
                    <label>Email Address <span class="required">*</span></label>
                    <input type="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label>Phone Number</label>
                    <input type="tel" name="phone">
                </div>
                
                <div class="form-group">
                    <label>Subject <span class="required">*</span></label>
                    <select name="subject" required>
                        <option value="">Select a subject</option>
                        <option value="appointment">Book an Appointment</option>
                        <option value="question">General Question</option>
                        <option value="billing">Billing Inquiry</option>
                        <option value="records">Medical Records</option>
                        <option value="feedback">Feedback / Suggestion</option>
                        <option value="other">Other</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Message <span class="required">*</span></label>
                    <textarea name="message" placeholder="Type your message here..." required></textarea>
                </div>
                
                <button type="submit" name="send_message" class="submit-btn">📧 Send Message</button>
            </form>
        </div>
    </div>
    
    <!-- Map Section -->
    <div class="map-section">
        <h2>Find Us Here</h2>
        <div class="map-container">
            <div class="map-placeholder">
                <h3>📍 Florida Medical Clinic</h3>
                <p>123 Medical Drive, Florida, FL 33101</p>
                <p style="margin-top: 20px;">Interactive Map Would Load Here</p>
                <small>Free parking available for all patients</small>
            </div>
        </div>
    </div>
    
    <!-- FAQ Section -->
    <div class="faq-section">
        <h2>Frequently Asked Questions</h2>
        <div class="faq-grid">
            <div class="faq-item">
                <h3>How do I schedule an appointment?</h3>
                <p>You can schedule an appointment by calling our office, using our online booking system, or by visiting us in person.</p>
            </div>
            <div class="faq-item">
                <h3>What insurance plans do you accept?</h3>
                <p>We accept most major insurance plans including Medicare, Medicaid, Blue Cross, Aetna, Cigna, and United Healthcare.</p>
            </div>
            <div class="faq-item">
                <h3>Do you offer telemedicine services?</h3>
                <p>Yes, we offer virtual consultations for follow-up visits and minor concerns. Contact us to schedule a telemedicine appointment.</p>
            </div>
            <div class="faq-item">
                <h3>What should I bring to my first visit?</h3>
                <p>Please bring your insurance card, photo ID, medical records, and a list of current medications.</p>
            </div>
            <div class="faq-item">
                <h3>How do I get my medical records?</h3>
                <p>You can request your medical records by visiting our office or submitting a request through our patient portal.</p>
            </div>
            <div class="faq-item">
                <h3>Do you accept walk-ins?</h3>
                <p>Yes, we accept walk-ins during business hours. However, appointments are recommended for shorter wait times.</p>
            </div>
        </div>
    </div>
    
    <!-- CTA Section -->
    <div class="cta-section">
        <h2>Need Immediate Assistance?</h2>
        <p>For emergencies, please call us immediately or visit our emergency department</p>
        <a href="tel:5551234568" class="cta-button">Call Emergency: (555) 123-4568</a>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
</body>
</html>