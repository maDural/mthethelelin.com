<?php
include 'includes/header.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Insurance Information - Florida Medical Clinic</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .insurance-hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-align: center;
            padding: 80px 20px;
            margin-bottom: 50px;
        }
        
        .insurance-hero h1 {
            font-size: 48px;
            margin-bottom: 20px;
            animation: fadeInDown 1s ease;
        }
        
        .insurance-hero p {
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
        
        .insurance-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            margin-bottom: 60px;
        }
        
        .insurance-card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        
        .insurance-card:hover {
            transform: translateY(-5px);
        }
        
        .insurance-icon {
            font-size: 50px;
            margin-bottom: 20px;
        }
        
        .insurance-card h2 {
            color: #2c3e50;
            margin-bottom: 20px;
            font-size: 24px;
        }
        
        .insurance-card p {
            color: #666;
            line-height: 1.6;
            margin-bottom: 15px;
        }
        
        .insurance-list {
            list-style: none;
            padding: 0;
        }
        
        .insurance-list li {
            padding: 10px 0;
            border-bottom: 1px solid #eee;
            display: flex;
            align-items: center;
        }
        
        .insurance-list li:before {
            content: "✓";
            color: #28a745;
            font-weight: bold;
            margin-right: 10px;
        }
        
        .accepted-plans {
            background: #f8f9fa;
            padding: 40px;
            border-radius: 15px;
            margin-bottom: 50px;
        }
        
        .accepted-plans h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 30px;
        }
        
        .plans-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 20px;
        }
        
        .plan-item {
            background: white;
            padding: 20px;
            text-align: center;
            border-radius: 10px;
            transition: all 0.3s ease;
        }
        
        .plan-item:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        
        .plan-item h3 {
            color: #667eea;
            margin-bottom: 5px;
        }
        
        .faq-section {
            background: white;
            padding: 40px;
            border-radius: 15px;
            margin-bottom: 50px;
        }
        
        .faq-section h2 {
            color: #2c3e50;
            margin-bottom: 30px;
        }
        
        .faq-item {
            margin-bottom: 25px;
            border-bottom: 1px solid #eee;
            padding-bottom: 20px;
        }
        
        .faq-item h3 {
            color: #667eea;
            margin-bottom: 10px;
            cursor: pointer;
        }
        
        .faq-item p {
            color: #666;
            line-height: 1.6;
            display: none;
        }
        
        .faq-item.active p {
            display: block;
        }
        
        .cta-box {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-align: center;
            padding: 50px;
            border-radius: 15px;
        }
        
        .cta-box h2 {
            margin-bottom: 15px;
        }
        
        .cta-box p {
            margin-bottom: 25px;
        }
        
        .cta-btn {
            display: inline-block;
            padding: 12px 30px;
            background: white;
            color: #667eea;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .cta-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        @media (max-width: 768px) {
            .insurance-hero h1 { font-size: 32px; }
            .insurance-grid { grid-template-columns: 1fr; }
            .accepted-plans { padding: 25px; }
            .faq-section { padding: 25px; }
        }
        
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<div class="insurance-hero">
    <h1>Insurance Information</h1>
    <p>Understanding your coverage and payment options</p>
</div>

<div class="container">
    <div class="insurance-grid">
        <div class="insurance-card">
            <div class="insurance-icon">🏥</div>
            <h2>Accepted Insurance Plans</h2>
            <p>We accept most major insurance plans to ensure you have access to quality healthcare.</p>
            <ul class="insurance-list">
                <li>Medicare & Medicaid</li>
                <li>Blue Cross Blue Shield</li>
                <li>Aetna</li>
                <li>Cigna</li>
                <li>United Healthcare</li>
                <li>Humana</li>
                <li>Tricare</li>
                <li>WellCare</li>
                <li>Molina Healthcare</li>
            </ul>
        </div>
        
        <div class="insurance-card">
            <div class="insurance-icon">💳</div>
            <h2>Payment Options</h2>
            <p>We offer flexible payment options for your convenience.</p>
            <ul class="insurance-list">
                <li>Cash Payments</li>
                <li>Credit/Debit Cards (Visa, MasterCard, Amex)</li>
                <li>Personal Checks</li>
                <li>Health Savings Account (HSA)</li>
                <li>Flexible Spending Account (FSA)</li>
                <li>CareCredit Medical Financing</li>
                <li>Payment Plans Available</li>
            </ul>
        </div>
    </div>
    
    <div class="accepted-plans">
        <h2>📍 Insurance Plans We Accept</h2>
        <div class="plans-grid">
            <div class="plan-item"><h3>Medicare</h3><p>Part A, B, C, D</p></div>
            <div class="plan-item"><h3>Medicaid</h3><p>All Plans</p></div>
            <div class="plan-item"><h3>Blue Cross</h3><p>PPO, HMO, POS</p></div>
            <div class="plan-item"><h3>Aetna</h3><p>All Plans</p></div>
            <div class="plan-item"><h3>Cigna</h3><p>All Plans</p></div>
            <div class="plan-item"><h3>United HC</h3><p>All Plans</p></div>
            <div class="plan-item"><h3>Humana</h3><p>All Plans</p></div>
            <div class="plan-item"><h3>Tricare</h3><p>All Plans</p></div>
        </div>
    </div>
    
    <div class="faq-section">
        <h2>❓ Frequently Asked Questions</h2>
        <div class="faq-item">
            <h3>Do you accept my insurance plan?</h3>
            <p>We accept most major insurance plans. Please call our billing department at (555) 123-4567 to verify your specific plan coverage before your appointment.</p>
        </div>
        <div class="faq-item">
            <h3>What if I don't have insurance?</h3>
            <p>We offer self-pay discounts and flexible payment plans for patients without insurance. Please contact our billing department to discuss your options.</p>
        </div>
        <div class="faq-item">
            <h3>Do I need a referral to see a specialist?</h3>
            <p>This depends on your insurance plan. HMO plans typically require a referral from your primary care physician. PPO plans generally do not. Please check with your insurance provider.</p>
        </div>
        <div class="faq-item">
            <h3>What is my copay or coinsurance?</h3>
            <p>Copay and coinsurance amounts vary by insurance plan. Please contact your insurance provider or our billing department for specific information about your coverage.</p>
        </div>
    </div>
    
    <div class="cta-box">
        <h2>Have Questions About Billing?</h2>
        <p>Our billing specialists are here to help you understand your coverage</p>
        <a href="contact.php" class="cta-btn">Contact Billing Department</a>
    </div>
</div>

<script>
    document.querySelectorAll('.faq-item h3').forEach(item => {
        item.addEventListener('click', () => {
            item.parentElement.classList.toggle('active');
        });
    });
</script>

<?php include 'includes/footer.php'; ?>
</body>
</html>