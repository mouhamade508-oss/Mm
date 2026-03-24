<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'MHD Print Lab') }}</title>
    <meta name="description" content="متجر MHD Print Lab - أفضل المنتجات بأسعار تنافسية">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=tajawal:400,500,600,700&amp;display=swap" rel="stylesheet" />
    
    @viteFallback
    <link href="{{ asset('resources/css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('resources/js/app.js') }}"></script>
</head>
<body class="font-tajawal antialiased bg-gray-50 text-gray-900">
    <!-- Header -->
    <header class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center py-4">
                <!-- Logo -->
                <a href="/" class="flex items-center space-x-2 space-x-reverse">
                    <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center shadow-lg">
                        <span class="text-white font-bold text-lg">M</span>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-blue-400 bg-clip-text text-transparent">MHD Print Lab</h1>
                        <span class="text-sm text-gray-500">متجرك المفضل</span>
                    </div>
                </a>

                <!-- Search Mobile -->
                <div class="lg:hidden">
                    <input type="search" placeholder="ابحث عن منتج..." class="w-64 px-4 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <!-- Desktop Nav -->
                <nav class="hidden lg:flex items-center space-x-8 space-x-reverse">
                    <a href="/" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">الرئيسية</a>
                    <a href="#" class="text-gray-700 hover:text-blue-600 font-medium transition-colors">المنتجات</a>
                    <div class="relative">
                        <button class="flex items-center space-x-2 space-x-reverse text-gray-700 hover:text-blue-600 font-medium transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                            <span>الفئات</span>
                        </button>
                    </div>
                </nav>
            </div>

            <!-- Desktop Search -->
            <div class="hidden lg:block mb-4">
                <div class="flex bg-white rounded-2xl shadow-sm border border-gray-200 px-4 py-3">
                    <input type="search" id="search" placeholder="ابحث عن منتجات..." class="flex-1 outline-none text-lg placeholder-gray-500">
                    <button class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded-xl font-medium transition-all ml-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </header>

    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- WhatsApp Fixed Button -->
    <a href="https://wa.me/963982617848?text=مرحبا، أريد طلب منتج من MHD Print Lab" 
       class="fixed bottom-6 right-6 z-40 w-16 h-16 bg-green-500 hover:bg-green-600 shadow-2xl rounded-full flex items-center justify-center text-white text-2xl transition-all hover:scale-110 hover:-rotate-12 shadow-green-500/25" 
       target="_blank" rel="noopener">
        <svg class="w-9 h-9" fill="currentColor" viewBox="0 0 24 24">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.446l-.232-.139-3.578-.503-1.043-.12-.005-.005-.002-.001-.001-.001l-.001-.001-.001-.001-.001-.001l-.001-.001-.001-.001-.001-.001l-.001-.001-.001-.001l-.001-.001l-.001-.001l-.001-.001l-.001-.001l-.1-.001-.001-.001l-.001-.001l-.001-.001l-.001-.001l-.001-.001l-.001-.001l-.001-.001l-.001-.001l-.001-.001l-.001-.001l-.001-.001l-.001-.001l-.001-.001l-.001-.001l-.001-.001l-.001-.001l-.001-.001l Providers/AppServiceProvider.php

