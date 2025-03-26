<?php
// app/Providers/EventServiceProvider.php
namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Events\UserRegistered;
use App\Events\OrderPlaced;
use App\Listeners\SendWelcomeEmailListener;
use App\Listeners\SendOrderEmailListener;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        UserRegistered::class => [
            SendWelcomeEmailListener::class,
        ],
        OrderPlaced::class => [
            SendOrderEmailListener::class,
        ],
    ];

    public function boot()
    {
        //
    }
}