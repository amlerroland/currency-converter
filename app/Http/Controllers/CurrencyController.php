<?php

namespace App\Http\Controllers;

use App\Contracts\Currency\CurrencyService;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CurrencyService $service)
    {
        return collect($service->all())->map(function ($currencyCode) {
            return ['name' => $currencyCode];
        });
    }
}
