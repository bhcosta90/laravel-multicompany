<?php

namespace Modules\Central\Providers;

use Modules\Central\Events\CompanyEvent;
use Modules\Central\Listeners\CompanyListener;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        CompanyEvent::class => [
            CompanyListener::class,
        ],
    ];
}
