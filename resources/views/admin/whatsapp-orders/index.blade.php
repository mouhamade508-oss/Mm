@extends('layouts.admin')

@section('content')
<div class="container">
  <div style="margin-bottom: 2rem;">
    <h1 style="font-size: 2.5rem; font-weight: 900; color: #1e293b;">📱 طلبات WhatsApp</h1>
  </div>

  @if(session('success'))
    <div style="background: #dcfce7; border: 2px solid #22c55e; color: #15803d; padding: 1rem; border-radius: 12px; margin-bottom: 2rem;">
      {{ session('success') }}
    </div>
  @endif

  @if($orders->count() > 0)
    <div style="background: white; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); overflow: hidden;">
      <table style="width: 100%; border-collapse: collapse;">
        <thead>
          <tr style="background: #f3f4f6; border-bottom: 2px solid #e5e7eb;">
            <th style="padding: 1.5rem; text-align: right; font-weight: 700; color: #1e293b;">المنتج</th>
            <th style="padding: 1.5rem; text-align: right; font-weight: 700; color: #1e293b;">اسم العميل</th>
            <th style="padding: 1.5rem; text-align: right; font-weight: 700; color: #1e293b;">الهاتف</th>
            <th style="padding: 1.5rem; text-align: right; font-weight: 700; color: #1e293b;">الكمية</th>
            <th style="padding: 1.5rem; text-align: right; font-weight: 700; color: #1e293b;">المبلغ</th>
            <th style="padding: 1.5rem; text-align: right; font-weight: 700; color: #1e293b;">الحالة</th>
            <th style="padding: 1.5rem; text-align: right; font-weight: 700; color: #1e293b;">التاريخ</th>
            <th style="padding: 1.5rem; text-align: center; font-weight: 700; color: #1e293b;">الإجراءات</th>
          </tr>
        </thead>
        <tbody>
          @foreach($orders as $order)
            <tr style="border-bottom: 1px solid #e5e7eb; transition: background 0.3s ease;" onmouseover="this.style.background='#f9fafb'" onmouseout="this.style.background='white'">
              <td style="padding: 1.5rem; color: #1e293b;">
                <strong>{{ $order->product->name }}</strong>
              </td>
              <td style="padding: 1.5rem; color: #64748b;">{{ $order->customer_name }}</td>
              <td style="padding: 1.5rem; color: #64748b;">{{ $order->customer_phone }}</td>
              <td style="padding: 1.5rem; text-align: center; color: #1e293b; font-weight: 700;">{{ $order->quantity }}</td>
              <td style="padding: 1.5rem; color: #ea580c; font-weight: 700;">{{ $order->total_price }}ليره</td>
              <td style="padding: 1.5rem;">
                <form action="{{ route('admin.whatsapp-orders.update-status', $order->id) }}" method="POST" style="display: inline;">
                  @csrf
                  @method('PUT')
                  <select name="status" onchange="this.form.submit()" style="padding: 0.5rem 1rem; border-radius: 8px; border: 2px solid #e0e7ff; font-weight: 700;">
                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>⏳ قيد الانتظار</option>
                    <option value="sent" {{ $order->status === 'sent' ? 'selected' : '' }}>✉️ تم الإرسال</option>
                    <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }}>✅ مؤكد</option>
                    <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>🎉 مكتمل</option>
                    <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>❌ ملغى</option>
                  </select>
                </form>
              </td>
              <td style="padding: 1.5rem; color: #64748b; font-size: 0.9rem;">
                {{ $order->created_at->format('Y-m-d H:i') }}
              </td>
              <td style="padding: 1.5rem; text-align: center;">
                @if($order->whatsapp_link)
                  <a href="{{ $order->whatsapp_link }}" target="_blank" style="display: inline-block; background: #22c55e; color: white; padding: 0.5rem 1rem; border-radius: 8px; text-decoration: none; font-weight: 700; transition: all 0.3s ease;" onmouseover="this.style.background='#16a34a'" onmouseout="this.style.background='#22c55e'">
                    📱 فتح
                  </a>
                @endif
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    @if($orders->hasPages())
      <style>
        .pagination-wrapper { display: flex; justify-content: center; margin: clamp(1.5rem, 4vw, 3rem) 0; }
        .pagination-controls { display: flex; align-items: center; gap: 0.8rem; background: linear-gradient(135deg, rgba(15, 23, 42, 0.22), rgba(30, 41, 59, 0.22)); border: 1px solid rgba(148, 163, 184, 0.4); border-radius: 999px; padding: 0.4rem; box-shadow: 0 12px 24px rgba(15, 23, 42, 0.12); }
        .pagination-btn { display: inline-flex; align-items: center; justify-content: center; padding: 0.6rem 1.2rem; border-radius: 999px; border: 1px solid rgba(255, 255, 255, 0.25); background: linear-gradient(135deg, #0284c7, #0284c7 40%, #0ea5e9); color: #fff; font-size: 0.95rem; font-weight: 700; text-decoration: none; transition: transform 0.2s ease, box-shadow 0.2s ease; }
        .pagination-btn:hover { transform: translateY(-2px) scale(1.02); box-shadow: 0 8px 22px rgba(2, 132, 199, 0.45); }
        .pagination-btn.animate { animation: bounceButton 1.5s ease-in-out infinite; }
        @keyframes bounceButton { 0%, 100% { transform: translateY(0) scale(1); } 50% { transform: translateY(-4px) scale(1.03); } }
        .pagination-btn.disabled { background: #cbd5e1; border-color: #94a3b8; color: #475569; cursor: default; box-shadow: none; }
        .pagination-info { color: #e2e8f0; font-size: 0.95rem; font-weight: 600; padding: 0 0.6rem; }
      </style>
      <div class="pagination-wrapper">
        <div class="pagination-controls">
          @if($orders->onFirstPage())
            <span class="pagination-btn disabled">◀ السابق</span>
          @else
            <a href="{{ $orders->appends(request()->query())->previousPageUrl() }}" class="pagination-btn animate">◀ السابق</a>
          @endif
          <span class="pagination-info">صفحة {{ $orders->currentPage() }} من {{ $orders->lastPage() }}</span>
          @if($orders->hasMorePages())
            <a href="{{ $orders->appends(request()->query())->nextPageUrl() }}" class="pagination-btn animate">التالي ▶</a>
          @else
            <span class="pagination-btn disabled">التالي ▶</span>
          @endif
        </div>
      </div>
    @endif
  @else
    <div style="background: white; border-radius: 12px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); padding: 4rem 2rem; text-align: center;">
      <div style="font-size: 4rem; margin-bottom: 1rem;">📭</div>
      <h2 style="font-size: 1.8rem; font-weight: 800; color: #1e293b; margin-bottom: 1rem;">لا توجد طلبات</h2>
      <p style="color: #64748b; font-size: 1.1rem;">لم تتلقَ أي طلبات عبر WhatsApp حتى الآن</p>
    </div>
  @endif
</div>
@endsection
