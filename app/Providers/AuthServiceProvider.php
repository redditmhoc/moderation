<?php

namespace App\Providers;

use App\Models\IssueReport;
use App\Models\ModerationActions\Ban;
use App\Models\ImageAttachment;
use App\Models\Mute;
use App\Policies\IssueReportPolicy;
use App\Policies\ModerationActions\BanPolicy;
use App\Policies\ImageAttachmentPolicy;
use App\Policies\MutePolicy;
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
        ImageAttachment::class => ImageAttachmentPolicy::class,
        IssueReport::class => IssueReportPolicy::class,
        Mute::class => MutePolicy::class,
        App\Models\ModerationActions\Mute::class => \App\Policies\ModerationActions\MutePolicy::class,
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
