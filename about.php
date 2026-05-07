<?php
include 'includes/header.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>About Us - Florida Medical Clinic</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* About Page Specific Styles */
        .about-hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-align: center;
            padding: 80px 20px;
            margin-bottom: 50px;
        }
        
        .about-hero h1 {
            font-size: 48px;
            margin-bottom: 20px;
            animation: fadeInDown 1s ease;
        }
        
        .about-hero p {
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
        
        /* Mission & Vision Section */
        .mission-vision {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            margin-bottom: 60px;
        }
        
        .mv-card {
            background: white;
            padding: 40px 30px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        
        .mv-card:hover {
            transform: translateY(-10px);
        }
        
        .mv-icon {
            font-size: 50px;
            margin-bottom: 20px;
        }
        
        .mv-card h2 {
            color: #2c3e50;
            margin-bottom: 20px;
            font-size: 28px;
        }
        
        .mv-card p {
            color: #666;
            line-height: 1.6;
        }
        
        /* Story Section */
        .story-section {
            background: #f8f9fa;
            padding: 60px;
            border-radius: 15px;
            margin-bottom: 50px;
        }
        
        .story-section h2 {
            text-align: center;
            color: #2c3e50;
            font-size: 36px;
            margin-bottom: 30px;
        }
        
        .story-content {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            align-items: center;
        }
        
        .story-text p {
            color: #666;
            line-height: 1.8;
            margin-bottom: 20px;
        }
        
        .story-image {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 15px;
            padding: 60px;
            text-align: center;
            color: white;
        }
        
        .story-image .placeholder-icon {
            font-size: 80px;
            margin-bottom: 20px;
        }
        
        /* Values Section */
        .values-section {
            margin-bottom: 60px;
        }
        
        .values-section h2 {
            text-align: center;
            color: #2c3e50;
            font-size: 36px;
            margin-bottom: 40px;
        }
        
        .values-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
        }
        
        .value-card {
            text-align: center;
            padding: 30px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }
        
        .value-card:hover {
            box-shadow: 0 5px 25px rgba(0,0,0,0.15);
            transform: translateY(-5px);
        }
        
        .value-icon {
            font-size: 45px;
            margin-bottom: 15px;
        }
        
        .value-card h3 {
            color: #667eea;
            margin-bottom: 15px;
        }
        
        .value-card p {
            color: #666;
            line-height: 1.6;
        }
        
        /* Team Section */
        .team-section {
            background: #f8f9fa;
            padding: 60px 0;
            border-radius: 15px;
            margin-bottom: 50px;
        }
        
        .team-section h2 {
            text-align: center;
            color: #2c3e50;
            font-size: 36px;
            margin-bottom: 40px;
        }
        
        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 30px;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .team-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            text-align: center;
            transition: transform 0.3s ease;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }
        
        .team-card:hover {
            transform: translateY(-5px);
        }
        
        .team-photo {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px;
            color: white;
        }
        
        .team-photo .doctor-icon {
            font-size: 70px;
        }
        
        .team-card h3 {
            margin: 20px 0 5px;
            color: #2c3e50;
        }
        
        .team-title {
            color: #667eea;
            font-weight: 600;
            margin-bottom: 10px;
        }
        
        .team-desc {
            color: #666;
            padding: 0 20px 20px;
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
            .about-hero h1 {
                font-size: 32px;
            }
            
            .story-content {
                grid-template-columns: 1fr;
            }
            
            .mv-card h2 {
                font-size: 24px;
            }
            
            .cta-section h2 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>

<!-- About Hero Section -->
<div class="about-hero">
    <h1>About Florida Medical Clinic</h1>
    <p>Providing exceptional healthcare with compassion, innovation, and excellence since 1990</p>
</div>

<div class="container">
    <!-- Mission & Vision -->
    <div class="mission-vision">
        <div class="mv-card">
            <div class="mv-icon">🎯</div>
            <h2>Our Mission</h2>
            <p>To provide compassionate, high-quality healthcare services that improve the health and well-being of our community, treating every patient with dignity, respect, and personalized attention.</p>
        </div>
        
        <div class="mv-card">
            <div class="mv-icon">👁️</div>
            <h2>Our Vision</h2>
            <p>To be the leading healthcare provider in Florida, recognized for clinical excellence, innovative treatments, and exceptional patient experiences.</p>
        </div>
    </div>
     
    <!-- Our Story -->
<div class="story-section">
    <h2>Our Story</h2>
    <div class="story-content">
        <div class="story-text">
            <p>Founded in 1990, Florida Medical Clinic began with a simple yet powerful vision: to create a healthcare facility where patients receive not just medical treatment, but genuine care and compassion. What started as a small practice with just three doctors has grown into one of Florida's most trusted medical institutions.</p>
            <p>Over the past three decades, we've expanded our services, brought in top medical talent, and invested in cutting-edge technology. Despite our growth, we've never lost sight of what matters most - our patients. Every decision we make, every service we offer, is designed with your health and comfort in mind.</p>
            <p>Today, Florida Medical Clinic serves thousands of patients annually, offering comprehensive medical services across multiple specialties. We're proud to be an integral part of the Florida community, and we look forward to continuing our mission of healing and caring for generations to come.</p>
        </div>
        <div class="story-image">
            <img src="Dash.jpeg" alt="Florida Medical Clinic" class="story-img">
        </div>
    </div>
</div>
    
    <!-- Our Values -->
    <div class="values-section">
        <h2>Our Core Values</h2>
        <div class="values-grid">
            <div class="value-card">
                <div class="value-icon">❤️</div>
                <h3>Compassion</h3>
                <p>We treat every patient with empathy, kindness, and understanding, recognizing their unique needs and concerns.</p>
            </div>
            <div class="value-card">
                <div class="value-icon">⭐</div>
                <h3>Excellence</h3>
                <p>We strive for the highest standards in medical care, continuously improving our skills and services.</p>
            </div>
            <div class="value-card">
                <div class="value-icon">🤝</div>
                <h3>Integrity</h3>
                <p>We are honest, ethical, and transparent in all our interactions with patients, families, and colleagues.</p>
            </div>
            <div class="value-card">
                <div class="value-icon">💡</div>
                <h3>Innovation</h3>
                <p>We embrace new technologies and treatment methods to provide the best possible care.</p>
            </div>
            <div class="value-card">
                <div class="value-icon">🌍</div>
                <h3>Community</h3>
                <p>We are committed to improving the health and well-being of our local community.</p>
            </div>
            <div class="value-card">
                <div class="value-icon">🤲</div>
                <h3>Respect</h3>
                <p>We honor the dignity and worth of every person who walks through our doors.</p>
            </div>
        </div>
    </div>
    
    <!-- Our Team -->
<div class="team-section">
    <h2>Meet Our Leadership Team</h2>
    <div class="team-grid">
        <div class="team-card">
            <div class="team-photo">
                <img src="images/doctor1.jpg" alt="Dr. Mthetheleli Ndlovu" class="doctor-image">
            </div>
            <h3>Dr. Mthetheleli Ndlovu</h3>
            <div class="team-title">Chief Medical Officer</div>
            <div class="team-desc">20+ years of experience in internal medicine. Harvard Medical School graduate.</div>
        </div>
        
        <div class="team-card">
            <div class="team-photo">
                <img src="images/doctor2.jpg" alt="Dr. Nompumelelo Phungula" class="doctor-image">
            </div>
            <h3>Dr. Nompumelelo Phungula</h3>
            <div class="team-title">Head of Pediatrics</div>
            <div class="team-desc">Dedicated to child healthcare with 15 years of pediatric experience.</div>
        </div>
        
        <div class="team-card">
            <div class="team-photo">
                <img src="images/doctor3.png" alt="Dr. Likhona Mgaga" class="doctor-image">
            </div>
            <h3>Dr. Likhona Mgaga</h3>
            <div class="team-title">Chief of Surgery</div>
            <div class="team-desc">Leading surgeon with expertise in minimally invasive procedures.</div>
        </div>
        

    </div>
</div>
    
    <!-- CTA Section -->
    <div class="cta-section">
        <h2>Ready to Experience Quality Healthcare?</h2>
        <p>Join thousands of satisfied patients who trust us with their health</p>
        <a href="register.php" class="cta-button">Create Account Today</a>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
</body>
</html>