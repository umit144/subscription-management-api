<?php

namespace App\Services\Purchase;

use App\Models\Application;
use App\Models\Device;
use App\Models\Subscription;
use App\Services\Purchase\ReceiptValidator\ReceiptValidatorContext;
use Carbon\Carbon;
use Exception;

readonly class PurchaseService
{
    public function __construct(
        private ReceiptValidatorContext $receiptValidator,
    ) {}

    /**
     * @throws Exception
     */
    public function process(Device $device, Application $application, string $receipt): Subscription
    {
        $platform = $device->platform;
        $credentials = $application->credentials()->wherePlatform($platform)->first();

        $response = $this->receiptValidator
            ->setCredentials($credentials)
            ->setPlatform($platform)
            ->validate($receipt);

        if ($response['status'] !== true) {
            throw new Exception('Invalid receipt');
        }

        $expireDate = Carbon::createFromFormat(
            'Y-m-d H:i:s',
            $response['expire-date'],
            'America/Chicago'
        )->setTimezone('UTC');

        return $device->subscriptions()->updateOrCreate([
            'receipt' => $receipt,
        ], [
            'receipt' => $receipt,
            'application_id' => $application->id,
            'status' => true,
            'expire_date' => $expireDate,
        ]);
    }
}
