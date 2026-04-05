@extends('layouts.admin')

@section('title', 'روابط الإحالة')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">روابط الإحالة</h1>
            <p class="mb-0 text-muted">يمكنك إنشاء روابط إحالة وإرسالها للعملاء لزيادة طلبات شحن الألعاب.</p>
        </div>
        <a href="{{ route('admin.referrals.create') }}" class="btn btn-primary">إنشاء رابط إحالة جديد</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow mb-4">
        <div class="card-body">
            @if($links->count())
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>الاسم</th>
                                <th>الكود</th>
                                <th>الرابط</th>
                                <th>الحالة</th>
                                <th>الإجراءات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($links as $link)
                                <tr>
                                    <td>{{ $link->id }}</td>
                                    <td>{{ $link->name }}</td>
                                    <td>{{ $link->code }}</td>
                                    <td>
                                        <a href="{{ route('referral.redirect', $link->code) }}" target="_blank">عرض الرابط</a>
                                    </td>
                                    <td>{{ $link->is_active ? 'نشط' : 'متوقف' }}</td>
                                    <td>
                                        <a href="{{ route('admin.referrals.edit', $link) }}" class="btn btn-sm btn-info">تعديل</a>
                                        <form action="{{ route('admin.referrals.destroy', $link) }}" method="POST" style="display:inline-block" onsubmit="return confirm('هل تريد حذف رابط الإحالة؟');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">حذف</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">{{ $links->links() }}</div>
            @else
                <div class="text-center py-5">
                    <h5 class="text-gray-600">لا توجد روابط إحالة حتى الآن.</h5>
                    <p class="text-muted">اضغط على زر "إنشاء رابط إحالة جديد" لبدء العمل.</p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
