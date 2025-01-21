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
                'application_id' => $request->app_id,
            ]);

            $device->tokens()->whereSubscriptionId($subscription->id)->delete();

            return response()->json([
                'success' => true,
                'token' => $device->createClientToken('client-token', $subscription)->plainTextToken,
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
            ]);
        }
    }
}
