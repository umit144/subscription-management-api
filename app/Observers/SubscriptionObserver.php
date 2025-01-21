<?php

namespace App\Observers;

use App\Models\Subscription;
use Illuminate\Support\Facades\Redis;

class SubscriptionObserver
{
    public function updated(Subscription $subscription): void
    {
        Redis::publish('notifications.subscription.updated', json_encode([
            'appId' => $subscription->application->id,
            'deviceId' => $subscription->device->id,
            'event' => $subscription->getOriginal('expire_date') === null ? 'started' : 'renewed',
        ]));
    }
}
