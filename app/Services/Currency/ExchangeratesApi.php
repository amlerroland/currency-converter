<?php

namespace App\Services\Currency;

use App\Contracts\Currency\Converter;
use App\Exceptions\CurrencyServiceException;
use Illuminate\Support\Facades\Http;

class ExchangeratesApi implements Converter
{
    /**
     * The url of the 3rd party service.
     *
     * @var string
     */
    protected $url = 'http://api.exchangeratesapi.io/v1';

    /**
     * Get all the available currency codes.
     */
    public function all(): array
    {
        $response = Http::get("{$this->url}/latest", [
            'access_key' => config('currency.services.exchangeratesapi.key'),
        ]);

        if ($response->failed()) {
            throw new CurrencyServiceException($response->json('error')['message']);
        }

        return array_keys($response->json('rates'));
    }

    /**
     * Get the exchange rates for the specified currency.
     */
    public function getRates(string $currencyCode): array
    {
        $response = Http::get("{$this->url}/latest", [
            'access_key' => config('currency.services.exchangeratesapi.key'),
            'base' => $currencyCode,
        ]);

        if ($response->failed()) {
            throw new CurrencyServiceException($response->json('error')['message']);
        }

        return $response->json('rates');
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
        $response = Http::get("{$this->url}/convert", [
            'access_key' => config('currency.services.exchangeratesapi.key'),
            'from' => $from,
            'to' => $to,
            'amount' => $fromValue,
        ]);

        if ($response->failed()) {
            throw new CurrencyServiceException($response->json('error')['message']);
        }

        return $response->json('result');
    }
}
