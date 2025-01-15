<?php

use Illuminate\Support\Facades\Schedule;

return [
    'timezone' => 'Asia/Kuala_Lumpur',
    
    'commands' => function (Schedule $schedule) {
        $schedule->command('users:send-login-reminders')
            ->everyMinute()
            ->withoutOverlapping();
    },
]; 