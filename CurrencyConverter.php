<?php

declare(strict_types=1);

class CurrencyConverter
{
    private CurrencyFetcherInterface $currencyConversionRates;

    public function __construct(CurrencyFetcherInterface $currencyConversionRates)
    {
        $this->currencyConversionRates = $currencyConversionRates->getCurrencyConversionRates();
    }

    public function convertCurrencyToBase(int $amount, string $currencyName, int $roundPrecision)
    {
        $currencyName = strtoupper($currencyName);

        if ($currencyConversionRate = $this->getCurrencyConversionRate($currencyName)) {
            return round($this->calculateCurrencyConversion($amount, $currencyConversionRate), $roundPrecision);
        }

        throw new Exception('Could not convert currency... Something is wrong with your currencyConversionRates...' . PHP_EOL);
    }

    private function getCurrencyConversionRate(string $currencyName)
    {
        $currencyName = strtoupper($currencyName);

        if ($this->currencyConversionRates)
        {
            return $this->currencyConversionRates->$currencyName;
        }
        throw new Exception('Object currencyConversionRates not found!');
    }

    private function calculateCurrencyConversion(int $amount, string $currencyConversionRate) {
        return ($amount / $currencyConversionRate);
    }
}