<?php

namespace App\Http\Controllers;

use App\Http\Requests\Subscription\PurchaseRequest;
use App\Services\Purchase\PurchaseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function check(Request $request): JsonResponse
    {
        try {
            $device = $request->user('device');
            $application = $device->currentAccessToken()->application;
            $subscription = $device->subscriptions()->whereApplicationId($application->id)->first();

            return new JsonResponse([
                'isActive' => (bool) $subscription?->status,
            ]);
        } catch (\Exception $exception) {
            return new JsonResponse([
                'success' => false,
                'message' => $exception->getMessage(),
            ]);
        }
    }

    public function purchase(PurchaseRequest $request, PurchaseService $purchaseService): JsonResponse
    {
        try {
            $subscription = $purchaseService->process(
                $request->user('device'),
                $request->user('device')->currentAccessToken()->application,
                $request->string('receipt')
            );

            return new JsonResponse([
                'success' => true,
                'expiresAt' => $subscription->expire_date,
            ]);
        } catch (\Exception $exception) {
            return new JsonResponse([
                'success' => false,
                'message' => $exception->getMessage(),
            ]);
        }
    }
}
