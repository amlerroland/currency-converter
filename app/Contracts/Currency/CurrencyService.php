<?php

namespace App\Contracts\Currency;

interface CurrencyService
{
    /**
     * Get all the available currency codes.
     */
    public function all(): array;

    /**
     * Get the exchange rates for the specified currency.
     */
    public function getRates(string $currencyCode): array;

    /**
     * Convert a specified currency with the given amount.
     *
     * @param float|int $fromValue
     *
     * @return null|float|int
     */
    public function convert(string $from, string $to, $fromValue);
}
