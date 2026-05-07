<?php
include 'includes/header.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sitemap - Florida Medical Clinic</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .sitemap-hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-align: center;
            padding: 60px 20px;
            margin-bottom: 40px;
        }
        
        .sitemap-hero h1 {
            font-size: 42px;
            margin-bottom: 15px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .sitemap-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 40px;
            margin-bottom: 50px;
        }
        
        .sitemap-column {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        
        .sitemap-column h2 {
            color: #2c3e50;
            font-size: 24px;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #667eea;
        }
        
        .sitemap-list {
            list-style: none;
            padding: 0;
        }
        
        .sitemap-list li {
            margin-bottom: 12px;
        }
        
        .sitemap-list a {
            color: #555;
            text-decoration: none;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
        }
        
        .sitemap-list a:hover {
            color: #667eea;
            transform: translateX(5px);
        }
        
        .sitemap-list .icon {
            margin-right: 10px;
            font-size: 18px;
        }
        
        .sitemap-list .sub-links {
            margin-left: 28px;
            margin-top: 8px;
            margin-bottom: 8px;
        }
        
        .sitemap-list .sub-links li {
            margin-bottom: 8px;
        }
        
        .sitemap-footer {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }
        
        @media (max-width: 768px) {
            .sitemap-hero h1 { font-size: 28px; }
            .sitemap-column { padding: 20px; }
        }
    </style>
</head>
<body>

<div class="sitemap-hero">
    <h1>Site Map</h1>
    <p>Find your way around our website - all pages organized for easy navigation</p>
</div>

<div class="container">
    <div class="sitemap-grid">
        <!-- Column 1: Main Pages -->
        <div class="sitemap-column">
            <h2>🏠 Main Pages</h2>
            <ul class="sitemap-list">
                <li><a href="index.php"><span class="icon">🏠</span> Home</a></li>
                <li><a href="about.php"><span class="icon">👨‍⚕️</span> About Us</a></li>
                <li><a href="services.php"><span class="icon">🩺</span> Our Services</a></li>
                <li><a href="contact.php"><span class="icon">📞</span> Contact Us</a></li>
                <li><a href="faq.php"><span class="icon">❓</span> FAQ</a></li>
                <li><a href="sitemap.php"><span class="icon">🗺️</span> Site Map</a></li>
            </ul>
        </div>
        
        <!-- Column 2: Patient Portal -->
        <div class="sitemap-column">
            <h2>🔐 Patient Portal</h2>
            <ul class="sitemap-list">
                <li><a href="register.php"><span class="icon">📝</span> Create Account</a></li>
                <li><a href="login.php"><span class="icon">🔑</span> Login</a></li>
                <li><a href="dashboard.php"><span class="icon">📊</span> Dashboard</a></li>
                <li><a href="appointment.php"><span class="icon">📅</span> Book Appointment</a></li>
                <li><a href="forgot.php"><span class="icon">🔒</span> Forgot Password</a></li>
                <li><a href="reset_password.php"><span class="icon">🔄</span> Reset Password</a></li>
            </ul>
        </div>
        
        <!-- Column 3: Medical Services -->
        <div class="sitemap-column">
            <h2>🩺 Medical Services</h2>
            <ul class="sitemap-list">
                <li><a href="services.php#primary"><span class="icon">🏥</span> Primary Care</a></li>
                <li><a href="services.php#cardiology"><span class="icon">❤️</span> Cardiology</a></li>
                <li><a href="services.php#neurology"><span class="icon">🧠</span> Neurology</a></li>
                <li><a href="services.php#pediatrics"><span class="icon">👶</span> Pediatrics</a></li>
                <li><a href="services.php#womens"><span class="icon">👩</span> Women's Health</a></li>
                <li><a href="services.php#dental"><span class="icon">🦷</span> Dental Care</a></li>
            </ul>
        </div>
        
        <!-- Column 4: Patient Resources -->
        <div class="sitemap-column">
            <h2>📋 Patient Resources</h2>
            <ul class="sitemap-list">
                <li><a href="insurance.php"><span class="icon">💰</span> Insurance Info</a></li>
                <li><a href="medical-records.php"><span class="icon">📄</span> Medical Records</a></li>
                <li><a href="telehealth.php"><span class="icon">💻</span> Telehealth</a></li>
                <li><a href="appointment.php"><span class="icon">📅</span> Book Appointment</a></li>
                <li><a href="faq.php"><span class="icon">❓</span> FAQs</a></li>
            </ul>
        </div>
        
        <!-- Column 5: Legal & Policies -->
        <div class="sitemap-column">
            <h2>⚖️ Legal & Policies</h2>
            <ul class="sitemap-list">
                <li><a href="privacy.php"><span class="icon">🔒</span> Privacy Policy</a></li>
                <li><a href="terms.php"><span class="icon">📜</span> Terms of Service</a></li>
                <li><a href="accessibility.php"><span class="icon">♿</span> Accessibility</a></li>
                <li><a href="privacy.php#hipaa"><span class="icon">🏥</span> HIPAA Compliance</a></li>
            </ul>
        </div>
        
        <!-- Column 6: Contact Information -->
        <div class="sitemap-column">
            <h2>📞 Contact Info</h2>
            <ul class="sitemap-list">
                <li><a href="contact.php"><span class="icon">📧</span> Contact Form</a></li>
                <li><a href="tel:5551234567"><span class="icon">📞</span> Call Us: (555) 123-4567</a></li>
                <li><a href="mailto:info@floridamedical.com"><span class="icon">✉️</span> Email Us</a></li>
                <li><a href="contact.php#map"><span class="icon">📍</span> Find Our Location</a></li>
                <li><a href="contact.php#hours"><span class="icon">🕒</span> Business Hours</a></li>
            </ul>
        </div>
    </