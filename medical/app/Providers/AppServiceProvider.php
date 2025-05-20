<?php

namespace App\Providers;

use App\Models\Appointment;
use App\Observers\AppointmentObserver;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \App\Models\Appointment::observe(\App\Observers\AppointmentObserver::class);

        // Add this temporarily to your AppointmentObserver to test mail configuration
        try {
            Mail::raw('Test email', function($message) {
                $message->to('test@example.com')
                       ->subject('Test Email');
            });
            Log::info('Test email sent successfully');
        } catch (\Exception $e) {
            Log::error('Test email failed: ' . $e->getMessage());
        }
    }
}
