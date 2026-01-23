<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // status column ကို string (varchar) အဖြစ် ပြောင်းလိုက်ပါမယ်
            // ဒါဆိုရင် ကြိုက်တဲ့ status စာသား (purchased, transporting) ထည့်လို့ရသွားပါပြီ
            $table->string('status', 255)->default('pending')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
};
