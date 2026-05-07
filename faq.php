<?php
include 'includes/header.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>FAQ - Florida Medical Clinic</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* FAQ Page Styles */
        .faq-hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-align: center;
            padding: 80px 20px;
            margin-bottom: 50px;
        }
        
        .faq-hero h1 {
            font-size: 48px;
            margin-bottom: 20px;
            animation: fadeInDown 1s ease;
        }
        
        .faq-hero p {
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
        
        /* Search Section */
        .search-section {
            margin-bottom: 40px;
        }
        
        .search-box {
            max-width: 600px;
            margin: 0 auto;
            position: relative;
        }
        
        .search-box input {
            width: 100%;
            padding: 15px 50px 15px 20px;
            border: 2px solid #eee;
            border-radius: 50px;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        
        .search-box input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 10px rgba(102, 126, 234, 0.3);
        }
        
        .search-icon {
            position: absolute;
            right: 20px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 20px;
            color: #999;
        }
        
        /* Category Tabs */
        .category-tabs {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 15px;
            margin-bottom: 40px;
        }
        
        .category-btn {
            padding: 10px 25px;
            background: #f8f9fa;
            border: none;
            border-radius: 25px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s ease;
            color: #666;
        }
        
        .category-btn:hover {
            background: #e9ecef;
            transform: translateY(-2px);
        }
        
        .category-btn.active {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        
        /* FAQ Accordion */
        .faq-section {
            margin-bottom: 60px;
        }
        
        .faq-category {
            margin-bottom: 40px;
        }
        
        .faq-category h2 {
            color: #2c3e50;
            font-size: 28px;
            margin-bottom: 25px;
            padding-bottom: 10px;
            border-bottom: 3px solid #667eea;
            display: inline-block;
        }
        
        .faq-accordion {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 15px;
            overflow: hidden;
        }
        
        .faq-question {
            padding: 20px 25px;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.3s ease;
            background: white;
        }
        
        .faq-question:hover {
            background: #f8f9fa;
        }
        
        .faq-question h3 {
            margin: 0;
            font-size: 18px;
            color: #2c3e50;
            flex: 1;
        }
        
        .faq-toggle {
            font-size: 24px;
            color: #667eea;
            transition: transform 0.3s ease;
        }
        
        .faq-accordion.active .faq-toggle {
            transform: rotate(45deg);
        }
        
        .faq-answer {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
            background: #f8f9fa;
            border-top: 1px solid #eee;
        }
        
        .faq-accordion.active .faq-answer {
            max-height: 500px;
        }
        
        .faq-answer p {
            padding: 20px 25px;
            margin: 0;
            color: #666;
            line-height: 1.6;
        }
        
        .faq-answer ul, 
        .faq-answer ol {
            padding: 0 25px 20px 45px;
            margin: 0;
            color: #666;
            line-height: 1.6;
        }
        
        .faq-answer li {
            margin-bottom: 8px;
        }
        
        /* Still Have Questions Section */
        .still-questions {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-align: center;
            padding: 60px;
            border-radius: 15px;
            margin-bottom: 50px;
        }
        
        .still-questions h2 {
            font-size: 32px;
            margin-bottom: 15px;
        }
        
        .still-questions p {
            font-size: 18px;
            margin-bottom: 30px;
            opacity: 0.95;
        }
        
        .contact-buttons {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .contact-btn {
            display: inline-block;
            padding: 12px 30px;
            background: white;
            color: #667eea;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .contact-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
        }
        
        .contact-btn.outline {
            background: transparent;
            color: white;
            border: 2px solid white;
        }
        
        .contact-btn.outline:hover {
            background: white;
            color: #667eea;
        }
        
        /* No Results Message */
        .no-results {
            text-align: center;
            padding: 50px;
            background: #f8f9fa;
            border-radius: 15px;
            display: none;
        }
        
        .no-results.show {
            display: block;
        }
        
        .no-results h3 {
            color: #2c3e50;
            margin-bottom: 10px;
        }
        
        .no-results p {
            color: #666;
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
            .faq-hero h1 {
                font-size: 32px;
            }
            
            .faq-question h3 {
                font-size: 16px;
            }
            
            .faq-question {
                padding: 15px;
            }
            
            .still-questions {
                padding: 30px;
            }
            
            .still-questions h2 {
                font-size: 24px;
            }
            
            .category-btn {
                padding: 8px 18px;
                font-size: 12px;
            }
        }
    </style>
</head>
<body>

<!-- FAQ Hero Section -->
<div class="faq-hero">
    <h1>Frequently Asked Questions</h1>
    <p>Find answers to common questions about our services</p>
</div>

<div class="container">
    <!-- Search Section -->
    <div class="search-section">
        <div class="search-box">
            <input type="text" id="searchInput" placeholder="Search for answers...">
            <span class="search-icon">🔍</span>
        </div>
    </div>
    
    <!-- Category Tabs -->
    <div class="category-tabs">
        <button class="category-btn active" data-category="all">All Questions</button>
        <button class="category-btn" data-category="appointments">Appointments</button>
        <button class="category-btn" data-category="insurance">Insurance & Billing</button>
        <button class="category-btn" data-category="services">Medical Services</button>
        <button class="category-btn" data-category="patient">Patient Information</button>
        <button class="category-btn" data-category="telehealth">Telehealth</button>
    </div>
    
    <!-- No Results Message -->
    <div class="no-results" id="noResults">
        <h3>No results found</h3>
        <p>Try different keywords or browse the categories above</p>
    </div>
    
    <!-- FAQ Sections -->
    <div class="faq-section" id="faqSection">
        
        <!-- Appointments Category -->
        <div class="faq-category" data-category="appointments">
            <h2>📅 Appointments</h2>
            
            <div class="faq-accordion">
                <div class="faq-question">
                    <h3>How do I schedule an appointment?</h3>
                    <span class="faq-toggle">+</span>
                </div>
                <div class="faq-answer">
                    <p>You can schedule an appointment in several ways:</p>
                    <ul>
                        <li><strong>Online:</strong> Create an account and book through our patient portal</li>
                        <li><strong>Phone:</strong> Call us at (555) 123-4567</li>
                        <li><strong>In-person:</strong> Visit our clinic during business hours</li>
                        <li><strong>Email:</strong> Send a request to appointments@floridamedical.com</li>
                    </ul>
                </div>
            </div>
            
            <div class="faq-accordion">
                <div class="faq-question">
                    <h3>Do you accept walk-ins?</h3>
                    <span class="faq-toggle">+</span>
                </div>
                <div class="faq-answer">
                    <p>Yes, we accept walk-in patients during our regular business hours. However, we recommend scheduling an appointment to minimize wait times. For non-emergency walk-ins, you may experience longer wait times depending on provider availability.</p>
                </div>
            </div>
            
            <div class="faq-accordion">
                <div class="faq-question">
                    <h3>How do I cancel or reschedule an appointment?</h3>
                    <span class="faq-toggle">+</span>
                </div>
                <div class="faq-answer">
                    <p>Please provide at least 24 hours notice for cancellations or rescheduling. You can cancel or reschedule by:</p>
                    <ul>
                        <li>Logging into your patient portal</li>
                        <li>Calling our office at (555) 123-4567</li>
                        <li>Replying to your appointment confirmation email</li>
                    </ul>
                    <p>Late cancellations or no-shows may incur a fee.</p>
                </div>
            </div>
        </div>
        
        <!-- Insurance & Billing Category -->
        <div class="faq-category" data-category="insurance">
            <h2>💰 Insurance & Billing</h2>
            
            <div class="faq-accordion">
                <div class="faq-question">
                    <h3>What insurance plans do you accept?</h3>
                    <span class="faq-toggle">+</span>
                </div>
                <div class="faq-answer">
                    <p>We accept most major insurance plans including:</p>
                    <ul>
                        <li>Medicare & Medicaid</li>
                        <li>Blue Cross Blue Shield</li>
                        <li>Aetna</li>
                        <li>Cigna</li>
                        <li>United Healthcare</li>
                        <li>Humana</li>
                        <li>Tricare</li>
                    </ul>
                    <p>Please contact our billing department to verify your specific plan coverage.</p>
                </div>
            </div>
            
            <div class="faq-accordion">
                <div class="faq-question">
                    <h3>What payment methods do you accept?</h3>
                    <span class="faq-toggle">+</span>
                </div>
                <div class="faq-answer">
                    <p>We accept multiple payment methods:</p>
                    <ul>
                        <li>Cash</li>
                        <li>Credit/Debit Cards (Visa, MasterCard, American Express)</li>
                        <li>Personal Checks</li>
                        <li>Health Savings Account (HSA) cards</li>
                        <li>CareCredit for medical financing</li>
                    </ul>
                    <p>Payment is due at the time of service unless prior arrangements have been made.</p>
                </div>
            </div>
            
            <div class="faq-accordion">
                <div class="faq-question">
                    <h3>Do you offer payment plans?</h3>
                    <span class="faq-toggle">+</span>
                </div>
                <div class="faq-answer">
                    <p>Yes, we offer flexible payment plans for patients without insurance or with high out-of-pocket costs. Please speak with our billing department to discuss options that fit your budget. Financial assistance programs are also available for qualifying patients.</p>
                </div>
            </div>
        </div>
        
        <!-- Medical Services Category -->
        <div class="faq-category" data-category="services">
            <h2>🩺 Medical Services</h2>
            
            <div class="faq-accordion">
                <div class="faq-question">
                    <h3>What services do you offer?</h3>
                    <span class="faq-toggle">+</span>
                </div>
                <div class="faq-answer">
                    <p>We offer comprehensive medical services including:</p>
                    <ul>
                        <li>Primary Care & Family Medicine</li>
                        <li>Cardiology</li>
                        <li>Pediatrics</li>
                        <li>Women's Health (OB/GYN)</li>
                        <li>Neurology</li>
                        <li>Orthopedics</li>
                        <li>Dental Care</li>
                        <li>Laboratory & Diagnostic Services</li>
                        <li>Preventive Health Screenings</li>
                        <li>Vaccinations & Immunizations</li>
                    </ul>
                </div>
            </div>
            
            <div class="faq-accordion">
                <div class="faq-question">
                    <h3>Do you offer preventive health screenings?</h3>
                    <span class="faq-toggle">+</span>
                </div>
                <div class="faq-answer">
                    <p>Absolutely! Preventive care is essential for maintaining good health. We offer:</p>
                    <ul>
                        <li>Annual physical exams</li>
                        <li>Blood pressure and cholesterol screenings</li>
                        <li>Cancer screenings (mammograms, colonoscopies)</li>
                        <li>Diabetes screening</li>
                        <li>Bone density tests</li>
                        <li>Vision and hearing tests</li>
                    </ul>
                    <p>Many preventive screenings are covered by insurance at no additional cost.</p>
                </div>
            </div>
            
            <div class="faq-accordion">
                <div class="faq-question">
                    <h3>Do you have an on-site laboratory?</h3>
                    <span class="faq-toggle">+</span>
                </div>
                <div class="faq-answer">
                    <p>Yes, we have a fully equipped on-site laboratory for your convenience. Common tests performed include:</p>
                    <ul>
                        <li>Blood work and complete blood count (CBC)</li>
                        <li>Urinalysis</li>
                        <li>Rapid strep and flu tests</li>
                        <li>Pregnancy tests</li>
                        <li>Cholesterol and glucose testing</li>
                    </ul>
                    <p>Most test results are available within 24-48 hours.</p>
                </div>
            </div>
        </div>
        
        <!-- Patient Information Category -->
        <div class="faq-category" data-category="patient">
            <h2>📋 Patient Information</h2>
            
            <div class="faq-accordion">
                <div class="faq-question">
                    <h3>What should I bring to my first appointment?</h3>
                    <span class="faq-toggle">+</span>
                </div>
                <div class="faq-answer">
                    <p>Please bring the following items to your first visit:</p>
                    <ul>
                        <li>Valid photo ID (driver's license or passport)</li>
                        <li>Insurance card</li>
                        <li>List of current medications and dosages</li>
                        <li>Medical records from previous providers (if applicable)</li>
                        <li>Completed new patient forms (available on our website)</li>
                        <li>Payment method for copay or self-pay balance</li>
                    </ul>
                    <p>Arriving 15 minutes early for your appointment is recommended.</p>
                </div>
            </div>
            
            <div class="faq-accordion">
                <div class="faq-question">
                    <h3>How do I get my medical records?</h3>
                    <span class="faq-toggle">+</span>
                </div>
                <div class="faq-answer">
                    <p>You can request your medical records by:</p>
                    <ul>
                        <li><strong>Patient Portal:</strong> Download records instantly through our secure portal</li>
                        <li><strong>In-person:</strong> Visit our medical records department with photo ID</li>
                        <li><strong>Mail/Fax:</strong> Submit a signed release form</li>
                    </ul>
                    <p>Please allow 7-14 business days for record processing. There may be a nominal fee for copying and mailing records.</p>
                </div>
            </div>
            
            <div class="faq-accordion">
                <div class="faq-question">
                    <h3>How do I create a patient portal account?</h3>
                    <span class="faq-toggle">+</span>
                </div>
                <div class="faq-answer">
                    <p>Creating a patient portal account is easy! Simply:</p>
                    <ol>
                        <li>Visit our website and click "Login" or "Create Account"</li>
                        <li>Enter your personal information for verification</li>
                        <li>Create a username and secure password</li>
                        <li>Verify your email address</li>
                        <li>Start using the portal to access your health information</li>
                    </ol>
                    <p>If you need assistance, ask our front desk staff during your next visit.</p>
                </div>
            </div>
        </div>
        
        <!-- Telehealth Category -->
        <div class="faq-category" data-category="telehealth">
            <h2>💻 Telehealth</h2>
            
            <div class="faq-accordion">
                <div class="faq-question">
                    <h3>Do you offer telemedicine appointments?</h3>
                    <span class="faq-toggle">+</span>
                </div>
                <div class="faq-answer">
                    <p>Yes, we offer telemedicine appointments for many non-emergency conditions through our secure video platform. Telehealth is ideal for:</p>
                    <ul>
                        <li>Follow-up visits</li>
                        <li>Medication management</li>
                        <li>Minor illness consultations (cold, flu, allergies)</li>
                        <li>Mental health counseling</li>
                        <li>Review of test results</li>
                    </ul>
                    <p>Please call our office to schedule a telemedicine appointment.</p>
                </div>
            </div>
            
            <div class="faq-accordion">
                <div class="faq-question">
                    <h3>What do I need for a telemedicine visit?</h3>
                    <span class="faq-toggle">+</span>
                </div>
                <div class="faq-answer">
                    <p>To have a successful telemedicine visit, you will need:</p>
                    <ul>
                        <li>A smartphone, tablet, or computer with camera and microphone</li>
                        <li>Stable internet connection (Wi-Fi recommended)</li>
                        <li>Quiet, private space for your consultation</li>
                        <li>List of current symptoms and medications</li>
                        <li>Valid insurance information or payment method</li>
                    </ul>
                    <p>We'll send you a secure link before your appointment time.</p>
                </div>
            </div>
            
            <div class="faq-accordion">
                <div class="faq-question">
                    <h3>Is telemedicine covered by insurance?</h3>
                    <span class="faq-toggle">+</span>
                </div>
                <div class="faq-answer">
                    <p>Most insurance plans now cover telemedicine visits, often with the same copay as in-person visits. Medicare and Medicaid also cover telehealth services for many conditions. Please contact your insurance provider to verify your specific telehealth coverage benefits.</p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Still Have Questions Section -->
    <div class="still-questions">
        <h2>Still Have Questions?</h2>
        <p>Can't find the answer you're looking for? We're here to help!</p>
        <div class="contact-buttons">
            <a href="contact.php" class="contact-btn">Contact Us</a>
            <a href="tel:5551234567" class="contact-btn outline">Call Us Now</a>
        </div>
    </div>
</div>

<script>
    // Accordion functionality
    document.querySelectorAll('.faq-question').forEach(question => {
        question.addEventListener('click', () => {
            const accordion = question.parentElement;
            accordion.classList.toggle('active');
        });
    });
    
    // Category filter functionality
    const categoryBtns = document.querySelectorAll('.category-btn');
    const faqCategories = document.querySelectorAll('.faq-category');
    const noResults = document.getElementById('noResults');
    
    categoryBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            // Update active button
            categoryBtns.forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
            
            const category = btn.dataset.category;
            
            // Filter categories
            let hasResults = false;
            faqCategories.forEach(cat => {
                if (category === 'all' || cat.dataset.category === category) {
                    cat.style.display = 'block';
                    hasResults = true;
                } else {
                    cat.style.display = 'none';
                }
            });
            
            noResults.classList.remove('show');
            if (!hasResults) {
                noResults.classList.add('show');
            }
        });
    });
    
    // Search functionality
    const searchInput = document.getElementById('searchInput');
    
    function searchFAQs() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        const allQuestions = document.querySelectorAll('.faq-accordion');
        let hasResults = false;
        
        if (searchTerm === '') {
            // Show all FAQs and reset
            allQuestions.forEach(question => {
                question.style.display = '';
                question.classList.remove('active');
            });
            faqCategories.forEach(cat => cat.style.display = 'block');
            noResults.classList.remove('show');
            return;
        }
        
        // Search through questions and answers
        allQuestions.forEach(question => {
            const questionText = question.querySelector('.faq-question h3').textContent.toLowerCase();
            const answerText = question.querySelector('.faq-answer p')?.textContent.toLowerCase() || '';
            const listItems = question.querySelectorAll('.faq-answer li');
            let matched = questionText.includes(searchTerm) || answerText.includes(searchTerm);
            
            // Check list items
            listItems.forEach(item => {
                if (item.textContent.toLowerCase().includes(searchTerm)) {
                    matched = true;
                }
            });
            
            if (matched) {
                question.style.display = '';
                hasResults = true;
                question.classList.add('active');
            } else {
                question.style.display = 'none';
            }
        });
        
        // Show/hide empty categories
        faqCategories.forEach(cat => {
            const visibleQuestions = cat.querySelectorAll('.faq-accordion[style="display: block;"], .faq-accordion[style="display: "]');
            if (visibleQuestions.length === 0 && searchTerm !== '') {
                cat.style.display = 'none';
            } else {
                cat.style.display = 'block';
            }
        });
        
        // Show no results message
        if (!hasResults && searchTerm !== '') {
            noResults.classList.add('show');
        } else {
            noResults.classList.remove('show');
        }
    }
    
    searchInput.addEventListener('input', searchFAQs);
    
    // Open first FAQ by default (optional)
    document.querySelectorAll('.faq-accordion').forEach((accordion, index) => {
        if (index < 3) {
            accordion.classList.add('active');
        }
    });
</script>

<?php include 'includes/footer.php'; ?>
</body>
</html>