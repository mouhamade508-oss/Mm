<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use App\Models\GameRechargeRequest;
use App\Models\ReferralLink;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GameRechargeController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'game_id' => 'required|exists:games,id',
            'game_category_id' => 'required|exists:game_categories,id',
            'customer_name' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:255',
            'game_account' => 'required|string|max:255',
            'discount_code' => 'nullable|string|max:50',
            'proof_code' => 'nullable|string|max:255',
            'proof_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
            'transaction_number' => 'nullable|string|max:255',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Get the game and category
        $game = \App\Models\Game::find($request->game_id);
        $gameCategory = \App\Models\GameCategory::find($request->game_category_id);

        // Handle proof data and referral code
        $proofCode = $request->input('proof_code');

        if ($request->hasFile('proof_image')) {
            $proofCode = $request->file('proof_image')->store('game-recharge-proofs', 'public');
        }

        // الحصول على كود الإحالة من الطلب أولاً، ثم من الجلسة
        $referralCode = $request->input('ref') ?: session('referral_code');

        $discountCode = null;
        $discountId = null;
        $discountPercentage = null;
        $discountAmount = null;
        $originalPrice = $gameCategory->price;
        $finalPrice = $originalPrice;

        if ($request->filled('discount_code')) {
            $discount = Discount::where('code', strtoupper($request->discount_code))->first();

            if (! $discount) {
                return back()->withErrors(['discount_code' => 'كود الخصم غير صالح أو غير موجود.'])->withInput();
            }

            if (! $discount->isValidForPurpose('game_recharge')) {
                return back()->withErrors(['discount_code' => 'هذا الكود غير صالح لقسم شحن الألعاب.'])->withInput();
            }

            $discountCode = $discount->code;
            $discountId = $discount->id;
            $discountPercentage = $discount->percentage;
            $discountAmount = $discount->calculateDiscount($originalPrice);
            $finalPrice = max($originalPrice - $discountAmount, 0);
            $discount->incrementUsage();
        }

        $gameRequest = GameRechargeRequest::create([
            'game_id' => $request->game_id,
            'game_category_id' => $request->game_category_id,
            'game_name' => $game->name,
            'category_name' => $gameCategory->name,
            'player_id' => $request->game_account,
            'proof_code' => $proofCode,
            'transaction_number' => $request->transaction_number,
            'customer_name' => $request->customer_name,
            'customer_phone' => $request->phone_number,
            'notes' => $request->notes,
            'referral_code' => $referralCode,
            'discount_code' => $discountCode,
            'discount_id' => $discountId,
            'discount_percentage' => $discountPercentage,
            'discount_amount' => $discountAmount,
            'original_price' => $originalPrice,
            'final_price' => $finalPrice,
            'status' => 'pending',
        ]);

        // مسح كود الإحالة من الجلسة والكوكيز بعد الاستخدام لمنع إعادة استخدامه
        if ($referralCode) {
            session()->forget('referral_code');
            setcookie('referral_code', '', time() - 3600, '/'); // مسح الكوكيز
        }

        // Send notification
        $this->sendNotification($gameRequest);

        // If it's an AJAX request, return JSON
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'تم إرسال طلبك بنجاح! سيتم التواصل معك قريباً.',
                'request_id' => $gameRequest->id
            ]);
        }

        // Otherwise redirect with success message
        return redirect()->route('games.apps')->with('success', 'تم إرسال طلب الشحن بنجاح! سيتم التواصل معك قريباً.');
    }

    private function sendNotification($gameRequest)
    {
        // Log the request
        \Log::info('New game recharge request', [
            'id' => $gameRequest->id,
            'game' => $gameRequest->game_name,
            'category' => $gameRequest->category_name ?? 'N/A',
            'player_id' => $gameRequest->player_id,
            'customer_name' => $gameRequest->customer_name,
            'customer_phone' => $gameRequest->customer_phone,
            'proof_code' => $gameRequest->proof_code,
        ]);

        // Send Telegram notification
        $telegramBotToken = env('TELEGRAM_BOT_TOKEN');
        $telegramChatId = env('TELEGRAM_CHAT_ID');

        // Debug: Log the values
        \Log::info('DEBUG Telegram Config', [
            'token_exists' => !empty($telegramBotToken),
            'token_length' => strlen($telegramBotToken ?? ''),
            'chat_id_exists' => !empty($telegramChatId),
            'chat_id_value' => $telegramChatId,
        ]);

        if ($telegramBotToken && $telegramChatId) {
            // Build a nice formatted message
            $message = "<b>🎮 طلب شحن لعبة جديد!</b>\n\n";
            $message .= "━━━━━━━━━━━━━━━━━━━━━━\n";
            $message .= "<b>📋 معلومات الطلب:</b>\n";
            $message .= "ID: <code>#{$gameRequest->id}</code>\n";
            $message .= "اللعبة: <b>{$gameRequest->game_name}</b>\n";
            $message .= "الفئة: <b>" . ($gameRequest->category_name ?? 'N/A') . "</b>\n";
            
            if($gameRequest->gameCategory) {
                $message .= "السعر: <b>" . number_format($gameRequest->gameCategory->price, 2) . "ل.س</b>\n";
            }
            
            $message .= "\n<b>👤 بيانات العميل:</b>\n";
            $message .= "الاسم: <b>" . ($gameRequest->customer_name ?? 'غير محدد') . "</b>\n";
            $message .= "الهاتف: <b>" . ($gameRequest->customer_phone ?? 'غير محدد') . "</b>\n";
            
            $message .= "\n<b>🎮 معلومات اللعبة:</b>\n";
            $message .= "معرّف اللاعب: <code>{$gameRequest->player_id}</code>\n";
            
            $message .= "\n<b>🔗 رمز الإحالة:</b> ";
            if ($gameRequest->referral_code) {
                $message .= "<code>{$gameRequest->referral_code}</code>\n";
            } else {
                $message .= "❌ بدون رابط إحالة\n";
            }
            
            if($gameRequest->notes) {
                $message .= "\n<b>📝 ملاحظات:</b>\n";
                $message .= "<i>" . htmlspecialchars($gameRequest->notes) . "</i>\n";
            }
            
            if($gameRequest->proof_code) {
                $message .= "\n<b>🔢 كود إثبات الدفع:</b> <code>{$gameRequest->proof_code}</code>\n";
            }
            
            $message .= "\n━━━━━━━━━━━━━━━━━━━━━━\n";
            $message .= "📅 التاريخ: <b>" . $gameRequest->created_at->format('d/m/Y H:i') . "</b>\n";
            $message .= "الحالة: <b>⏳ قيد الانتظار</b>\n\n";
            $message .= "<a href='" . route('admin.game-recharge.show', $gameRequest->id) . "'>👉 اضغط لعرض التفاصيل</a>";

            $this->sendTelegramMessage($telegramBotToken, $telegramChatId, $message);
        }
    }

    private function sendTelegramMessage($token, $chatId, $message)
    {
        try {
            // Log the attempt
            \Log::info('Attempting to send Telegram message', [
                'token_exists' => !empty($token),
                'chat_id' => $chatId,
                'message_length' => strlen($message)
            ]);

            $url = "https://api.telegram.org/bot{$token}/sendMessage";
            $data = [
                'chat_id' => $chatId,
                'text' => $message,
                'parse_mode' => 'HTML',
                'disable_web_page_preview' => true
            ];

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
            
            $response = curl_exec($ch);
            $error = curl_error($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            
            curl_close($ch);

            \Log::info('Telegram API Response', [
                'http_code' => $httpCode,
                'error' => $error,
                'response' => $response
            ]);

            if ($error) {
                \Log::error('Telegram notification curl error', [
                    'error' => $error,
                    'chat_id' => $chatId,
                    'http_code' => $httpCode
                ]);
                return false;
            } else {
                $responseData = json_decode($response, true);
                if (isset($responseData['ok']) && $responseData['ok']) {
                    \Log::info('✅ Telegram notification sent successfully', [
                        'message_id' => $responseData['result']['message_id'] ?? null,
                        'chat_id' => $chatId,
                        'http_code' => $httpCode
                    ]);
                    return true;
                } else {
                    \Log::error('❌ Telegram API error response', [
                        'response' => $response,
                        'chat_id' => $chatId,
                        'http_code' => $httpCode,
                        'error_code' => $responseData['error_code'] ?? 'unknown',
                        'error_description' => $responseData['description'] ?? 'no description'
                    ]);
                    return false;
                }
            }
        } catch (\Exception $e) {
            \Log::error('❌ Exception sending Telegram notification', [
                'exception' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'chat_id' => $chatId
            ]);
            return false;
        }
    }

    public function index()
    {
        $requests = GameRechargeRequest::latest()->paginate(20);

        // Get statistics
        $stats = [
            'total' => GameRechargeRequest::count(),
            'pending' => GameRechargeRequest::where('status', 'pending')->count(),
            'processing' => GameRechargeRequest::where('status', 'processing')->count(),
            'completed' => GameRechargeRequest::where('status', 'completed')->count(),
            'rejected' => GameRechargeRequest::where('status', 'rejected')->count(),
        ];

        return view('admin.game-recharge.index', compact('requests', 'stats'));
    }

    public function show(GameRechargeRequest $gameRequest)
    {
        return view('admin.game-recharge.show', compact('gameRequest'));
    }

    public function updateStatus(Request $request, GameRechargeRequest $gameRequest)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,completed,rejected',
        ]);

        $gameRequest->update([
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'تم تحديث حالة الطلب بنجاح.');
    }

    public function destroy(GameRechargeRequest $gameRequest)
    {
        $gameRequest->delete();

        return redirect()->route('admin.game-recharge.index')->with('success', 'تم حذف الطلب بنجاح.');
    }
}
