<?php

namespace App\Http\Controllers;

use App\Http\Requests\Device\RegisterRequest;
use App\Models\Device;
use Illuminate\Http\JsonResponse;

class DeviceController extends Controller
{
    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $device = Device::firstOrCreate([
                'uid' => $request->get('uid'),
            ], $request->only(['uid', 'app_id', 'language', 'platform']));

            $subscription = $device->subscriptions()->firstOrCreate([
                'application_id' => $request->get('app_id'),
            ]);

            $device->tokens()->whereSubscriptionId($subscription->id)->delete();

            return new JsonResponse([
                'success' => true,
                'token' => $device->createClientToken($subscription)->plainTextToken,
            ]);
        } catch (\Exception $exception) {
            return new JsonResponse([
                'success' => false,
                'message' => $exception->getMessage(),
            ]);
        }
    }
}
