<?php

namespace App\Services\Currency;

use App\Contracts\Currency\Converter;
use App\Exceptions\CurrencyServiceException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class CurrencyConverterApi implements Converter
{
    /**
     * The url of the 3rd party service.
     *
     * @var string
     */
    protected $url = 'https://free.currconv.com';

    /**
     * Get all the available currency codes.
     */
    public function all(): array
    {
        $response = Http::get("{$this->url}/api/v7/currencies", [
            'apiKey' => config('currency.services.currencyconverterapi.key'),
        ]);

        if ($response->failed()) {
            throw new CurrencyServiceException($response->json('error'));
        }

        return array_keys($response->json('results'));
    }

    /**
     * Get the exchange rates for the specified currency.
     */
    public function getRates(string $currencyCode): array
    {
        $currencies = collect(['USD', 'EUR', 'HUF', 'GBP'])
            ->diff([$currencyCode])
            ->map(function ($currency) use ($currencyCode) {
                return "{$currencyCode}_{$currency}";
            });

        // The free plan of the api only allows 2 codes
        if ($currencies->count() > 2) {
            $currencies = $currencies->random(2);
        }

        $response = Http::get("{$this->url}/api/v7/convert", [
            'apiKey' => config('currency.services.currencyconverterapi.key'),
            'q' => $currencies->implode(','),
            'compact' => 'ultra',
        ]);

        if ($response->failed()) {
            throw new CurrencyServiceException($response->json('error'));
        }

        return collect($response->json())->mapWithKeys(function ($rate, $combinedCurrency) use ($currencyCode) {
            return [Str::replace("{$currencyCode}_", '', $combinedCurrency) => $rate];
        })->toArray();
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
        $response = Http::get("{$this->url}/api/v7/convert", [
            'apiKey' => config('currency.services.currencyconverterapi.key'),
            'q' => "{$from}_{$to}",
            'compact' => 'ultra',
        ]);

        if ($response->failed()) {
            throw new CurrencyServiceException($response->json('error'));
        }

        return $fromValue * $response->json("{$from}_{$to}");
    }
}
