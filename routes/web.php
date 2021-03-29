<?php

use Illuminate\Support\Facades\Route;

foreach(config('tipoff.forms.active') as $activeRoute) {
    Route::get($activeRoute, toControllerSlug($activeRoute));
}

Route::prefix('confirmation')->group(function () {
    foreach(config('tipoff.forms.active') as $activeRoute) {
        Route::get($activeRoute, toControllerSlug($activeRoute) . '@confirmation');
    }
});
