<?php

namespace App\Http\Controllers;

use App\Http\Requests\Device\RegisterRequest;
use App\Models\Device;

class DeviceController extends Controller
{
    public function register(RegisterRequest $request)
    {
        try {
            $device = Device::firstOrCreate([
                'uid' => $request->get('uid'),
                'app_id' => $request->get('app_id'),
            ], $request->only(['uid', 'app_id', 'language', 'platform']));

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
