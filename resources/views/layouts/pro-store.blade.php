<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('meta_title', config('app.name', 'MHD'))</title>
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">
    <meta name="description" content="@yield('meta_description', 'أفضل منتجات طباعة وتصميم احترافية في السعودية وباقات أسعار منافسة للعرب')" />
    <meta name="keywords" content="@yield('meta_keywords', 'طباعة, متجر, منتجات, تصميم, خصومات, شحن')" />
    <meta name="robots" content="index,follow" />
    <link rel="canonical" href="@yield('meta_canonical', url()->current())" />

    <meta property="og:type" content="@yield('og_type', 'website')" />
    <meta property="og:title" content="@yield('meta_title', config('app.name', 'MHD'))" />
    <meta property="og:description" content="@yield('meta_description', 'أفضل منتجات طباعة وتصميم احترافية في السعودية وباقات أسعار منافسة للعرب')" />
    <meta property="og:url" content="@yield('meta_canonical', url()->current())" />
    <meta property="og:site_name" content="{{ config('app.name', 'MHD Print Lab') }}" />
    <meta property="og:locale" content="ar_SA" />

    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:title" content="@yield('meta_title', config('app.name', 'MHD'))" />
    <meta name="twitter:description" content="@yield('meta_description', 'أفضل منتجات طباعة وتصميم احترافية في السعودية وباقات أسعار منافسة للعرب')" />
    <meta name="twitter:url" content="@yield('meta_canonical', url()->current())" />

    @stack('meta')

    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    
