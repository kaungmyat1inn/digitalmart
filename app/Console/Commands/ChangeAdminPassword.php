<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class ChangeAdminPassword extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:change-password {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change admin password by email - Usage: php artisan admin:change-password digitalmart.mag@gmail.com newpassword';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $password = $this->argument('password');

        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->error('❌ Invalid email format!');
            return 1;
        }

        // Find user by email
        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("❌ User with email '{$email}' not found!");
            return 1;
        }

        // Validate password length
        if (strlen($password) < 6) {
            $this->error('❌ Password must be at least 6 characters!');
            return 1;
        }

        // Update password
        $user->update([
            'password' => Hash::make($password),
        ]);

        $this->info('✓ Password changed successfully!');
        $this->info("Email: {$user->email}");
        $this->info("New Password: {$password}");
        $this->info('Admin can now login with the new password.');

        return 0;
    }
}
