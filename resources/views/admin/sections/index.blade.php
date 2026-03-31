@extends('layouts.admin')

@section('content')
<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1 style="font-size: 2rem; font-weight: bold;">الأقسام الرئيسية</h1>
        <a href="{{ route('admin.sections.create') }}" class="btn" style="background: #3b82f6; color: white; padding: 0.75rem 1.5rem; border-radius: 8px; text-decoration: none; font-weight: bold;">+ قسم جديد</a>
    </div>

    @if(session('success'))
        <div style="background: #dcfce7; border: 2px solid #22c55e; color: #15803d; padding: 1rem; border-radius: 8px; margin-bottom: 2rem;">
            {{ session('success') }}
        </div>
    @endif

    @if($sections->count() > 0)
        <div style="background: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f3f4f6; border-bottom: 2px solid #e5e7eb;">
                        <th style="padding: 1rem; text-align: right; font-weight: bold;">الاسم</th>
                        <th style="padding: 1rem; text-align: right; font-weight: bold;">العدد</th>
                        <th style="padding: 1rem; text-align: right; font-weight: bold;">الوصف</th>
                        <th style="padding: 1rem; text-align: center; font-weight: bold;">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sections as $section)
                        <tr style="border-bottom: 1px solid #e5e7eb; transition: background 0.2s;">
                            <td style="padding: 1rem;"><strong>{{ $section->name }}</strong></td>
                            <td style="padding: 1rem; text-align: center;">{{ $section->categories()->count() }} فئة</td>
                            <td style="padding: 1rem; color: #666;">{{ Str::limit($section->description, 50) }}</td>
                            <td style="padding: 1rem; text-align: center;">
                                <a href="{{ route('admin.sections.show', $section) }}" class="btn" style="background: #3b82f6; color: white; padding: 0.5rem 1rem; border-radius: 6px; text-decoration: none; font-size: 0.9rem; display: inline-block;">عرض</a>
                                <a href="{{ route('admin.sections.edit', $section) }}" class="btn" style="background: #10b981; color: white; padding: 0.5rem 1rem; border-radius: 6px; text-decoration: none; font-size: 0.9rem; display: inline-block; margin: 0 0.5rem;">تعديل</a>
                                <form action="{{ route('admin.sections.destroy', $section) }}" method="POST" style="display: inline;" onsubmit="return confirm('هل أنت متأكد؟');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn" style="background: #ef4444; color: white; padding: 0.5rem 1rem; border-radius: 6px; border: none; cursor: pointer; font-size: 0.9rem;">حذف</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div style="background: white; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); padding: 3rem; text-align: center;">
            <p style="color: #999; font-size: 1.1rem;">لا توجد أقسام حالياً</p>
        </div>
    @endif
</div>
@endsection
