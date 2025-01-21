<?php

namespace App\Services\Purchase;

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
    public function process(string $receipt): Subscription
    {
        $subscription = Subscription::whereReceipt($receipt)->first();
        $platform = $subscription->device->platform;
        $credentials = $subscription->application->credentials()->wherePlatform($platform)->first();

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

        $subscription->update([
            'status' => true,
            'expire_date' => $expireDate,
        ]);

        return $subscription;
    }
}
