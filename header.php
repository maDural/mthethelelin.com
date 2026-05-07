<!DOCTYPE html>
<html>
<head>
    <title>Doctor Website</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header>
    <div class="header-container">
        <div class="logo">
            <h2>🏥 My Medical Practice</h2>
        </div>
        <nav>
         <a href="admin_login.php" style="background: rgba(0,0,0,0.2);">👨‍💼 Admin</a>
        </nav>
        <div class="mobile-menu-btn">☰</div>
    </div>
</header>

<style>
    /* Header Styles */
    header {
        background: linear-gradient(135deg, #1a2980 0%, #26d0ce 100%);
        padding: 0;
        position: sticky;
        top: 0;
        z-index: 1000;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }
    
    .header-container {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 30px;
    }
    
    .logo h2 {
        margin: 0;
        font-size: 24px;
        font-weight: 600;
        color: white;
        text-shadow: 2px 2px 4px rgba(0,0,0,0.2);
        transition: transform 0.3s ease;
    }
    
    .logo h2:hover {
        transform: scale(1.05);
    }
    
    nav {
        display: flex;
        gap: 25px;
        align-items: center;
    }
    
    nav a {
        color: white;
        text-decoration: none;
        font-size: 16px;
        font-weight: 500;
        padding: 8px 20px;
        border-radius: 25px;
        transition: all 0.3s ease;
        position: relative;
    }
    
    nav a:hover {
        background: rgba(255,255,255,0.2);
        transform: translateY(-2px);
    }
    
    nav a::before {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        transform: translateX(-50%);
        width: 0;
        height: 2px;
        background: white;
        transition: width 0.3s ease;
    }
    
    nav a:hover::before {
        width: 80%;
    }
    
    /* Active page indicator */
    nav a.active {
        background: rgba(255,255,255,0.25);
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }
    
    .mobile-menu-btn {
        display: none;
        font-size: 28px;
        color: white;
        cursor: pointer;
    }
    
    /* Responsive Design */
    @media (max-width: 768px) {
        .header-container {
            padding: 12px 20px;
        }
        
        .logo h2 {
            font-size: 18px;
        }
        
        nav {
            gap: 10px;
        }
        
        nav a {
            padding: 6px 12px;
            font-size: 14px;
        }
    }
    
    @media (max-width: 480px) {
        .header-container {
            flex-wrap: wrap;
        }
        
        nav {
            flex-direction: column;
            width: 100%;
            gap: 10px;
            margin-top: 15px;
            display: none;
        }
        
        nav.show {
            display: flex;
        }
        
        nav a {
            width: 100%;
            text-align: center;
            padding: 10px;
        }
        
        .mobile-menu-btn {
            display: block;
        }
    }
</style>

<script>
    // Mobile menu toggle
    document.querySelector('.mobile-menu-btn')?.addEventListener('click', function() {
        document.querySelector('nav').classList.toggle('show');
    });
</script>

</body>
</html>