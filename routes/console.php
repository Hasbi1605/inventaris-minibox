<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use Illuminate\Support\Facades\Log;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Schedule dashboard cache clear every day at 00:00 WIB
Schedule::command('dashboard:clear-cache')
    ->dailyAt('00:00')
    ->timezone('Asia/Jakarta')
    ->name('Clear Dashboard Cache')
    ->description('Reset dashboard data setiap hari jam 00:00 WIB')
    ->onSuccess(function () {
        Log::info('Dashboard cache cleared successfully via scheduler');
    })
    ->onFailure(function () {
        Log::error('Dashboard cache clear failed via scheduler');
    });
