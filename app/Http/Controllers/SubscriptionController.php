<?php

namespace App\Http\Controllers;

use App\Http\Requests\Subscription\PurchaseRequest;
use App\Models\Subscription;
use App\Services\Purchase\PurchaseService;
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

    public function purchase(PurchaseRequest $request, PurchaseService $purchaseService): JsonResponse
    {
        $subscription = $purchaseService->process(
            $request->string('receipt')
        );

        return new JsonResponse([
            'success' => true,
            'expiresAt' => $subscription->expire_date,
        ]);
    }
}
