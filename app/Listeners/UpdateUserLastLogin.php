<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Log;

class UpdateUserLastLogin
{
    public function handle(Login $event): void
    {
        try {
            $user = $event->user;
            $user->last_login_at = now();
            $user->save();
            
            Log::info('Last login updated for user: ' . $user->id);
        } catch (\Exception $e) {
            Log::error('Failed to update last login: ' . $e->getMessage());
        }
    }
} 