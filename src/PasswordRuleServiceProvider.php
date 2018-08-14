<?php

namespace PasswordRule;

use Illuminate\Support\ServiceProvider;

class PasswordRuleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/publish/config.php'   => config_path('passwordrule.php'),
            __DIR__.'/lang'                 => resource_path('lang/vendor/passwordrule'),
        ]);
        $this->loadTranslationsFrom(__DIR__.'/lang/', 'passwordrule');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/publish/config.php', 'passwordrule');
    }
}