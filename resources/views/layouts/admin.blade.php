<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'MHD Print Lab') }} - لوحة الإدارة</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    
    @vite('resources/css/app.css')
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Tajawal', sans-serif;
            background-color: #f1f5f9;
            color: #1e293b;
        }

        .admin-container {
            display: flex;
            height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background: linear-gradient(135deg, #0f172a 0%, #1e40af 50%, #3b82f6 100%);
            color: white;
            padding: 2rem 0;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.2);
        }

        .sidebar-title {
            padding: 0 2rem 2rem;
            font-size: 1.5rem;
            font-weight: 900;
            border-bottom: 2px solid rgba(255, 255, 255, 0.2);
            margin-bottom: 2rem;
        }

        .sidebar-menu {
            list-style: none;
            margin-right: 0;
        }

        .sidebar-menu li {
            margin-bottom: 0.5rem;
        }

        .sidebar-menu a {
            display: block;
            padding: 1rem 2rem;
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            border-right: 3px solid transparent;
        }

        .sidebar-menu a:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border-right-color: white;
        }

        .sidebar-menu a.active {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border-right-color: white;
            font-weight: 700;
        }

        /* Main Content */
        .main-content {
            margin-right: 250px;
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }

        /* Top Navigation */
        .top-nav {
            background: white;
            padding: 1.5rem 2rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .nav-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e40af;
        }

        .nav-user {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .logout-btn {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 20px;
            font-weight: 600;
            cursor: pointer;
            font-family: inherit;
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(239, 68, 68, 0.3);
        }

        /* Content Area */
        .content {
            flex: 1;
            padding: 2rem;
            overflow-y: auto;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
                display: flex;
                align-items: center;
                padding: 1rem;
            }

            .main-content {
                margin-right: 0;
            }

            .sidebar-menu {
                display: flex;
                gap: 1rem;
            }

            .top-nav {
                flex-direction: column;
                gap: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-title">🏢 الإدارة</div>
            <ul class="sidebar-menu">
                <li>
                    <a href="{{ route('admin.dashboard') }}" 
                       class="{{ Route::is('admin.dashboard') ? 'active' : '' }}">
                        📊 لوحة البيانات
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.categories.index') }}" 
                       class="{{ Route::is('admin.categories.*') ? 'active' : '' }}">
                        📂 الفئات
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.products.index') }}" 
                       class="{{ Route::is('admin.products.*') ? 'active' : '' }}">
                        📦 المنتجات
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.discounts.index') }}" 
                       class="{{ Route::is('admin.discounts.*') ? 'active' : '' }}">
                        🎁 أكواد الخصم
                    </a>
                </li>
            </ul>
        </aside>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Top Navigation -->
            <nav class="top-nav">
                <div class="nav-title">
                    @yield('page-title', 'لوحة الإدارة')
                </div>
                <div class="nav-user">
                    <span>👤 {{ Auth::user()?->name ?? session('admin_user')['name'] ?? 'Admin' }}</span>
                    <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="logout-btn">🚪 خروج</button>
                    </form>
                </div>
            </nav>

            <!-- Content -->
            <div class="content">
                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>
