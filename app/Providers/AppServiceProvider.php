<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {

        // FORCE HTTPS FOR RENDER
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }

        // Register view hint paths for all modules in case module view loader didn't run
        $moduleDirectories = glob(base_path('Modules/*'), GLOB_ONLYDIR);
        foreach ($moduleDirectories as $dir) {
            $name = basename($dir);
            $lower = strtolower($name);
            $viewsDir = $dir . '/resources/views';
            if (is_dir($viewsDir)) {
                $this->loadViewsFrom($viewsDir, $lower);
            }
        }

        $mailConfig = [
            'driver'     => getConfigData('mail_type', 'webconfigurations_') ?? env('MAIL_MAILER'),
            'host'       => getConfigData('mail_host', 'webconfigurations_') ?? env('MAIL_HOST'),
            'port'       => getConfigData('mail_port', 'webconfigurations_') ?? env('MAIL_PORT'),
            'username'   => getConfigData('mail_username', 'webconfigurations_') ?? env('MAIL_USERNAME'),
            'password'   => getConfigData('mail_password', 'webconfigurations_') ?? env('MAIL_PASSWORD'),
            'encryption' => getConfigData('mail_encryption', 'webconfigurations_') ?? env('MAIL_ENCRYPTION'),
            'from' => [
                'address' => getConfigData('mail_from', 'webconfigurations_') ?? env('MAIL_FROM_ADDRESS'),
                'name'    => getConfigData('mail_from_name', 'webconfigurations_') ?? env('MAIL_FROM_NAME'),
            ],
        ];

        Config::set('mail', $mailConfig);
    }
}