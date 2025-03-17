<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JsonForm;

Route::redirect('/', '/docs/api');

Route::get('/json', [JsonForm::class , 'index']);

require __DIR__.'/auth.php';
