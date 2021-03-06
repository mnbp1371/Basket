<?php

namespace App\Providers;

use App\Policies\PostPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
        ' App\User' => 'PostPolicy::class'
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

       // Gate::define('view.update','App\Policies\PostPolicy@update' );
        //Gate::define('view.delete','App\Policies\PostPolicy@delete' );

        Gate::resource('posts', 'App\Policies\PostPolicy');
    }
}
