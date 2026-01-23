<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    // $fillable အစား $guarded = [] ကို သုံးထားပါတယ်
    // ဒါဆိုရင် Database မှာ Column အသစ်တိုးလည်း ဒီမှာ လာပြင်စရာမလိုတော့ပါဘူး
    protected $guarded = [];

    // Product Table နဲ့ ချိတ်ဆက်ခြင်း
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Order Table နဲ့ ချိတ်ဆက်ခြင်း
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
