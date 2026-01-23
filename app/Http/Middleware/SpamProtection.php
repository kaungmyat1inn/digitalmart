<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Cache;

class SpamProtection
{
    public function handle(Request $request, Closure $next): Response
    {
        $ip = $request->ip(); // User ရဲ့ IP ကို ယူမယ်
        $bannedKey = 'banned_ip_' . $ip;
        $attemptsKey = 'checkout_attempts_' . $ip;

        // ၁။ Ban ခံထားရတဲ့ IP လား အရင်စစ်မယ်
        if (Cache::has($bannedKey)) {
            // Ban ခံထားရရင် Home ကိုပြန်ကန်ထုတ်ပြီး Error ပြမယ်
            return redirect()->route('home')->with('error', 'မသင်္ကာဖွယ်ရာ လုပ်ဆောင်မှုများကြောင့် သင့်ကို ၂၄ နာရီ ပိတ်ထားပါသည်။');
        }

        // ၂။ Order တင်တဲ့အကြိမ်အရေအတွက်ကို ရေတွက်မယ်
        if (Cache::has($attemptsKey)) {
            Cache::increment($attemptsKey); // ရှိပြီးသားဆို ၁ တိုးမယ်
        } else {
            Cache::put($attemptsKey, 1, 60); // မရှိသေးရင် စရေမယ် (သက်တမ်း ၁ မိနစ်)
        }

        // ၃။ ၁ မိနစ်အတွင်း ၃ ကြိမ်ထက်ကျော်ရင် Ban မယ်
        if (Cache::get($attemptsKey) > 3) {
            // ၂၄ နာရီ Ban မယ် (1440 မိနစ်)
            Cache::put($bannedKey, true, 1440); 
            Cache::forget($attemptsKey); // Attempt ကို ပြန်ဖျက်မယ်
            
            return redirect()->route('home')->with('error', 'ခဏတာအတွင်း အော်ဒါတင်ခြင်း များလွန်းသဖြင့် သင့်ကို ၂၄ နာရီ ပိတ်ထားပါသည်။');
        }

        return $next($request);
    }
}