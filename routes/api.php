<?php

use Illuminate\Support\Facades\Route;
use Tipoff\Forms\Http\Controllers\Api\FormController;

Route::middleware(config('tipoff.api.middleware_group'))
    ->prefix(config('tipoff.api.uri_prefix'))
    ->group(function () {
        Route::prefix('contact')->group(function () {
            foreach(config('tipoff.forms.active') as $activeRoute) {
                Route::post($activeRoute, FormController::class);
            }
        });
    });
