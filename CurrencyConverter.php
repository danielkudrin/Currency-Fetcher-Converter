<?php

declare(strict_types=1);

class CurrencyConverter
{
    private CurrencyFetcher $currencyConversionRates;

    public function __construct(CurrencyFetcher $currencyConversionRates)
    {
        $this->currencyConversionRates = $currencyConversionRates;
    }

    public function convertCurrencyToBase(int $amount, string $currencyName, int $roundPrecision)
    {
        $currencyName = strtoupper($currencyName);

        if ($currencyConversionRate = $this->getCurrencyConversionRate($currencyName)) {
            return round($this->calculateCurrencyConversion($amount, $currencyConversionRate), $roundPrecision);
        }

        return false;
    }

    private function getCurrencyConversionRate(string $currencyName)
    {
        $currencyName = strtoupper($currencyName);

        if (property_exists($this->currencyConversionRates, $currencyName))
        {
            return $this->currencyConversionRates->$currencyName;
        }
        throw new Exception('Object currencyConversionRates not found!');
    }

    private function calculateCurrencyConversion(int $amount, CurrencyFetcher $currencyConversionRate) {
        return ($amount / $currencyConversionRate);
    }
}