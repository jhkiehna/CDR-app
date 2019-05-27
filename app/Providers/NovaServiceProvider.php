<?php

namespace App\Providers;

use App\User as AppUser;
use App\Nova\User;
use Laravel\Nova\Nova;
use App\Nova\NexusUser;
use App\Nova\NexusCall;
use App\Nova\NexusMessage;
use App\Nova\NexusConversation;
use Illuminate\Support\Facades\Gate;
use App\Nova\Metrics\TotalCallsValue;
use App\Nova\Metrics\TotalMessagesValue;
use App\Nova\Metrics\TotalInboundCallsValue;
use App\Nova\Metrics\TotalOutboundCallsValue;
use App\Nova\Metrics\TotalAverageCallTimeValue;
use Laravel\Nova\NovaApplicationServiceProvider;
use App\Nova\Metrics\TotalMessagesSentValue;
use App\Nova\Metrics\TotalMessagesReceivedValue;
use App\Nova\Metrics\TotalCallTimeValue;

class NovaServiceProvider extends NovaApplicationServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Register the Nova routes.
     *
     * @return void
     */
    protected function routes()
    {
        Nova::routes()
                ->withAuthenticationRoutes()
                ->withPasswordResetRoutes()
                ->register();
    }

    /**
     * Register the Nova gate.
     *
     * This gate determines who can access Nova in non-local environments.
     *
     * @return void
     */
    protected function gate()
    {
        Gate::define('viewNova', function ($user) {
            $emails = AppUser::all()->map(function($user) {
                return $user->email;
            })->toArray();

            return in_array($user->email, $emails);
        });
    }

    /**
     * Get the cards that should be displayed on the Nova dashboard.
     *
     * @return array
     */
    protected function cards()
    {
        return [
            (new TotalCallsValue)->width('1/3'),
            (new TotalOutboundCallsValue)->width('1/3'),
            (new TotalInboundCallsValue)->width('1/3'),

            (new TotalAverageCallTimeValue)->width('1/2'),
            (new TotalCallTimeValue)->width('1/2'),

            (new TotalMessagesValue)->width('1/3'),
            (new TotalMessagesSentValue)->width('1/3'),
            (new TotalMessagesReceivedValue)->width('1/3'),
        ];
    }

    /**
     * Get the tools that should be listed in the Nova sidebar.
     *
     * @return array
     */
    public function tools()
    {
        return [];
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Register the application's Nova resources.
     *
     * @return void
     */
    protected function resources()
    {
        Nova::resources([
            NexusUser::class,
            NexusCall::class,
            User::class,
            // NexusConversation::class,
            NexusMessage::class,
        ]);
    }
}
