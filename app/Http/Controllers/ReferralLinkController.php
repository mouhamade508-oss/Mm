<?php

namespace App\Http\Controllers;

use App\Models\ReferralLink;
use Illuminate\Http\Request;

class ReferralLinkController extends Controller
{
    public function redirect($code)
    {
        $referral = ReferralLink::where('code', $code)->where('is_active', true)->first();

        if (! $referral) {
            return redirect()->route('games.apps')->with('error', 'رابط الإحالة غير صالح أو معطل.');
        }

        // إعادة التوجيه مع الـ ref parameter ليحافظ على الكود
        $response = redirect()->route('games.apps', ['ref' => $referral->code])
                        ->with('success', 'تم تفعيل رابط الإحالة بنجاح. يمكنك متابعة طلب الشحن.');
        
        // ضع cookie للاحتفاظ بالكود لمدة 10 دقائق
        setcookie('referral_code', $referral->code, time() + 600, '/'); // 10 دقائق
        
        return $response;
    }
}
