<?php

namespace App\Console\Commands;

use App\Mail\LoginReminderEmail;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendLoginReminders extends Command
{
    protected $signature = 'users:send-login-reminders';
    protected $description = 'Send reminder emails to users who haven\'t logged in recently';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        // Find users who booked a hotel, are inactive, and have the role "user"
        $inactiveUsers = User::where('role', 'user') // Ensure only users
            ->whereHas('bookings') // Ensure they have bookings
            ->where(function ($query) {
                $query->where('last_login_at', '<', now()->subMinute()) // Check inactivity
                      ->orWhereNull('last_login_at'); // Or never logged in
            })
            ->get();

        foreach ($inactiveUsers as $user) {
            Mail::to($user->email)->send(new LoginReminderEmail($user));
            $this->info("Sent reminder email to: {$user->email}");
        }

        $this->info("Completed sending reminder emails to {$inactiveUsers->count()} users.");
    }
}