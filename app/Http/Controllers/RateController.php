<?php

namespace App\Http\Controllers;

use App\Contracts\Currency\CurrencyService;
use Illuminate\Http\Request;

class RateController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param string $fromRate
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $fromRate, CurrencyService $service)
    {
        if (! in_array($fromRate, ['USD', 'HUF', 'EUR', 'GBP'])) {
            abort(404);
        }

        $rates = $service->getRates($fromRate);

        return [
            'name' => $fromRate,
            'rates' => collect($rates)->map(function ($rate, $currencyCode) {
                return [
                    'currency' => $currencyCode,
                    'rate' => $rate,
                ];
            })->values(),
        ];
    }
}
