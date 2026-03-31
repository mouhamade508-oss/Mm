@extends('layouts.admin')

@section('title', 'إدارة الأخبار')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Page Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-0 text-gray-800">
                        <i class="fas fa-newspaper text-primary me-2"></i>
                        إدارة الأخبار
                    </h1>
                    <p class="text-muted mb-0">إدارة أخبار الموقع والتحكم في عرضها</p>
                </div>
                <a href="{{ route('admin.news.create') }}" class="btn btn-primary btn-lg">
                    <i class="fas fa-plus me-2"></i>
                    إضافة خبر جديد
                </a>
            </div>

            <!-- Stats Cards -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        إجمالي الأخبار
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['total'] }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-newspaper fa-2x text-gray-300"></i>
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
                                        الأخبار النشطة
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['active'] }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-check-circle fa-2x text-gray-300"></i>
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
                                        الأخبار المجدولة
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['scheduled'] }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
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
                                        غير نشطة
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $stats['inactive'] }}</div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-pause-circle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-list me-2"></i>
                        قائمة الأخبار
                    </h6>
                    <div class="d-flex gap-2">
                        <input type="text" class="form-control form-control-sm" id="searchInput" placeholder="البحث في الأخبار...">
                        <div class="dropdown">
                            <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown">
                                <i class="fas fa-filter me-1"></i>
                                فلترة
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#" onclick="filterNews('all')">الكل</a></li>
                                <li><a class="dropdown-item" href="#" onclick="filterNews('active')">النشطة</a></li>
                                <li><a class="dropdown-item" href="#" onclick="filterNews('inactive')">غير النشطة</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover" id="newsTable">
                            <thead class="table-light">
                                <tr>
                                    <th class="border-0">#</th>
                                    <th class="border-0">العنوان</th>
                                    <th class="border-0">المحتوى</th>
                                    <th class="border-0">الحالة</th>
                                    <th class="border-0">الترتيب</th>
                                    <th class="border-0">تاريخ النشر</th>
                                    <th class="border-0 text-center">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($news as $item)
                                    <tr class="news-row" data-status="{{ $item->is_active ? 'active' : 'inactive' }}">
                                        <td>
                                            <span class="badge bg-secondary">{{ $item->id }}</span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="ms-3">
                                                    <h6 class="mb-0 text-truncate" style="max-width: 200px;" title="{{ $item->title }}">
                                                        {{ Str::limit($item->title, 40) }}
                                                    </h6>
                                                    @if($item->link)
                                                        <small class="text-muted">
                                                            <i class="fas fa-link me-1"></i>
                                                            <a href="{{ $item->link }}" target="_blank" class="text-decoration-none">{{ Str::limit($item->link, 30) }}</a>
                                                        </small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="mb-0 text-muted small" title="{{ $item->content }}">
                                                {{ Str::limit($item->content, 80) }}
                                            </p>
                                        </td>
                                        <td>
                                            @if($item->is_active)
                                                <span class="badge bg-success rounded-pill px-3 py-2">
                                                    <i class="fas fa-check-circle me-1"></i>
                                                    نشط
                                                </span>
                                            @else
                                                <span class="badge bg-secondary rounded-pill px-3 py-2">
                                                    <i class="fas fa-pause-circle me-1"></i>
                                                    غير نشط
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-info">{{ $item->sort_order }}</span>
                                        </td>
                                        <td>
                                            @if($item->published_at)
                                                <div class="small">
                                                    <i class="fas fa-calendar me-1 text-muted"></i>
                                                    {{ $item->published_at->format('d/m/Y') }}
                                                    <br>
                                                    <small class="text-muted">{{ $item->published_at->format('H:i') }}</small>
                                                </div>
                                            @else
                                                <span class="text-muted small">
                                                    <i class="fas fa-clock me-1"></i>
                                                    فوري
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.news.edit', $item) }}" class="btn btn-sm btn-outline-primary" title="تعديل">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.news.destroy', $item) }}" method="POST" class="d-inline"
                                                      onsubmit="return confirm('هل أنت متأكد من حذف هذا الخبر؟')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="حذف">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-5">
                                            <div class="empty-state">
                                                <i class="fas fa-newspaper fa-4x text-muted mb-3"></i>
                                                <h5 class="text-muted">لا توجد أخبار حالياً</h5>
                                                <p class="text-muted mb-4">ابدأ بإضافة أول خبر لموقعك</p>
                                                <a href="{{ route('admin.news.create') }}" class="btn btn-primary btn-lg">
                                                    <i class="fas fa-plus me-2"></i>
                                                    إضافة أول خبر
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if($news->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $news->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}
.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}
.border-left-info {
    border-left: 0.25rem solid #36b9cc !important;
}
.border-left-warning {
    border-left: 0.25rem solid #f6c23e !important;
}
.text-primary {
    color: #5a5c69 !important;
}
.text-gray-800 {
    color: #5a5c69 !important;
}
.shadow {
    box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15) !important;
}
.card {
    border: none;
    border-radius: 0.35rem;
}
.table-hover tbody tr:hover {
    background-color: rgba(0, 0, 0, 0.075);
}
.empty-state {
    padding: 2rem 0;
}
.btn-group .btn {
    border-radius: 0.35rem !important;
}
.badge {
    font-size: 0.75em;
}
</style>

<script>
document.getElementById('searchInput').addEventListener('keyup', function() {
    const searchTerm = this.value.toLowerCase();
    const rows = document.querySelectorAll('#newsTable tbody tr.news-row');

    rows.forEach(row => {
        const title = row.cells[1].textContent.toLowerCase();
        const content = row.cells[2].textContent.toLowerCase();

        if (title.includes(searchTerm) || content.includes(searchTerm)) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
});

function filterNews(status) {
    const rows = document.querySelectorAll('#newsTable tbody tr.news-row');

    rows.forEach(row => {
        const rowStatus = row.getAttribute('data-status');

        if (status === 'all' || rowStatus === status) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}
</script>
@endsection