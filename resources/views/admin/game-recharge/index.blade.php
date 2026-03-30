@extends('layouts.admin')

@section('title', 'طلبات شحن الألعاب')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">طلبات شحن الألعاب والتطبيقات</h3>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>اللعبة/التطبيق</th>
                                    <th>فئة الشحن</th>
                                    <th>ID اللاعب</th>
                                    <th>رقم العملية</th>
                                    <th>الحالة</th>
                                    <th>تاريخ الطلب</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($requests as $request)
                                    <tr>
                                        <td>{{ $request->id }}</td>
                                        <td>{{ $request->game_name }}</td>
                                        <td>
                                            @if($request->gameCategory)
                                                <a href="{{ route('admin.game-categories.show', $request->gameCategory) }}">
                                                    {{ $request->gameCategory->name }}
                                                </a>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>{{ $request->player_id }}</td>
                                        <td>{{ $request->transaction_number }}</td>
                                        <td>
                                            <span class="badge 
                                                @if($request->status == 'pending') badge-warning
                                                @elseif($request->status == 'processing') badge-info
                                                @elseif($request->status == 'completed') badge-success
                                                @else badge-danger
                                                @endif">
                                                @if($request->status == 'pending') قيد الانتظار
                                                @elseif($request->status == 'processing') قيد المعالجة
                                                @elseif($request->status == 'completed') مكتمل
                                                @else مرفوض
                                                @endif
                                            </span>
                                        </td>
                                        <td>{{ $request->created_at->format('Y-m-d H:i') }}</td>
                                        <td>
                                            <a href="{{ route('admin.game-recharge.show', $request) }}" class="btn btn-sm btn-info">عرض</a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">لا توجد طلبات</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{ $requests->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection