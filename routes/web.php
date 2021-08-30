<?php

use App\Http\Controllers\ConversionController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\RateController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('home');
});

Route::get('currencies', [CurrencyController::class, 'index'])->name('currencies.index');
Route::get('rates/{fromRate}', [RateController::class, 'show'])->name('rates.show');
Route::post('convert', ConversionController::class)->name('convert');
