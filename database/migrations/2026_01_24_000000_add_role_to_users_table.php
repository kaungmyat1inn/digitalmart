<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', ['user', 'admin', 'super_admin'])->default('user')->after('email_verified_at');
            $table->timestamp('subscription_start')->nullable()->after('role');
            $table->timestamp('subscription_end')->nullable()->after('subscription_start');
            $table->softDeletes()->after('remember_token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
            $table->dropColumn('subscription_start');
            $table->dropColumn('subscription_end');
            $table->dropSoftDeletes();
        });
    }
};
