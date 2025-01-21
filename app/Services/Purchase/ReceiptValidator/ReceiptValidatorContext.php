<?php

namespace App\Services\Purchase\ReceiptValidator;

use App\Enums\Platform;
use App\Models\ApplicationCredentials;
use App\Services\Purchase\ReceiptValidator\Strategies\AndroidReceiptValidatorStrategy;
use App\Services\Purchase\ReceiptValidator\Strategies\IosReceiptValidatorStrategy;
use App\Services\Purchase\ReceiptValidator\Strategies\ReceiptValidatorStrategy;

class ReceiptValidatorContext implements ReceiptValidatorStrategy
{
    private ReceiptValidatorStrategy $strategy;

    private ApplicationCredentials $credentials;

    public function setCredentials(ApplicationCredentials $credentials): self
    {
        $this->credentials = $credentials;

        return $this;
    }

    public function setPlatform(Platform $platform): self
    {
        $this->strategy = match ($platform) {
            Platform::IOS => new IosReceiptValidatorStrategy($this->credentials),
            Platform::ANDROID => new AndroidReceiptValidatorStrategy($this->credentials),
        };

        return $this;
    }

    public function validate(string $receipt): array
    {
        return $this->strategy->validate($receipt);
    }
}
