<?php

namespace App\Providers;

use App\Models\Ban;
use App\Models\ImageAttachment;
use App\Policies\BanPolicy;
use App\Policies\ImageAttachmentPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Ban::class => BanPolicy::class,
        App\Models\ModerationActions\Ban::class => \App\Policies\ModerationActions\BanPolicy::class,
        ImageAttachment::class => ImageAttachmentPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::after(function ($user, $ability) {
            return $user->hasRole('Administrator');
        });
    }
}
