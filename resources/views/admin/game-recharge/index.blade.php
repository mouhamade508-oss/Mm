@extends('layouts.admin')

@section('title', 'طلبات شحن الألعاب')

@section('content')
<div class="container-fluid">
    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                إجمالي الطلبات
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $stats['total'] }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-gamepad fa-2x text-primary"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                قيد الانتظار
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $stats['pending'] }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clock fa-2x text-warning"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                قيد المعالجة
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $stats['processing'] }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-cog fa-2x text-info"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                مكتملة
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $stats['completed'] }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x text-success"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">
                <i class="fas fa-gamepad mr-2"></i>
                طلبات شحن الألعاب والتطبيقات
            </h6>
            <div class="dropdown no-arrow">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                    <div class="dropdown-header">خيارات إضافية:</div>
                    <a class="dropdown-item" href="#">
                        <i class="fas fa-download fa-sm fa-fw mr-2 text-gray-400"></i>
                        تصدير البيانات
                    </a>
                    <a class="dropdown-item" href="#">
                        <i class="fas fa-filter fa-sm fa-fw mr-2 text-gray-400"></i>
                        تصفية الطلبات
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle mr-2"></i>
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @forelse($requests as $request)
                <div class="card mb-3 border-left-{{ $request->status == 'pending' ? 'warning' : ($request->status == 'processing' ? 'info' : ($request->status == 'completed' ? 'success' : 'danger')) }} shadow-sm">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-2">
                                <div class="d-flex align-items-center">
                                    <div class="mr-3">
                                        <i class="fas fa-gamepad fa-2x text-primary"></i>
                                    </div>
                                    <div>
                                        <h6 class="font-weight-bold text-primary mb-1">
                                            #{{ $request->id }}
                                        </h6>
                                        <small class="text-muted">
                                            {{ $request->created_at->format('Y-m-d') }}
                                        </small>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="mb-2">
                                    <strong class="text-dark">{{ $request->game_name }}</strong>
                                </div>
                                <div class="text-sm text-muted">
                                    @if($request->gameCategory)
                                        <i class="fas fa-tag mr-1"></i>
                                        <a href="{{ route('admin.game-categories.show', $request->gameCategory) }}" class="text-decoration-none">
                                            {{ $request->gameCategory->name }}
                                        </a>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="mb-1">
                                    <i class="fas fa-user mr-1 text-muted"></i>
                                    <strong>{{ $request->customer_name }}</strong>
                                </div>
                                <div class="text-sm text-muted">
                                    <i class="fas fa-id-card mr-1"></i>
                                    {{ $request->player_id }}
                                </div>
                            </div>

                            <div class="col-md-2">
                                <div class="mb-1">
                                    <i class="fas fa-phone mr-1 text-muted"></i>
                                    {{ $request->customer_phone ?: 'غير محدد' }}
                                </div>
                                <div class="text-sm text-muted">
                                    <i class="fas fa-link mr-1"></i>
                                    {{ $request->referral_code ?? '❌ بدون رابط إحالة' }}
                                </div>
                                @if($request->transaction_number)
                                    <div class="text-sm text-muted">
                                        <i class="fas fa-hashtag mr-1"></i>
                                        {{ $request->transaction_number }}
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-1">
                                <span class="badge badge-{{ $request->status == 'pending' ? 'warning' : ($request->status == 'processing' ? 'info' : ($request->status == 'completed' ? 'success' : 'danger')) }} px-3 py-2">
                                    <i class="fas fa-{{ $request->status == 'pending' ? 'clock' : ($request->status == 'processing' ? 'cog' : ($request->status == 'completed' ? 'check-circle' : 'times-circle')) }} mr-1"></i>
                                    @if($request->status == 'pending') قيد الانتظار
                                    @elseif($request->status == 'processing') قيد المعالجة
                                    @elseif($request->status == 'completed') مكتمل
                                    @else مرفوض
                                    @endif
                                </span>
                            </div>

                            <div class="col-md-2 text-left">
                                <div class="d-flex flex-column">
                                    <a href="{{ route('admin.game-recharge.show', $request) }}" class="btn btn-primary btn-sm btn-icon-split">
                                        <span class="icon text-white-50">
                                            <i class="fas fa-eye"></i>
                                        </span>
                                        <span class="text">عرض</span>
                                    </a>
                                    <form method="POST" action="{{ route('admin.game-recharge.destroy', $request) }}" class="d-inline mt-1" onsubmit="return confirm('هل أنت متأكد من حذف هذا الطلب؟')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm btn-icon-split w-100">
                                            <span class="icon text-white-50">
                                                <i class="fas fa-trash"></i>
                                            </span>
                                            <span class="text">حذف</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        @if($request->notes)
                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="alert alert-light border">
                                        <i class="fas fa-sticky-note mr-2 text-muted"></i>
                                        <strong>ملاحظات:</strong> {{ $request->notes }}
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-5">
                    <i class="fas fa-gamepad fa-4x text-gray-300 mb-3"></i>
                    <h5 class="text-gray-500">لا توجد طلبات شحن حالياً</h5>
                    <p class="text-muted">سيتم عرض طلبات شحن الألعاب هنا عند وصولها</p>
                </div>
            @endforelse

            <!-- Pagination -->
            @if($requests->hasPages())
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
                    @if($requests->onFirstPage())
                      <span class="pagination-btn disabled">◀ السابق</span>
                    @else
                      <a href="{{ $requests->appends(request()->query())->previousPageUrl() }}" class="pagination-btn animate">◀ السابق</a>
                    @endif
                    <span class="pagination-info">صفحة {{ $requests->currentPage() }} من {{ $requests->lastPage() }}</span>
                    @if($requests->hasMorePages())
                      <a href="{{ $requests->appends(request()->query())->nextPageUrl() }}" class="pagination-btn animate">التالي ▶</a>
                    @else
                      <span class="pagination-btn disabled">التالي ▶</span>
                    @endif
                  </div>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}
