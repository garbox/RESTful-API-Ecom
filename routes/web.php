<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JsonForm;

Route::middleware(['token_check'])->group(function () {
    Route::get('/', function () {
        return ['Laravel' => app()->version()];
    });
});

Route::get('/json', [JsonForm::class , 'index']);

require __DIR__.'/auth.php';
