<?php

namespace App\Providers;

use App\Models\Setting;
use App\Policies\SettingPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Setting::class => SettingPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();
    }
}