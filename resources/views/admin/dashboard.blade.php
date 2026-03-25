@extends('layouts.admin')

@section('page-title', '📊 لوحة البيانات')

@section('content')
<div class="px-4 py-8">
    <!-- Stats Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem; margin-bottom: 3rem;">
        <!-- Products Card -->
        <div style="background: white; border-radius: 12px; padding: 2rem; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border-right: 4px solid #3b82f6;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h3 style="color: #64748b; font-size: 0.9rem; margin-bottom: 0.5rem;">إجمالي المنتجات</h3>
                    <p style="font-size: 2rem; font-weight: 800; color: #1e40af;">{{ \App\Models\Product::count() }}</p>
                </div>
                <div style="font-size: 3rem; opacity: 0.3;">📦</div>
            </div>
        </div>

        <!-- Discounts Card -->
        <div style="background: white; border-radius: 12px; padding: 2rem; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border-right: 4px solid #f97316;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h3 style="color: #64748b; font-size: 0.9rem; margin-bottom: 0.5rem;">أكواد الخصم النشطة</h3>
                    <p style="font-size: 2rem; font-weight: 800; color: #dc2626;">{{ \App\Models\Discount::where('is_active', true)->count() }}</p>
                </div>
                <div style="font-size: 3rem; opacity: 0.3;">🎁</div>
            </div>
        </div>

        <!-- Stock Value Card -->
        <div style="background: white; border-radius: 12px; padding: 2rem; box-shadow: 0 4px 6px rgba(0,0,0,0.1); border-right: 4px solid #22c55e;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h3 style="color: #64748b; font-size: 0.9rem; margin-bottom: 0.5rem;">قيمة المخزون</h3>
                    <p style="font-size: 2rem; font-weight: 800; color: #059669;">{{ number_format(\App\Models\Product::query()->select(\Illuminate\Support\Facades\DB::raw('SUM(price * stock) as total'))->first()->total ?? 0, 0) }} ر.س</p>
                </div>
                <div style="font-size: 3rem; opacity: 0.3;">💰</div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div style="background: white; border-radius: 12px; padding: 2rem; margin-bottom: 3rem; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <h2 style="font-size: 1.3rem; font-weight: 700; margin-bottom: 1.5rem; color: #1e293b;">⚡ إجراءات سريعة</h2>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
            <a href="{{ route('admin.products.create') }}" style="background: linear-gradient(135deg, #3b82f6, #1e40af); color: white; padding: 1.5rem; border-radius: 10px; text-decoration: none; text-align: center; font-weight: 700; transition: all 0.3s; display: block;">
                ➕ إضافة منتج جديد
            </a>
            <a href="{{ route('admin.discounts.create') }}" style="background: linear-gradient(135deg, #f97316, #dc2626); color: white; padding: 1.5rem; border-radius: 10px; text-decoration: none; text-align: center; font-weight: 700; transition: all 0.3s; display: block;">
                🎁 إضافة كود خصم
            </a>
            <a href="{{ route('admin.products.index') }}" style="background: linear-gradient(135deg, #06b6d4, #0891b2); color: white; padding: 1.5rem; border-radius: 10px; text-decoration: none; text-align: center; font-weight: 700; transition: all 0.3s; display: block;">
                📦 إدارة المنتجات
            </a>
            <a href="{{ route('admin.discounts.index') }}" style="background: linear-gradient(135deg, #8b5cf6, #6d28d9); color: white; padding: 1.5rem; border-radius: 10px; text-decoration: none; text-align: center; font-weight: 700; transition: all 0.3s; display: block;">
                💳 إدارة أكواد الخصم
            </a>
        </div>
    </div>

    <!-- Recent Products -->
    <div style="background: white; border-radius: 12px; padding: 2rem; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
        <h2 style="font-size: 1.3rem; font-weight: 700; margin-bottom: 1.5rem; color: #1e293b;">📦 آخر المنتجات المضافة</h2>
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="border-bottom: 2px solid #e2e8f0;">
                    <th style="padding: 1rem; text-align: right; color: #64748b; font-weight: 600;">المنتج</th>
                    <th style="padding: 1rem; text-align: right; color: #64748b; font-weight: 600;">السعر</th>
                    <th style="padding: 1rem; text-align: right; color: #64748b; font-weight: 600;">المخزون</th>
                    <th style="padding: 1rem; text-align: right; color: #64748b; font-weight: 600;"></th>
                </tr>
            </thead>
            <tbody>
                @forelse(\App\Models\Product::latest()->take(5)->get() as $product)
                    <tr style="border-bottom: 1px solid #f1f5f9;">
                        <td style="padding: 1rem; color: #1e40af; font-weight: 600;">{{ $product->name }}</td>
                        <td style="padding: 1rem;">{{ number_format($product->price, 0) }} ر.س</td>
                        <td style="padding: 1rem;">
                            <span style="background: {{ $product->stock > 5 ? '#d1fae5' : '#fee2e2' }}; color: {{ $product->stock > 5 ? '#065f46' : '#7f1d1d' }}; padding: 0.5rem 1rem; border-radius: 6px; font-size: 0.9rem; font-weight: 600;">
                                {{ $product->stock }} قطعة
                            </span>
                        </td>
                        <td style="padding: 1rem; text-align: left;">
                            <a href="{{ route('admin.products.edit', $product) }}" style="color: #3b82f6; text-decoration: none; font-weight: 600;">تعديل →</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="padding: 2rem; text-align: center; color: #94a3b8;">لا توجد منتجات</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
