<?php

declare(strict_types=1);

interface CurrencyFetcherInterface
{
    public function storeCurrencyConversionRatesToFile(string $fileName);
    public function logCurrencyConversionSuccessStatus(bool $status);

    public function setCurrencyConversionRates(string $apiKey, string $baseCurrencyName);
    public function getCurrencyConversionRates();
}