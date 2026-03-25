<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'MHD Print Lab') }} - متجر احترافي</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    
<link rel="stylesheet" href="{{ asset('css/custom-styles.css') }}">
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
            padding: 0 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: auto;
            min-height: 70px;
            gap: 1rem;
            flex-wrap: wrap;
        }
        
        .logo-pro {
            font-size: clamp(1.2rem, 3vw, 2rem);
            font-weight: 900;
            background: var(--primary-blue);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            text-decoration: none;
            flex-shrink: 0;
        }
        
        .header-actions {
            display: flex;
            gap: 0.8rem;
            align-items: center;
            flex-wrap: wrap;
            width: 100%;
            padding: 0.5rem 0;
        }
        
        .search-pro {
            position: relative;
            width: 100%;
            min-width: 200px;
            flex: 1;
            max-width: 400px;
        }
        
        .search-input {
            width: 100%;
            padding: 10px 16px 10px 40px;
            border: 2px solid var(--glass-border);
            border-radius: 50px;
            background: var(--glass-bg);
            color: white;
            font-size: 0.95rem;
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
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            width: 18px;
            height: 18px;
        }
        
        .cart-icon {
            width: 24px;
            height: 24px;
            color: white;
            cursor: pointer;
            position: relative;
            flex-shrink: 0;
        }
        
        .hero-banner {
            height: 60vh;
            min-height: 300px;
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
            font-size: clamp(1.8rem, 5vw, 6rem);
            font-weight: 900;
            margin-bottom: 1rem;
            text-shadow: 0 4px 20px rgba(0,0,0,0.5);
            padding: 0 1rem;
        }
        
        .hero-content p {
            font-size: clamp(1rem, 3vw, 1.5rem);
            opacity: 0.95;
            max-width: 600px;
            margin: 0 auto 3rem;
            padding: 0 1rem;
        }
        
        .cta-hero {
            background: rgba(255,255,255,0.2);
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255,255,255,0.3);
            color: white;
            padding: clamp(0.8rem, 2vw, 1.5rem) clamp(1.5rem, 3vw, 4rem);
            border-radius: 50px;
            font-weight: 700;
            font-size: clamp(0.9rem, 2vw, 1.2rem);
            text-decoration: none;
            transition: all 0.4s ease;
            display: inline-block;
            margin: 0 0.5rem;
        }
        
        .cta-hero:hover {
            background: rgba(255,255,255,0.3);
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
        }
        
        .section-title {
            font-size: clamp(1.5rem, 4vw, 3rem);
            font-weight: 900;
            background: var(--primary-blue);
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
            text-align: center;
            margin: 3rem 1rem 2rem;
            padding: 0 1rem;
        }
        
        .categories-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
            padding: 0 1rem;
            max-width: 1400px;
            margin-left: auto;
            margin-right: auto;
        }
        
        .category-card {
            background: white;
            border-radius: var(--card-radius);
            padding: 1.5rem 1rem;
            text-align: center;
            box-shadow: var(--blue-glow);
            transition: all 0.4s ease;
            border: 1px solid rgba(59,130,246,0.1);
            cursor: pointer;
            height: auto;
            min-height: 150px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            font-size: clamp(0.9rem, 2vw, 1rem);
        }
        
        .category-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 30px 60px rgba(59,130,246,0.3);
        }
        
        .footer {
            background: #0f172a;
            color: white;
            padding: 3rem 1rem 2rem;
            margin-top: 4rem;
        }
        
        .footer-content {
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
        }
        
        @media (max-width: 1024px) {
            .section-title {
                font-size: clamp(1.3rem, 3vw, 2.5rem);
                margin: 2rem 1rem;
            }
            
            .categories-grid {
                gap: 1rem;
            }
        }
        
        @media (max-width: 768px) {
            .header-pro {
                padding: 0.5rem 0;
            }
            
            .header-inner {
                padding: 0.5rem 0.5rem;
                min-height: 60px;
            }
            
            .header-actions {
                gap: 0.5rem;
                width: 100%;
            }
            
            .search-pro {
                order: 3;
                width: 100%;
                max-width: 100%;
                min-width: unset;
            }
            
            .search-input {
                font-size: 16px;
            }
            
            .hero-banner {
                height: 50vh;
                min-height: 280px;
                padding: 1rem;
            }
            
            .hero-content h1 {
                font-size: clamp(1.5rem, 4vw, 2.5rem);
                margin-bottom: 0.8rem;
            }
            
            .hero-content p {
                font-size: clamp(0.9rem, 2vw, 1.1rem);
                margin: 0 auto 1.5rem;
                max-width: 100%;
            }
            
            .cta-hero {
                padding: clamp(0.6rem, 1.5vw, 1rem) clamp(1rem, 2vw, 2rem);
                font-size: clamp(0.8rem, 1.5vw, 1rem);
            }
            
            .category-card {
                min-height: 120px;
                padding: 1rem;
                font-size: 0.9rem;
            }
            
            .footer-content {
                grid-template-columns: 1fr;
                gap: 1.5rem;
                text-align: center;
            }
        }
        
        @media (max-width: 480px) {
            .header-inner {
                padding: 0.5rem;
            }
            
            .logo-pro {
                font-size: 1.2rem;
                flex-basis: 100%;
            }
            
            .header-actions {
                gap: 0.5rem;
                justify-content: center;
                flex-wrap: nowrap;
            }
            
            .search-pro {
                display: none;
            }
            
            .hero-content h1 {
                font-size: clamp(1.2rem, 3vw, 2rem);
            }
            
            .hero-content p {
                font-size: 0.9rem;
            }
            
            .cta-hero {
                padding: 0.6rem 1rem;
                font-size: 0.8rem;
            }
            
            .section-title {
                font-size: clamp(1.2rem, 3vw, 1.8rem);
                margin: 1.5rem 0.5rem;
            }
            
            .categories-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 0.8rem;
                padding: 0 0.5rem;
                margin-bottom: 2rem;
            }
            
            .category-card {
                min-height: 100px;
                padding: 0.8rem 0.5rem;
                font-size: 0.8rem;
            }
            
            .footer {
                padding: 2rem 0.5rem 1rem;
                margin-top: 2rem;
            }
            
            .footer-content {
                gap: 1rem;
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
                @auth
                    <span style="color: white; font-weight: 500;">مرحبا، {{ Auth::user()?->name ?? session('admin_user')['name'] ?? 'المستخدم' }}</span>
                    <svg class="cart-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="cursor: pointer;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 6.5a2 2 0 002 1.5h11a2 2 0 002-1.5l-1.5-6.5M3 3h18M16 13V6a1 1 0 00-1-1h-4a1 1 0 00-1 1v7"/>
                    </svg>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" style="background: linear-gradient(135deg, #ef4444, #dc2626); border: none; color: white; padding: 0.8rem 1.5rem; border-radius: 20px; font-weight: 600; cursor: pointer; font-family: inherit;">خروج</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" style="background: var(--primary-blue); color: white; padding: 0.8rem 1.5rem; border-radius: 20px; font-weight: 600; text-decoration: none;">تسجيل دخول</a>
                @endauth
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
