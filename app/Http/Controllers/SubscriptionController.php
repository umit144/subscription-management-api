<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function check(Request $request): JsonResponse
    {
        $subscription = Subscription::find(
            $request->user('device')->currentAccessToken()->subscription_id
        );

        return new JsonResponse([
            'isActive' => $subscription->status,
        ]);
    }
}
