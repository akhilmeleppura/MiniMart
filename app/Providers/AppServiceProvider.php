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

        // Register view locations & namespaces for all modules
        $modules = [
            'Base', 'Dashboard', 'Products', 'Category', 'Customer',
            'OrderManagement', 'CMS', 'StoreManagement', 'TaxManagement',
            'ShippingMethode', 'PaymentManagement', 'PaymentMethod',
            'PriceRuleManagement', 'ProductAttributes', 'Cart',
            'UserPermission', 'WebConfigurationManagement', 'URLRewrite',
            'NewsLetter', 'Api'
        ];

        foreach ($modules as $mod) {
            $lower = strtolower($mod);
            $paths = array_filter([
                base_path("Modules/{$mod}/resources/views"),
                resource_path("views/modules/{$lower}"),
                resource_path("views/modules/{$mod}"),
            ], 'is_dir');

            if (!empty($paths)) {
                $this->loadViewsFrom($paths, $lower);
                $this->loadViewsFrom($paths, $mod);
                foreach ($paths as $p) {
                    \Illuminate\Support\Facades\View::addLocation($p);
                }
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