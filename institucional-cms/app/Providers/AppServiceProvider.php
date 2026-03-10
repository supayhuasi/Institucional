<?php

namespace App\Providers;

use App\Models\SiteSetting;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Throwable;

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
        try {
            if (!Schema::hasTable('site_settings')) {
                return;
            }

            $settings = SiteSetting::query()->pluck('value', 'key');

            if (($settings['mail_enabled'] ?? '0') !== '1') {
                return;
            }

            Config::set('mail.default', $settings['mail_mailer'] ?? 'smtp');

            Config::set('mail.mailers.smtp.host', $settings['mail_host'] ?? '127.0.0.1');
            Config::set('mail.mailers.smtp.port', (int) ($settings['mail_port'] ?? 587));
            Config::set('mail.mailers.smtp.username', $settings['mail_username'] ?? null);
            Config::set('mail.mailers.smtp.password', $settings['mail_password'] ?? null);
            Config::set('mail.mailers.smtp.encryption', $settings['mail_encryption'] ?? null);

            if (!empty($settings['mail_from_address'])) {
                Config::set('mail.from.address', $settings['mail_from_address']);
            }

            if (!empty($settings['mail_from_name'])) {
                Config::set('mail.from.name', $settings['mail_from_name']);
            }
        } catch (Throwable) {
        }
    }
}