<link rel="stylesheet" href="{{ asset('css/custom-styles.css') }}">
    <style>
        /* Pro Store Styles - Nike/Adidas Level */
        :root {
            --primary-blue: linear-gradient(135deg, #0f172a 0%, #1e40af 50%, #3b82f6 100%);
            --glass-bg: rgba(255,255,255,0.1);
            --glass-border: rgba(255,255,255,0.2);
        }
        
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        @keyframes glow {
            0%, 100% {
                box-shadow: 0 0 20px rgba(59, 130, 246, 0.5);
            }
            50% {
                box-shadow: 0 0 40px rgba(59, 130, 246, 0.8);
            }
        }
        
        body { font-family: 'Tajawal', sans-serif; }

        .page-loader {
            position: fixed;
            inset: 0;
            background: radial-gradient(circle at center, rgba(15, 23, 42, 0.90), rgba(15, 23, 42, 0.99));
            backdrop-filter: blur(2px);
            z-index: 2000;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            transition: opacity 0.35s ease, visibility 0.35s ease;
        }

        .page-loader.loaded {
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
        }

        .loader-box {
            text-align: center;
            color: #dbeafe;
            max-width: min(420px, 90vw);
        }

        .loader-title {
            margin-bottom: 1rem;
            letter-spacing: 0.2em;
            font-weight: 700;
            font-size: 1rem;
            text-transform: uppercase;
            opacity: 0.95;
        }

        .skeleton-grid {
            display: grid;
            grid-template-columns: repeat(4, 85px);
            gap: 0.7rem;
            justify-content: center;
        }

        .skeleton-card {
            width: 85px;
            height: 110px;
            border-radius: 12px;
            background: linear-gradient(90deg, #1e3a8a 0%, #1f2a4a 50%, #1e3a8a 100%);
            position: relative;
            overflow: hidden;
        }

        .skeleton-card::after {
            content: '';
            position: absolute;
            inset: 0;
            transform: translateX(-100%);
            background: linear-gradient(90deg, transparent 0%, rgba(148, 163, 184, 0.45) 50%, transparent 100%);
            animation: shimmer 1.3s linear infinite;
        }

        @keyframes shimmer {
            to { transform: translateX(100%); }
        }

        .header-pro {
            background: rgba(15, 23, 42, 0.97);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--glass-border);
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            animation: slideDown 0.6s ease-out;
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
            transition: all 0.3s ease;
        }
        
        .logo-pro {
            font-size: clamp(1.2rem, 3vw, 2rem);
            font-weight: 900;
            text-decoration: none;
            flex-shrink: 0;
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            letter-spacing: -0.5px;
            display: flex;
            align-items: center;
            gap: 0.8rem;
            padding: 0.5rem 1rem;
            border-radius: 16px;
            background: rgba(59, 130, 246, 0.08);
            border: 1px solid rgba(59, 130, 246, 0.15);
        }
        
        .logo-pro svg {
            transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
            filter: drop-shadow(0 4px 12px rgba(59, 130, 246, 0.4));
        }
        
        .logo-pro div {
            display: flex;
            flex-direction: column;
        }
        
        .logo-pro span {
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
        }
        
        .logo-pro:hover {
            transform: translateY(-4px);
            background: rgba(59, 130, 246, 0.15);
            border-color: rgba(59, 130, 246, 0.3);
            box-shadow: 0 12px 30px rgba(59, 130, 246, 0.25);
        }
        
        .logo-pro:hover svg {
            filter: drop-shadow(0 8px 24px rgba(59, 130, 246, 0.6));
            transform: rotate(-8deg) scale(1.1);
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
            padding: 12px 18px 12px 45px;
            border: 2px solid var(--glass-border);
            border-radius: 50px;
            background: var(--glass-bg);
            color: white;
            font-size: 0.95rem;
            backdrop-filter: blur(10px);
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            font-family: 'Tajawal', sans-serif;
        }
        
        .search-input::placeholder {
            color: #cbd5e1;
        }
        
        .search-input:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 4px rgba(59,130,246,0.3);
            background: rgba(255,255,255,0.2);
            outline: none;
            transform: translateY(-2px);
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
            transition: all 0.3s ease;
        }
        
        .cart-icon:hover {
            transform: scale(1.1) rotate(5deg);
            color: #60a5fa;
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
            box-shadow: inset 0 0 60px rgba(0, 0, 0, 0.3);
        }
        
        .hero-banner::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: radial-gradient(circle at 20% 50%, rgba(59, 130, 246, 0.3) 0%, transparent 50%), radial-gradient(circle at 80% 80%, rgba(30, 58, 138, 0.3) 0%, transparent 50%);
            animation: glow 4s ease-in-out infinite;
            z-index: 1;
        }
        
        .hero-content {
            position: relative;
            z-index: 2;
            animation: fadeInUp 0.8s ease-out 0.3s both;
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
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            display: inline-block;
            margin: 0 0.5rem;
            position: relative;
            overflow: hidden;
            font-family: 'Tajawal', sans-serif;
        }
        
        .cta-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: rgba(255,255,255,0.2);
            transition: left 0.5s ease;
            z-index: -1;
        }
        
        .cta-hero:hover::before {
            left: 100%;
        }
        
        .cta-hero:hover {
            background: rgba(255,255,255,0.35);
            transform: translateY(-6px);
            box-shadow: 0 25px 50px rgba(0,0,0,0.4);
            border-color: rgba(255,255,255,0.5);
        }
        
        .cta-hero:active {
            transform: translateY(-2px);
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
            position: relative;
            padding-bottom: 1.5rem;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: clamp(60px, 15%, 150px);
            height: 4px;
            background: var(--primary-blue);
            border-radius: 2px;
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
            box-shadow: 0 8px 32px rgba(59, 130, 246, 0.15);
            transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
            border: 2px solid rgba(59, 130, 246, 0.1);
            cursor: pointer;
            height: auto;
            min-height: 150px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            font-size: clamp(0.9rem, 2vw, 1rem);
            position: relative;
            overflow: hidden;
        }
        
        .category-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.6s ease;
            z-index: 1;
        }
        
        .category-card:hover::before {
            left: 100%;
        }
        
        .category-card:hover {
            transform: translateY(-12px) scale(1.02);
            box-shadow: 0 20px 60px rgba(59, 130, 246, 0.35);
            border-color: #3b82f6;
            background: linear-gradient(135deg, #f8fafc 0%, white 100%);
        }
        
        .footer {
            background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 100%);
            color: white;
            padding: 3rem 1rem 2rem;
            margin-top: 4rem;
            border-top: 1px solid rgba(59, 130, 246, 0.2);
            box-shadow: 0 -8px 32px rgba(0, 0, 0, 0.2);
        }
        
        .footer-content {
            max-width: 1400px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
        }
        
        .footer-content h3,
        .footer-content h4 {
            transition: all 0.3s ease;
        }
        
        .footer-content h3:hover,
        .footer-content h4:hover {
            color: #60a5fa;
        }
        
        .footer-content a {
            transition: all 0.3s ease;
        }
        
        .footer-content a:hover {
            color: #60a5fa;
            transform: translateX(5px);
        }
        
        @media (max-width: 1024px) {
            .section-title {
                font-size: clamp(1.3rem, 3vw, 2.5rem);
                margin: 2rem 1rem;
            }
            
            .categories-grid {
                gap: 1rem;
                padding: 0 0.8rem;
            }
            
            .header-inner {
                min-height: 65px;
            }
            
            .logo-pro {
                gap: 0.7rem;
                padding: 0.5rem 1rem;
            }
            
            .logo-pro svg {
                width: 55px;
                height: 55px;
            }

            /* Social Media Icons - Desktop */
            .social-icons-container {
                gap: 1.5rem !important;
            }

            .social-icon {
                width: 50px !important;
                height: 50px !important;
            }

            .social-icon svg {
                width: 28px !important;
                height: 28px !important;
            }
        }
        
        @media (max-width: 768px) {
            .header-pro {
                padding: 0.5rem 0;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            }
            
            .header-inner {
                padding: 0.5rem 0.5rem;
                min-height: 60px;
            }
            
            .logo-pro {
                gap: 0.6rem;
                padding: 0.4rem 0.8rem;
            }
            
            .logo-pro svg {
                width: 50px;
                height: 50px;
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
                padding: 10px 14px 10px 38px;
            }
            
            .hero-banner {
                height: 50vh;
                min-height: 280px;
                padding: 1rem;
                box-shadow: inset 0 0 40px rgba(0, 0, 0, 0.2);
            }
            
            .hero-content h1 {
                font-size: clamp(1.5rem, 4vw, 2.5rem);
                margin-bottom: 0.8rem;
                text-shadow: 0 2px 10px rgba(0, 0, 0, 0.4);
            }
            
            .hero-content p {
                font-size: clamp(0.9rem, 2vw, 1.1rem);
                margin: 0 auto 1.5rem;
                max-width: 100%;
            }
            
            .cta-hero {
                padding: clamp(0.6rem, 1.5vw, 1rem) clamp(1rem, 2vw, 2rem);
                font-size: clamp(0.8rem, 1.5vw, 1rem);
                margin: 0 0.3rem 0.5rem;
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

            /* Social Media Icons - Tablet */
            .social-icons-container {
                gap: 1.3rem !important;
            }

            .social-icon {
                width: 48px !important;
                height: 48px !important;
            }

            .social-icon svg {
                width: 26px !important;
                height: 26px !important;
            }
        }
        
        @media (max-width: 480px) {
            .header-inner {
                padding: 0.5rem;
                min-height: 55px;
            }
            
            .logo-pro {
                font-size: 0.9rem;
                gap: 0.5rem;
                padding: 0.4rem 0.8rem;
                border-radius: 12px;
            }
            
            .logo-pro svg {
                width: 50px;
                height: 50px;
            }
            
            .logo-pro:hover {
                transform: translateY(-2px);
            }
            
            .header-actions {
                gap: 0.4rem;
                justify-content: center;
                flex-wrap: nowrap;
            }
            
            .search-pro {
                display: none;
            }
            
            .hero-content h1 {
                font-size: clamp(1.2rem, 3vw, 2rem);
                text-shadow: 0 1px 8px rgba(0, 0, 0, 0.5);
            }
            
            .hero-content p {
                font-size: 0.9rem;
                line-height: 1.5;
            }
            
            .cta-hero {
                padding: 0.6rem 1rem;
                font-size: 0.8rem;
                margin: 0.3rem 0.2rem;
            }
            
            .section-title {
                font-size: clamp(1.2rem, 3vw, 1.8rem);
                margin: 1.5rem 0.5rem;
                padding-bottom: 1rem;
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
            
            .category-card:hover {
                transform: translateY(-8px) scale(1.01);
            }
            
            .footer {
                padding: 2rem 0.5rem 1rem;
                margin-top: 2rem;
            }
            
            .footer-content {
                gap: 1rem;
            }

            /* Social Media Icons - Mobile */
            .social-icons-container {
                gap: 1rem !important;
            }

            .social-icon {
                width: 45px !important;
                height: 45px !important;
            }

            .social-icon svg {
                width: 24px !important;
                height: 24px !important;
            }
        }
    </style>
</head>
<body>
    <div id="page-loader" class="page-loader">
        <div class="loader-box">
            <div class="loader-title">جارٍ تحميل المحتوى ...</div>
            <div class="skeleton-grid">
                <div class="skeleton-card"></div>
                <div class="skeleton-card"></div>
                <div class="skeleton-card"></div>
                <div class="skeleton-card"></div>
            </div>
        </div>
    </div>

    <!-- Header Pro -->
    <header class="header-pro">
        <div class="header-inner">
            <a href="/" class="logo-pro">
                <!-- Premium Logo SVG -->
                <svg width="60" height="60" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg" style="flex-shrink: 0;">
                    <defs>
                        <linearGradient id="mainGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#3b82f6;stop-opacity:1" />
                            <stop offset="50%" style="stop-color:#1e88e5;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#1565c0;stop-opacity:1" />
                        </linearGradient>
                        <linearGradient id="accentGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#60a5fa;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#3b82f6;stop-opacity:1" />
                        </linearGradient>
                        <filter id="shadow" x="-50%" y="-50%" width="200%" height="200%">
                            <feDropShadow dx="0" dy="4" stdDeviation="6" flood-opacity="0.3"/>
                        </filter>
                    </defs>
                    
                    <!-- Background Circle with glow effect -->
                    <circle cx="50" cy="50" r="48" fill="url(#mainGradient)" opacity="0.15"/>
                    <circle cx="50" cy="50" r="46" fill="none" stroke="url(#mainGradient)" stroke-width="2" opacity="0.3"/>
                    
                    <!-- Main Container Box -->
                    <g filter="url(#shadow)">
                        <!-- Printer Body -->
                        <rect x="20" y="30" width="60" height="40" rx="4" fill="url(#mainGradient)" stroke="#0d47a1" stroke-width="1.5"/>
                        
                        <!-- Top Panel -->
                        <rect x="22" y="28" width="56" height="6" rx="2" fill="url(#accentGradient)"/>
                        
                        <!-- Loading/Tray Indicator -->
                        <circle cx="30" cy="33" r="2" fill="#60a5fa" opacity="0.8"/>
                        <circle cx="45" cy="33" r="2" fill="#60a5fa" opacity="0.8"/>
                        <circle cx="60" cy="33" r="2" fill="#60a5fa" opacity="0.8"/>
                        <circle cx="75" cy="33" r="2" fill="#60a5fa" opacity="0.8"/>
                        
                        <!-- Output Slot 1 -->
                        <line x1="25" y1="42" x2="75" y2="42" stroke="white" stroke-width="2.5" stroke-linecap="round" opacity="0.9"/>
                        
                        <!-- Output Slot 2 -->
                        <line x1="25" y1="50" x2="75" y2="50" stroke="white" stroke-width="2.5" stroke-linecap="round" opacity="0.85"/>
                        
                        <!-- Output Slot 3 -->
                        <line x1="25" y1="58" x2="70" y2="58" stroke="white" stroke-width="2.5" stroke-linecap="round" opacity="0.8"/>
                    </g>
                    
                    <!-- Bottom Paper Tray -->
                    <ellipse cx="50" cy="72" rx="28" ry="8" fill="url(#mainGradient)" opacity="0.6"/>
                    <path d="M 22 72 L 20 76 Q 50 80 80 76 L 78 72" fill="url(#accentGradient)"/>
                    
                    <!-- Decorative Elements -->
                    <circle cx="15" cy="15" r="3" fill="#60a5fa" opacity="0.7"/>
                    <circle cx="88" cy="88" r="2.5" fill="#60a5fa" opacity="0.7"/>
                    <circle cx="85" cy="20" r="2" fill="#3b82f6" opacity="0.6"/>
                </svg>
                
                <!-- Text Logo -->
                <div style="display: flex; flex-direction: column; align-items: flex-start; line-height: 1.1;">
                    <span style="background: linear-gradient(135deg, #3b82f6, #1565c0); -webkit-background-clip: text; background-clip: text; color: transparent; font-weight: 900; font-size: 1.3rem; letter-spacing: -0.7px;">MHD</span>
                    <span style="background: linear-gradient(135deg, #60a5fa, #3b82f6); -webkit-background-clip: text; background-clip: text; color: transparent; font-weight: 700; font-size: 0.65rem; letter-spacing: 1px;">PRINT LAB</span>
                </div>
            </a>
            
            <div class="header-actions">
                <div class="search-pro">
                    <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24" width="20" height="20">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    <input type="search" class="search-input" placeholder="🔍 ابحث عن المنتجات...">
                </div>
                @auth
                    <span style="color: #cbd5e1; font-weight: 500; font-size: 0.95rem; transition: color 0.3s ease;">👋 مرحبا، {{ Auth::user()?->name ?? session('admin_user')['name'] ?? 'المستخدم' }}</span>
                    <svg class="cart-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4m0 0L7 13m0 0l-1.5 6.5a2 2 0 002 1.5h11a2 2 0 002-1.5l-1.5-6.5M3 3h18M16 13V6a1 1 0 00-1-1h-4a1 1 0 00-1 1v7"/>
                    </svg>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" style="background: linear-gradient(135deg, #ef4444, #dc2626); border: none; color: white; padding: 0.8rem 1.5rem; border-radius: 20px; font-weight: 600; cursor: pointer; font-family: 'Tajawal', sans-serif; transition: all 0.3s ease; box-shadow: 0 8px 20px rgba(239, 68, 68, 0.3);" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 12px 28px rgba(239, 68, 68, 0.5)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 20px rgba(239, 68, 68, 0.3)'">🚪 خروج</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" style="background: var(--primary-blue); color: white; padding: 0.8rem 1.5rem; border-radius: 20px; font-weight: 600; text-decoration: none; transition: all 0.3s ease; box-shadow: 0 8px 20px rgba(59, 130, 246, 0.3); display: inline-block;" onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 12px 28px rgba(59, 130, 246, 0.5)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 20px rgba(59, 130, 246, 0.3)'">🔐 تسجيل دخول</a>
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
            <div style="animation: fadeInUp 0.8s ease-out;">
                <h3 style="font-size: 1.5rem; margin-bottom: 1rem; letter-spacing: -0.5px;">🏢 MHD Print Lab</h3>
                <p style="opacity: 0.8; line-height: 1.8; font-size: 0.95rem;">أفضل المنتجات بأسعار تنافسية مع خدمة عملاء ممتازة وشحن سريع</p>
            </div>
            <div style="animation: fadeInUp 0.8s ease-out 0.1s both;">
                <h4 style="margin-bottom: 1rem; font-size: 1.1rem; letter-spacing: -0.3px;">📎 الروابط السريعة</h4>
                <ul style="list-style: none; padding: 0;">
                    <li style="margin-bottom: 0.8rem;"><a href="/" style="color: #cbd5e1; text-decoration: none; opacity: 0.8; transition: all 0.3s ease;">🏠 الرئيسية</a></li>
                    <li style="margin-bottom: 0.8rem;"><a href="#" style="color: #cbd5e1; text-decoration: none; opacity: 0.8; transition: all 0.3s ease;">📦 المنتجات</a></li>
                    <li style="margin-bottom: 0.8rem;"><a href="#" style="color: #cbd5e1; text-decoration: none; opacity: 0.8; transition: all 0.3s ease;">💬 واتساب</a></li>
                </ul>
            </div>
            <div style="animation: fadeInUp 0.8s ease-out 0.2s both;">
                <h4 style="margin-bottom: 1rem; font-size: 1.1rem; letter-spacing: -0.3px;">📞 اتصل بنا</h4>
                <p style="opacity: 0.9; margin-bottom: 1rem; font-size: 0.95rem;">
                    <a href="https://wa.me/963982617848" style="color: #60a5fa; text-decoration: none; transition: all 0.3s ease;">📱 واتساب: 963982617848</a>
                </p>
                <p style="opacity: 0.8; font-size: 0.9rem;">ساعات العمل: 09:00 - 21:00</p>
            </div>
        </div>

        <!-- Social Media Section -->
        <div style="text-align: center; margin-top: 3rem; padding: 2rem; border-top: 1px solid rgba(59, 130, 246, 0.2); animation: fadeInUp 0.8s ease-out 0.3s both;">
            <h4 style="margin-bottom: 2rem; font-size: 1.1rem; letter-spacing: -0.3px; color: #cbd5e1;">تابعنا على وسائل التواصل الاجتماعي</h4>
            
            <div class="social-icons-container" style="display: flex; justify-content: center; gap: 1.5rem; flex-wrap: wrap;">
                <!-- Facebook -->
                <a href="https://www.facebook.com/share/1HsAf6o5aM/" target="_blank" rel="noopener noreferrer" class="social-icon" style="display: inline-flex; align-items: center; justify-content: center; width: 50px; height: 50px; border-radius: 50%; background: rgba(59, 130, 246, 0.1); border: 2px solid rgba(59, 130, 246, 0.3); transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1); text-decoration: none;" onmouseover="this.style.background='rgba(59, 130, 246, 0.25)'; this.style.borderColor='rgba(59, 130, 246, 0.6)'; this.style.transform='translateY(-4px) scale(1.1)'; this.style.boxShadow='0 12px 30px rgba(59, 130, 246, 0.4)';" onmouseout="this.style.background='rgba(59, 130, 246, 0.1)'; this.style.borderColor='rgba(59, 130, 246, 0.3)'; this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='0 0 0 transparent';">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #3b82f6;">
                        <path d="M18 2h-3a6 6 0 0 0-6 6v3H7v4h2v8h4v-8h3l1-4h-4V8a2 2 0 0 1 2-2h3z"></path>
                    </svg>
                </a>

                <!-- Instagram -->
                <a href="https://www.instagram.com/mhd_print_?igsh=MWc1cDB2emN2Z282YQ==" target="_blank" rel="noopener noreferrer" class="social-icon" style="display: inline-flex; align-items: center; justify-content: center; width: 50px; height: 50px; border-radius: 50%; background: rgba(59, 130, 246, 0.1); border: 2px solid rgba(59, 130, 246, 0.3); transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1); text-decoration: none;" onmouseover="this.style.background='rgba(236, 72, 153, 0.25)'; this.style.borderColor='rgba(236, 72, 153, 0.6)'; this.style.transform='translateY(-4px) scale(1.1)'; this.style.boxShadow='0 12px 30px rgba(236, 72, 153, 0.4)';" onmouseout="this.style.background='rgba(59, 130, 246, 0.1)'; this.style.borderColor='rgba(59, 130, 246, 0.3)'; this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='0 0 0 transparent';">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #ec4899;">
                        <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                        <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                        <circle cx="17.5" cy="6.5" r="1.5"></circle>
                    </svg>
                </a>

                <!-- Telegram -->
                <a href="https://t.me/MHD_print_lab" target="_blank" rel="noopener noreferrer" class="social-icon" style="display: inline-flex; align-items: center; justify-content: center; width: 50px; height: 50px; border-radius: 50%; background: rgba(59, 130, 246, 0.1); border: 2px solid rgba(59, 130, 246, 0.3); transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1); text-decoration: none;" onmouseover="this.style.background='rgba(14, 165, 233, 0.25)'; this.style.borderColor='rgba(14, 165, 233, 0.6)'; this.style.transform='translateY(-4px) scale(1.1)'; this.style.boxShadow='0 12px 30px rgba(14, 165, 233, 0.4)';" onmouseout="this.style.background='rgba(59, 130, 246, 0.1)'; this.style.borderColor='rgba(59, 130, 246, 0.3)'; this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='0 0 0 transparent';">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: #0ea5e9;">
                        <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                    </svg>
                </a>
            </div>
        </div>

        <div style="text-align: center; margin-top: 2rem; padding-top: 2rem; border-top: 1px solid rgba(59, 130, 246, 0.2); opacity: 0.7; font-size: 0.9rem;">
            © 2026 MHD Print Lab. جميع الحقوق محفوظة. 
        </div>
    </footer>

    <script>
        function hidePageLoader() {
            const loader = document.getElementById('page-loader');
            if (!loader) return;
            loader.classList.add('loaded');
            setTimeout(() => loader.remove(), 400);
        }

        // إذا الصفحة تم تحميلها بالكامل
        window.addEventListener('load', hidePageLoader);

        // حتى لو كان DOM جاهز، نريد أن نظهرها لحظات بسيطة كتحسين تجربة المستخدم
        document.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                const loader = document.getElementById('page-loader');
                if (loader && !loader.classList.contains('loaded')) {
                    hidePageLoader();
                }
            }, 800);
        });
    </script>
</body>
</html>
