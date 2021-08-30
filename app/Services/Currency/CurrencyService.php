<?php

namespace App\Services\Currency;

use App\Contracts\Currency\CurrencyService as Contract;
use App\Exceptions\CurrencyServiceException;

class CurrencyService implements Contract
{
    protected $apis = [
        CurrencyConverterApi::class,
        ExchangeratesApi::class,
    ];

    /**
     * Get all the available currency codes.
     */
    public function all(): array
    {
        // I dont really like this but i dont want  to repeat the foreach every time
        return $this->getApiResult('all') ?? [];
    }

    /**
     * Get the exchange rates for the specified currency.
     */
    public function getRates(string $currencyCode): array
    {
        return $this->getApiResult('getRates', func_get_args()) ?? [];
    }

    /**
     * Convert a specified currency with the given amount.
     *
     * @param float|int $fromValue
     *
     * @return null|float|int
     */
    public function convert(string $from, string $to, $fromValue)
    {
        return $this->getApiResult('convert', func_get_args()) ?? null;
    }

    /**
     * Get the result from the api list.
     *
     * @return mixed
     */
    protected function getApiResult(string $method, array $params = [])
    {
        foreach ($this->apis as $apiClass) {
            $api = new $apiClass();

            try {
                $result = $api->{$method}(...$params);
            } catch (CurrencyServiceException $e) {
                // Log or do something with the thrown exception

                continue;
            }

            return $result;
        }

        return null;
    }
}
