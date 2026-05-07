<?php
include 'includes/header.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Accessibility - Florida Medical Clinic</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .accessibility-hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-align: center;
            padding: 60px 20px;
            margin-bottom: 40px;
        }
        
        .accessibility-hero h1 {
            font-size: 42px;
            margin-bottom: 15px;
        }
        
        .container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 0 20px;
        }
        
        .accessibility-content {
            background: white;
            padding: 50px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            margin-bottom: 50px;
        }
        
        .accessibility-section {
            margin-bottom: 35px;
        }
        
        .accessibility-section h2 {
            color: #2c3e50;
            font-size: 24px;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #667eea;
        }
        
        .accessibility-section h3 {
            color: #667eea;
            font-size: 18px;
            margin: 20px 0 10px;
        }
        
        .accessibility-section p {
            color: #555;
            line-height: 1.7;
            margin-bottom: 15px;
        }
        
        .accessibility-section ul {
            margin: 15px 0 15px 25px;
            color: #555;
            line-height: 1.7;
        }
        
        .accessibility-section li {
            margin-bottom: 8px;
        }
        
        .commitment-box {
            background: linear-gradient(135deg, #667eea10 0%, #764ba210 100%);
            padding: 25px;
            border-radius: 10px;
            margin: 20px 0;
            text-align: center;
            border-left: 4px solid #667eea;
        }
        
        .feedback-form {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 10px;
            margin-top: 20px;
        }
        
        .feedback-form input, .feedback-form textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        
        .feedback-form button {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        
        @media (max-width: 768px) {
            .accessibility-hero h1 { font-size: 28px; }
            .accessibility-content { padding: 30px; }
        }
    </style>
</head>
<body>

<div class="accessibility-hero">
    <h1>Accessibility Statement</h1>
    <p>We are committed to providing accessible healthcare for everyone</p>
</div>

<div class="container">
    <div class="accessibility-content">
        <div class="commitment-box">
            <p style="font-size: 18px; margin: 0;"><strong>Our Commitment:</strong> Florida Medical Clinic is dedicated to ensuring that our website and services are accessible to all individuals, including those with disabilities.</p>
        </div>
        
        <div class="accessibility-section">
            <h2>Accessibility Features</h2>
            <p>Our website includes the following accessibility features:</p>
            <ul>
                <li><strong>Screen Reader Compatibility:</strong> Our site works with popular screen readers (JAWS, NVDA, VoiceOver)</li>
                <li><strong>Keyboard Navigation:</strong> Full functionality using keyboard only (Tab, Enter, Space keys)</li>
                <li><strong>Text Resizing:</strong> Ability to increase text size using browser controls (Ctrl + / Ctrl -)</li>
                <li><strong>High Contrast:</strong> Clear color contrast for better readability</li>
                <li><strong>Alt Text:</strong> Descriptive alternative text for all images</li>
                <li><strong>Clear Headings:</strong> Proper heading structure for easy navigation</li>
                <li><strong>Form Labels:</strong> All forms have clear, descriptive labels</li>
            </ul>
        </div>
        
        <div class="accessibility-section">
            <h2>Physical Accessibility</h2>
            <p>Our clinic facilities are designed with accessibility in mind:</p>
            <ul>
                <li>Wheelchair-accessible entrances and exam rooms</li>
                <li>Accessible parking spaces near building entrances</li>
                <li>Automatic door openers at main entrances</li>
                <li>Elevators to all floors</li>
                <li>Accessible restrooms on every floor</li>
                <li>Sign language interpreters available upon request</li>
                <li>Reading assistance for visually impaired patients</li>
            </ul>
        </div>
        
        <div class="accessibility-section">
            <h2>Assistive Technologies</h2>
            <p>We support various assistive technologies including:</p>
            <ul>
                <li>Screen magnifiers (ZoomText, Windows Magnifier)</li>
                <li>Speech recognition software (Dragon NaturallySpeaking)</li>
                <li>Screen readers (JAWS, NVDA, VoiceOver, TalkBack)</li>
                <li>Alternative input devices (trackballs, joysticks, touch screens)</li>
            </ul>
        </div>
        
        <div class="accessibility-section">
            <h2>Web Content Accessibility Guidelines (WCAG)</h2>
            <p>We strive to comply with WCAG 2.1 Level AA standards, which include:</p>
            <ul>
                <li><strong>Perceivable:</strong> Information and UI must be presentable to users in ways they can perceive</li>
                <li><strong>Operable:</strong> UI components and navigation must be operable</li>
                <li><strong>Understandable:</strong> Information and UI operation must be understandable</li>
                <li><strong>Robust:</strong> Content must be robust enough to be interpreted by various user agents</li>
            </ul>
        </div>
        
        <div class="accessibility-section">
            <h2>Mobile Accessibility</h2>
            <p>Our mobile-friendly website works on smartphones and tablets with accessibility features including:</p>
            <ul>
                <li>Responsive design that adapts to screen size</li>
                <li>Touch-optimized buttons and controls</li>
                <li>Support for mobile screen readers (VoiceOver, TalkBack)</li>
                <li>Sufficient touch target sizes</li>
            </ul>
        </div>
        
        <div class="accessibility-section">
            <h2>PDF and Document Accessibility</h2>
            <p>We strive to provide all downloadable documents in accessible formats. If you need an alternative format, please contact us.</p>
        </div>
        
        <div class="accessibility-section">
            <h2>Ongoing Efforts</h2>
            <p>We are continuously working to improve our accessibility by:</p>
            <ul>
                <li>Regular accessibility audits and testing</li>
                <li>Staff training on accessibility best practices</li>
                <li>Updating content to meet accessibility standards</li>
                <li>Incorporating user feedback for improvements</li>
            </ul>
        </div>
        
        <div class="accessibility-section">
            <h2>Third-Party Content</h2>
            <p>While we strive to ensure accessibility, some third-party content integrated into our site may not be fully accessible. We work with our partners to improve their accessibility.</p>
        </div>
        
        <div class="accessibility-section">
            <h2>Feedback and Assistance</h2>
            <p>We welcome your feedback on the accessibility of our website and services. If you experience any difficulty accessing any part of our site or need assistance, please contact us:</p>
            
            <div class="feedback-form">
                <h3 style="margin-bottom: 15px;">Request Assistance or Provide Feedback</h3>
                <form method="POST" action="">
                    <input type="text" name="name" placeholder="Your Name" required>
                    <input type="email" name="email" placeholder="Your Email" required>
                    <input type="tel" name="phone" placeholder="Phone Number">
                    <select name="assistance_type" required>
                        <option value="">Select Type</option>
                        <option value="accessibility_issue">Accessibility Issue</option>
                        <option value="assistance_request">Request Assistance</option>
                        <option value="feedback">Accessibility Feedback</option>
                    </select>
                    <textarea name="message" rows="4" placeholder="Please describe the issue or your request..." required></textarea>
                    <button type="submit" name="submit_feedback">Submit Request</button>
                </form>
            </div>
            
            <p style="margin-top: 20px;">You can also reach our Accessibility Coordinator directly:</p>
            <ul>
                <li><strong>Phone:</strong> (555) 123-4567 (TTY: 711 for relay service)</li>
                <li><strong>Email:</strong> accessibility@floridamedical.com</li>
                <li><strong>Address:</strong> 123 Medical Drive, Florida, FL 33101</li>
            </ul>
        </div>
        
        <div class="commitment-box">
            <p style="margin: 0;">We are committed to providing equal access to healthcare for all individuals. Your feedback helps us improve.</p>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
</body>
</html>