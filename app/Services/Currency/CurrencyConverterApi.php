<?php

namespace App\Services\Currency;

use App\Contracts\Currency\Converter;
use App\Exceptions\CurrencyServiceException;

class CurrencyConverterApi implements Converter
{
    /**
     * Get all the available currency codes.
     */
    public function all(): array
    {
        $this->exception();
    }

    /**
     * Get the exchange rates for the specified currency.
     */
    public function getRates(string $currencyCode): array
    {
        $this->exception();
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
        $this->exception();
    }

    /**
     * No implementation of this 3rd party service so it just throws this exception.
     */
    protected function exception()
    {
        throw new CurrencyServiceException('503 Service Unavailable');
    }
}
