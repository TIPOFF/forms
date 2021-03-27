<?php

use Illuminate\Support\Facades\Route;

Route::get(config('tipoff.forms.active'), toControllerSlug(config('tipoff.forms.active')));

Route::prefix('confirmation')->group(function () {
    Route::get(config('tipoff.forms.active'), toControllerSlug(config('tipoff.forms.active')) . '@confirmation');
});
