<?php

namespace App\Http\Controllers;

use App\Http\Requests\Device\RegisterRequest;
use App\Models\Application;
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

            $application = Application::find($request->get('app_id'));

            $device->tokens()->whereApplicationId($application->id)->delete();

            return new JsonResponse([
                'success' => true,
                'token' => $device->createClientToken($application)->plainTextToken,
            ]);
        } catch (\Exception $exception) {
            return new JsonResponse([
                'success' => false,
                'message' => $exception->getMessage(),
            ]);
        }
    }
}