.border-left-warning {
    border-left: 0.25rem solid #f6c23e !important;
}
.border-left-info {
    border-left: 0.25rem solid #36b9cc !important;
}
.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}
.border-left-danger {
    border-left: 0.25rem solid #e74a3b !important;
}

.text-primary {
    color: #5a5c69 !important;
}

.text-gray-800 {
    color: #5a5c69 !important;
}

.text-gray-400 {
    color: #d1d3e2 !important;
}

.text-gray-300 {
    color: #dddfeb !important;
}

.text-gray-500 {
    color: #6c757d !important;
}

.shadow {
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important;
}

.shadow-sm {
    box-shadow: 0 0.125rem 0.25rem 0 rgba(58, 59, 69, 0.15) !important;
}

.btn-icon-split {
    padding: 0;
    overflow: hidden;
    display: inline-flex;
    align-items: stretch;
    justify-content: center;
}

.btn-icon-split .icon {
    background: rgba(0, 0, 0, 0.15);
    display: inline-block;
    padding: 0.375rem 0.75rem;
}

.btn-icon-split .text {
    display: inline-block;
    padding: 0.375rem 0.75rem;
}

.btn-sm .btn-icon-split .icon {
    padding: 0.25rem 0.5rem;
}

.btn-sm .btn-icon-split .text {
    padding: 0.25rem 0.5rem;
}

.card {
    border: none;
    border-radius: 0.35rem;
}

.card-header {
    background-color: #f8f9fc;
    border-bottom: 1px solid #e3e6f0;
}

.dropdown-toggle::after {
    display: none;
}

.dropdown-menu {
    border: none;
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
}

.alert {
    border-radius: 0.35rem;
    border: none;
}

.badge {
    font-size: 0.75rem;
    font-weight: 600;
}
</style>
@endsection