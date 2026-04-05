<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReferralLink;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ReferralLinkController extends Controller
{
    public function index()
    {
        $links = ReferralLink::latest()->paginate(20);
        return view('admin.referrals.index', compact('links'));
    }

    public function create()
    {
        return view('admin.referrals.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:50|unique:referral_links,code',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
        ]);

        $code = $request->code ?: strtoupper(Str::random(8));

        ReferralLink::create([
            'name' => $request->name,
            'code' => $code,
            'description' => $request->description,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.referrals.index')->with('success', 'تم إنشاء رابط الإحالة بنجاح.');
    }

    public function edit(ReferralLink $referral)
    {
        return view('admin.referrals.edit', compact('referral'));
    }

    public function update(Request $request, ReferralLink $referral)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:referral_links,code,' . $referral->id,
            'description' => 'nullable|string|max:1000',
            'is_active' => 'boolean',
        ]);

        $referral->update([
            'name' => $request->name,
            'code' => $request->code,
            'description' => $request->description,
            'is_active' => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.referrals.index')->with('success', 'تم تحديث رابط الإحالة بنجاح.');
    }

    public function destroy(ReferralLink $referral)
    {
        $referral->delete();

        return redirect()->route('admin.referrals.index')->with('success', 'تم حذف رابط الإحالة بنجاح.');
    }
}
