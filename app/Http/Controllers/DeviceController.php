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

            $device->subscriptions()->firstOrCreate([
                'application_id' => $request->app_id,
            ]);

            return response()->json([
                'success' => true,
                'token' => $device->createToken('client-token')->plainTextToken,
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
            ]);
        }
    }
}
