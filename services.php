<?php
include 'includes/header.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Our Services - Florida Medical Clinic</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Services Page Styles */
        .services-hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-align: center;
            padding: 80px 20px;
            margin-bottom: 50px;
        }
        
        .services-hero h1 {
            font-size: 48px;
            margin-bottom: 20px;
            animation: fadeInDown 1s ease;
        }
        
        .services-hero p {
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
        
        /* Featured Services Section */
        .featured-section {
            margin-bottom: 60px;
        }
        
        .featured-section h2 {
            text-align: center;
            color: #2c3e50;
            font-size: 36px;
            margin-bottom: 40px;
        }
        
        .services-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-bottom: 40px;
        }
        
        .service-card {
            background: white;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        
        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
        }
        
        .service-icon {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px;
            text-align: center;
            font-size: 60px;
            color: white;
        }
        
        .service-content {
            padding: 25px;
        }
        
        .service-content h3 {
            color: #2c3e50;
            font-size: 22px;
            margin-bottom: 15px;
        }
        
        .service-content p {
            color: #666;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        
        .service-link {
            display: inline-block;
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .service-link:hover {
            color: #764ba2;
            transform: translateX(5px);
        }
        
        /* Department Sections */
        .department-section {
            background: #f8f9fa;
            padding: 60px;
            border-radius: 15px;
            margin-bottom: 50px;
        }
        
        .department-section h2 {
            color: #2c3e50;
            font-size: 32px;
            margin-bottom: 30px;
            text-align: center;
        }
        
        .department-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
        }
        
        .department-item {
            background: white;
            padding: 25px;
            border-radius: 10px;
            text-align: center;
            transition: all 0.3s ease;
        }
        
        .department-item:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        
        .department-icon {
            font-size: 40px;
            margin-bottom: 15px;
        }
        
        .department-item h3 {
            color: #667eea;
            margin-bottom: 10px;
        }
        
        .department-item p {
            color: #666;
            font-size: 14px;
            line-height: 1.6;
        }
        
        /* Why Choose Us Section */
        .why-choose-us {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 60px;
            border-radius: 15px;
            margin-bottom: 50px;
            text-align: center;
        }
        
        .why-choose-us h2 {
            font-size: 36px;
            margin-bottom: 40px;
        }
        
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 30px;
        }
        
        .feature {
            text-align: center;
        }
        
        .feature-icon {
            font-size: 45px;
            margin-bottom: 15px;
        }
        
        .feature h3 {
            font-size: 18px;
            margin-bottom: 10px;
        }
        
        .feature p {
            font-size: 14px;
            opacity: 0.9;
        }
        
        /* CTA Section */
        .cta-section {
            background: #2c3e50;
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
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .cta-button:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
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
            .services-hero h1 {
                font-size: 32px;
            }
            
            .department-section {
                padding: 30px;
            }
            
            .why-choose-us {
                padding: 30px;
            }
            
            .why-choose-us h2 {
                font-size: 28px;
            }
            
            .cta-section h2 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>

<!-- Services Hero Section -->
<div class="services-hero">
    <h1>Our Medical Services</h1>
    <p>Comprehensive healthcare services tailored to meet your needs</p>
</div>

<div class="container">
    <!-- Featured Services -->
    <div class="featured-section">
        <h2>Featured Services</h2>
        <div class="services-grid">
            <div class="service-card">
                <div class="service-icon">🏥</div>
                <div class="service-content">
                    <h3>Primary Care</h3>
                    <p>Comprehensive primary care services for patients of all ages. Regular check-ups, preventive care, and management of chronic conditions.</p>
                    <a href="#" class="service-link">Learn More →</a>
                </div>
            </div>
            
            <div class="service-card">
                <div class="service-icon">❤️</div>
                <div class="service-content">
                    <h3>Cardiology</h3>
                    <p>Expert heart care including diagnostics, treatment, and preventive cardiology. Advanced cardiac imaging and stress testing available.</p>
                    <a href="#" class="service-link">Learn More →</a>
                </div>
            </div>
            
            <div class="service-card">
                <div class="service-icon">🧠</div>
                <div class="service-content">
                    <h3>Neurology</h3>
                    <p>Specialized care for nervous system disorders. Treatment for migraines, epilepsy, Parkinson's, and other neurological conditions.</p>
                    <a href="#" class="service-link">Learn More →</a>
                </div>
            </div>
            
            <div class="service-card">
                <div class="service-icon">🦷</div>
                <div class="service-content">
                    <h3>Dental Care</h3>
                    <p>Complete dental services including cleanings, fillings, crowns, and cosmetic dentistry. Family-friendly dental care.</p>
                    <a href="#" class="service-link">Learn More →</a>
                </div>
            </div>
            
            <div class="service-card">
                <div class="service-icon">👶</div>
                <div class="service-content">
                    <h3>Pediatrics</h3>
                    <p>Compassionate care for children from birth through adolescence. Well-child visits, vaccinations, and developmental screenings.</p>
                    <a href="#" class="service-link">Learn More →</a>
                </div>
            </div>
            
            <div class="service-card">
                <div class="service-icon">👩‍⚕️</div>
                <div class="service-content">
                    <h3>Women's Health</h3>
                    <p>Comprehensive women's health services including obstetrics, gynecology, mammography, and reproductive health.</p>
                    <a href="#" class="service-link">Learn More →</a>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Medical Departments -->
    <div class="department-section">
        <h2>Our Medical Departments</h2>
        <div class="department-grid">
            <div class="department-item">
                <div class="department-icon">🩺</div>
                <h3>Internal Medicine</h3>
                <p>Diagnosis and treatment of adult diseases</p>
            </div>
            <div class="department-item">
                <div class="department-icon">🦴</div>
                <h3>Orthopedics</h3>
                <p>Bone, joint, and muscle care</p>
            </div>
            <div class="department-item">
                <div class="department-icon">👁️</div>
                <h3>Ophthalmology</h3>
                <p>Eye care and vision services</p>
            </div>
            <div class="department-item">
                <div class="department-icon">🫁</div>
                <h3>Pulmonology</h3>
                <p>Lung and respiratory care</p>
            </div>
            <div class="department-item">
                <div class="department-icon">🩸</div>
                <h3>Endocrinology</h3>
                <p>Hormone and metabolic disorders</p>
            </div>
            <div class="department-item">
                <div class="department-icon">🧪</div>
                <h3>Laboratory</h3>
                <p>Diagnostic testing and results</p>
            </div>
        </div>
    </div>
    
    <!-- Why Choose Us -->
    <div class="why-choose-us">
        <h2>Why Choose Florida Medical Clinic?</h2>
        <div class="features-grid">
            <div class="feature">
                <div class="feature-icon">⭐</div>
                <h3>Experienced Doctors</h3>
                <p>Board-certified physicians with years of experience</p>
            </div>
            <div class="feature">
                <div class="feature-icon">🏆</div>
                <h3>Modern Technology</h3>
                <p>State-of-the-art medical equipment and facilities</p>
            </div>
            <div class="feature">
                <div class="feature-icon">💚</div>
                <h3>Patient-Centered Care</h3>
                <p>Personalized treatment plans for every patient</p>
            </div>
            <div class="feature">
                <div class="feature-icon">🕒</div>
                <h3>Flexible Hours</h3>
                <p>Extended hours and weekend appointments available</p>
            </div>
        </div>
    </div>
    
    <!-- Insurance & Payment -->
    <div class="department-section">
        <h2>Insurance & Payment Options</h2>
        <div class="department-grid">
            <div class="department-item">
                <div class="department-icon">📋</div>
                <h3>Insurance Accepted</h3>
                <p>We accept most major insurance plans including Medicare and Medicaid</p>
            </div>
            <div class="department-item">
                <div class="department-icon">💳</div>
                <h3>Flexible Payment</h3>
                <p>Payment plans and financial assistance available</p>
            </div>
            <div class="department-item">
                <div class="department-icon">🏦</div>
                <h3>Self-Pay Options</h3>
                <p>Affordable rates for uninsured patients</p>
            </div>
            <div class="department-item">
                <div class="department-icon">📱</div>
                <h3>Online Payments</h3>
                <p>Easy and secure online bill payment system</p>
            </div>
        </div>
    </div>
    
    <!-- CTA Section -->
    <div class="cta-section">
        <h2>Ready to Schedule an Appointment?</h2>
        <p>Book your visit today and experience quality healthcare</p>
        <a href="register.php" class="cta-button">Create Account Now</a>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
</body>
</html>