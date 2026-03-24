<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'MHD Print Lab') }} - متجر احترافي</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="{{ asset('resources/views/products/custom-styles.css') }}">
    <style>
        /* Pro Store Styles - Nike/Adidas Level */
        :root {
            --primary-blue: linear-gradient(135deg, #0f172a 0%, #1e40af 50%, #3b82f6 100%);
            --glass-bg: rgba(255,255,255,0.1);
            --glass-border: rgba(255,255,255,0.2);
        }
        
        body { font-family: 'Tajawal', sans-serif; }
        
        .header-pro {
            background: rgba(15, 23, 42, 0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--glass-border);
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        .header-inner {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 80px;
        }
        
        .logo-pro {
            font-size: 2rem;
            font-weight: 900;
            background: var(--primary-blue);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            text-decoration: none;
        }
        
        .header-actions {
            display: flex;
            gap: 2rem;
            align-items: center;
        }
        
        .search-pro {
            position: relative;
            width: 400px;
        }
        
        .search-input {
            width: 100%;
            padding: 12px 20px 12px 50px;
            border: 2px solid var(--glass-border);
            border-radius: 50px;
            background: var(--glass-bg);
            color: white;
            font-size: 1rem;
            backdrop-filter: blur(10px);
            transition: all 0.3s ease;
        }
        
        .search-input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59,130,246,0.2);
            background: rgba(255,255,255,0.15);
            outline: none;
        }
        
        .search-icon {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
        }
        
        .cart-icon {
            width: 28px;
            height: 28px;
            color: white;
            cursor: pointer;
            position: relative;
        }
        
        .hero-banner {
            height: 60vh;
            background: var(--primary-blue);
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }
        
        .hero-content h1 {
            font-size: clamp(3rem, 8vw, 6rem);
            font-weight: 900;
            margin-bottom: 1rem;
            text-shadow: 0 4px 20px rgba(0,0,0,0.5);
        }
        
        .hero-content p {
            font-size: 1.5rem;
            opacity: 0.95;
            max-width: 600px;
            margin: 0 auto 3rem;
        }
        
        .cta-hero {
            background: rgba(255,255,255,0.2);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255,255,255,0.3);
            color: white;
            padding: 1.5rem 4rem;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1.2rem;
            text-decoration: none;
            transition: all 0.4s ease;
            display: inline-block;
        }
        
        .cta-hero:hover {
            background: rgba(255,255,255,0.3);
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
        }
        
        .section-title {
            font-size: 3rem;
            font-weight: 900;
            background: var(--primary-blue);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            text-align: center;
            margin: 5rem 0 3rem;
        }
        
        .categories-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            margin-bottom: 5rem;
        }
        
        .category-card {
            background: white;
            border-radius: var(--card-radius);
            padding: 2rem;
            text-align: center;
            box-shadow: var(--blue-glow);
            transition: all 0.4s ease;
            border: 1px solid rgba(59,130,246,0.1);
            cursor: pointer;
            height: 200px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .category-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 30px 60px rgba(59,130,246,0.3);
        }
        
        .footer {
            background: #0f172a;
            color: white;
            padding: 4rem 0 2rem;
            margin-top: 8rem;
        }
        
        .footer-content {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 2rem;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 3rem;
        }
        
        @media (max-width: 768px) {
            .header-inner {
                padding: 0 1rem;
                flex-direction: column;
                gap: 1rem;
                height: auto;
                padding: 1rem;
            }
            
            .search-pro {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <!-- Header Pro -->
    <header class="header-pro">
        <div class="header-inner">
            <a href="/" class="logo-pro">MHD Print Lab</a>
            
            <div class="header-actions">
                <div class="search-pro">
                    <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="20" height="20">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="search" class="search-input" placeholder="ابحث عن المنتجات...">
                </div>
                <svg class="cart-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 6.5a2 2 0 002 1.5h11a2 2 0 002-1.5l-1.5-6.5M3 3h18M16 13V6a1 1 0 00-1-1h-4a1 1 0 00-1 1v7"/>
                </svg>
            </div>
        </div>
    </header>

    <main>
        @yield('content')
    </main>

    <!-- Footer Pro -->
    <footer class="footer">
        <div class="footer-content">
            <div>
                <h3 style="font-size: 1.5rem; margin-bottom: 1rem;">MHD Print Lab</h3>
                <p style="opacity: 0.8; line-height: 1.7;">أفضل المنتجات بأسعار تنافسية مع خدمة عملاء ممتازة</p>
            </div>
            <div>
                <h4 style="margin-bottom: 1rem;">الروابط</h4>
                <ul style="list-style: none; padding: 0;">
                    <li><a href="#" style="color: #94a3b8; text-decoration: none; opacity: 0.8;">الرئيسية</a></li>
                    <li><a href="#" style="color: #94a3b8; text-decoration: none; opacity: 0.8;">المنتجات</a></li>
                    <li><a href="#" style="color: #94a3b8; text-decoration: none; opacity: 0.8;">واتساب</a></li>
                </ul>
            </div>
            <div>
                <h4 style="margin-bottom: 1rem;">اتصل بنا</h4>
                <p style="opacity: 0.8;">واتساب: 963982617848</p>
            </div>
        </div>
        <div style="text-align: center; margin-top: 3rem; padding-top: 2rem; border-top: 1px solid rgba(255,255,255,0.1); opacity: 0.7;">
            © 2024 MHD Print Lab. جميع الحقوق محفوظة.
        </div>
    </footer>
</body>
</html>
