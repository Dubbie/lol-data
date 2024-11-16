<?php

use App\Http\Controllers\Api\ChampionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::group([
    'prefix' => 'champion'
], function () {
    Route::get('/', [ChampionController::class, 'index'])->name('api.champion.index');
});
