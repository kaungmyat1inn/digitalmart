<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('is_featured_home')->default(false)->after('description');
            $table->unsignedInteger('featured_sort_order')->default(0)->after('is_featured_home');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['is_featured_home', 'featured_sort_order']);
        });
    }
};
