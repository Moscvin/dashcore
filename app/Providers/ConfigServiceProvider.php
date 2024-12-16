<?php

namespace App\Providers;


use App\Models\Core\CoreAdminOption;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class ConfigServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        try {
            if (Schema::hasTable('core_admin_options')) {
                $config = CoreAdminOption::pluck('value', 'description')->toArray();
                if (isset($config) && count($config) > 0) {
                    Config::set($config);
                }

                //Register Mail Settings
                Config::set('mail.mailers.smtp.driver', $config['MAIL_DRIVER']);
                Config::set('mail.mailers.smtp.host', $config['MAIL_HOST']);
                Config::set('mail.mailers.smtp.port', $config['MAIL_PORT']);
                Config::set('mail.mailers.smtp.username', $config['MAIL_USERNAME']);
                Config::set('mail.mailers.smtp.password', $config['MAIL_PASSWORD']);
                Config::set('mail.mailers.smtp.encryption', $config['MAIL_ENCRYPTION']);
                Config::set('mail.from.address', $config['MAIL_FROM_ADDRESS']);
                Config::set('mail.from.name', $config['MAIL_FROM_NAME']);
            }
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
