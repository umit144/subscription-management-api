<?php

namespace App\Services\Purchase\ReceiptValidator\Strategies;

use App\Models\ApplicationCredentials;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;

readonly class IosReceiptValidatorStrategy implements ReceiptValidatorStrategy
{
    private PendingRequest $client;

    public function __construct(ApplicationCredentials $credentials)
    {
        $this->client = Http::baseUrl(Config::get('services.app-store.url'))
            ->withBasicAuth($credentials->username, $credentials->password);
    }

    /**
     * @throws ConnectionException
     */
    public function validate(string $receipt): array
    {
        return $this->client->withBody(json_encode([
            'receipt' => $receipt,
        ]))->post('/receipt/validate')->json();
    }
}
