<?php

declare(strict_types=1);

/*
 * Requires apiKey and baseCurrencyName from -- www.exchangerate-api.com --
 */
class CurrencyFetcher implements CurrencyFetcherInterface
{
    private $currencyConversionRates;

    public function __construct(string $apiKey, string $baseCurrencyName)
    {
        $this->currencyConversionRates = $this->getCurrencyConversionRates($apiKey, $baseCurrencyName);
    }

    public function storeCurrencyConversionRatesToFile(string $fileName)
    {
        $convRates = json_encode($this->currencyConversionRates);

        try {
            $fp = fopen($fileName, 'w');
            fwrite($fp, $convRates);
            fclose($fp);

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function logCurrencyConversionSuccessStatus(bool $status)
    {
        if ($status === true) {
            echo '====== Currency rates are successfully logged on ' . date("F j, Y, g:i a") . ' ======' . PHP_EOL . PHP_EOL;
        } else {
            echo '##### Something went wrong with currency rates logging... ######' . PHP_EOL . PHP_EOL;
        }
    }

    private function getCurrencyConversionRates(string $apiKey, string $baseCurrencyName)
    {
        $baseCurrencyName = strtoupper($baseCurrencyName);

        $req_url = "https://v6.exchangerate-api.com/v6/{$apiKey}/latest/{$baseCurrencyName}";
        $response_json = file_get_contents($req_url);

        if($response_json !== false) {
            try {
                $response = json_decode($response_json);

                if('success' === $response->result) {
                    return $response->conversion_rates;
                }
            } catch(Exception $e) {
                throw new Exception(sprintf('Could not fetch the desired data... %s', $e->getMessage()));
            }
        }
    }

}