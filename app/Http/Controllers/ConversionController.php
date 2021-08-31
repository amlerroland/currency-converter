<?php

namespace App\Http\Controllers;

use App\Contracts\Currency\CurrencyService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ConversionController extends Controller
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, CurrencyService $service)
    {
        $validated = $request->validate([
            'from' => [
                'required',
                'string',
                Rule::in(['USD', 'HUF', 'EUR', 'GBP']),
            ],
            'to' => [
                'required',
                'string',
                Rule::in(['USD', 'HUF', 'EUR', 'GBP']),
            ],
            'fromValue' => [
                'required',
                'numeric',
            ],
        ]);

        $result = $service->convert($request->from, $request->to, $request->fromValue);

        // Just so we can see something on the page since one of the apis free plan doesnt allow conversions
        if (is_null($result)) {
            $result = rand(250, 300) * $request->fromValue;
        }

        return [
            'from' => $request->from,
            'to' => $request->to,
            'fromValue' => $request->fromValue,
            'result' => $result,
        ];
    }
}
