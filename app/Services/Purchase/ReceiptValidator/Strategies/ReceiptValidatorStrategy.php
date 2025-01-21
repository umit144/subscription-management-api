<?php

namespace App\Services\Purchase\ReceiptValidator\Strategies;

interface ReceiptValidatorStrategy
{
    public function validate(string $receipt): array;
}
