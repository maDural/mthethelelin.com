<!-- Footer -->
<footer class="gradient-5">
    <div class="footer-container">
        <div class="footer-grid">
            <!-- Column 1: About Us -->
            <div class="footer-col">
                <h3>Florida Medical Clinic</h3>
                <p>Providing quality healthcare services with compassion and excellence. Your health is our priority.</p>
                <div class="social-links">
                    <a href="https://www.facebook.com/ma.dura.3110/" target="_blank" class="social-icon fb">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://twitter.com/" target="_blank" class="social-icon tw">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="https://www.instagram.com/ma_dura7/" target="_blank" class="social-icon ig">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="https://wa.me/27722021793" target="_blank" class="social-icon wa">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                </div>
            </div>

            <!-- Column 2: Quick Links -->
            <div class="footer-col">
                <h3>Quick Links</h3>
                <ul class="footer-links">
                    <li><a href="index.php">🏠 Home</a></li>
                    <li><a href="about.php">👨‍⚕️ About Us</a></li>
                    <li><a href="services.php">🩺 Our Services</a></li>
                    <li><a href="contact.php">📞 Contact Us</a></li>
                </ul>
            </div>

            <!-- Column 3: Patient Resources -->
            <div class="footer-col">
                <h3>Patient Resources</h3>
                <ul class="footer-links">
                    <li><a href="faq.php">❓ FAQs</a></li>
                    <li><a href="insurance.php">🏥 Insurance Info</a></li>
                    <li><a href="medical-records.php">📋 Medical Records</a></li>
                    <li><a href="telehealth.php">💻 Telehealth</a></li>
                </ul>
            </div>

            <!-- Column 4: Contact Info -->
            <div class="footer-col">
                <h3>Contact Info</h3>
                <ul class="contact-info">
                    <li>📍 123 Medical Drive, Florida, FL 33101</li>
                    <li>📞 (+27) 722 021 793</li>
                    <li>✉️ mthethelelin7@gmail..com</li>
                    <li>🕒 Mon-Fri: 8am - 8pm<br>Sat-Sun: 9am - 5pm</li>
                </ul>
            </div>
        </div>

        <!-- Bottom Bar -->
        <div class="footer-bottom">
            <div class="footer-bottom-content">
                <p>&copy; 2026 Florida Medical Clinic. All Rights Reserved. Designed by Ma Dural</p>
                <div class="footer-legal">
                    <a href="privacy.php">Privacy Policy</a> |
                    <a href="terms.php">Terms of Service</a> |
                    <a href="accessibility.php">Accessibility</a> |
                    <a href="sitemap.php">Sitemap</a>
                </div>
            </div>
        </div>
    </div>
</footer>

<!-- Font Awesome Icons (Add this in your header or before closing body) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>
    /* Enhanced Footer Styles */
    .footer-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 20px 20px;
    }
    
    .footer-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 30px;
        margin-bottom: 30px;
    }
    
    .footer-col h3 {
        color: white;
        font-size: 18px;
        margin-bottom: 20px;
        position: relative;
        display: inline-block;
    }
    
    .footer-col h3::after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 0;
        width: 40px;
        height: 3px;
        background: #4facfe;
        border-radius: 2px;
    }
    
    .footer-col p {
        color: rgba(255, 255, 255, 0.8);
        line-height: 1.6;
        font-size: 14px;
    }
    
    .footer-links, .contact-info {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .footer-links li, .contact-info li {
        margin-bottom: 12px;
    }
    
    .footer-links a, .contact-info li {
        color: rgba(255, 255, 255, 0.8);
        text-decoration: none;
        transition: all 0.3s ease;
        font-size: 14px;
        display: inline-block;
    }
    
    .footer-links a:hover {
        color: white;
        transform: translateX(5px);
    }
    
    .social-links {
        display: flex;
        gap: 15px;
        margin-top: 20px;
    }
    
    .social-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        transition: all 0.3s ease;
        font-size: 18px;
        color: white;
        text-decoration: none;
    }
    
    /* Individual social media hover colors */
    .social-icon.fb:hover {
        background: #1877f2;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(24, 119, 242, 0.4);
    }
    
    .social-icon.tw:hover {
        background: #1da1f2;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(29, 161, 242, 0.4);
    }
    
    .social-icon.ig:hover {
        background: linear-gradient(45deg, #f09433, #d62976, #962fbf);
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(210, 41, 118, 0.4);
    }
    
    .social-icon.wa:hover {
        background: #25d366;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(37, 211, 102, 0.4);
    }
    
    .footer-bottom {
        border-top: 1px solid rgba(255, 255, 255, 0.1);
        padding-top: 20px;
        margin-top: 20px;
    }
    
    .footer-bottom-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }
    
    .footer-bottom p {
        margin: 0;
        font-size: 13px;
        color: rgba(255, 255, 255, 0.7);
    }
    
    .footer-legal a {
        color: rgba(255, 255, 255, 0.7);
        text-decoration: none;
        margin: 0 10px;
        font-size: 12px;
        transition: color 0.3s ease;
    }
    
    .footer-legal a:hover {
        color: white;
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .footer-grid {
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }
        
        .footer-bottom-content {
            flex-direction: column;
            text-align: center;
        }
        
        .footer-legal a {
            margin: 0 5px;
        }
    }
    
    @media (max-width: 480px) {
        .footer-grid {
            grid-template-columns: 1fr;
            text-align: center;
        }
        
        .footer-col h3::after {
            left: 50%;
            transform: translateX(-50%);
        }
        
        .social-links {
            justify-content: center;
        }
    }
</style>

</body>
</html>