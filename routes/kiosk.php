<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InteractiveFeatureExperiencesController;

Route::get(
    '/interactive-features/{slug}',
    [InteractiveFeatureExperiencesController::class, 'showKiosk']
)->name('interactiveFeatures.showKiosk');

// Only needed so that the kiosk doesn't fallback to the web routes.
Route::fallback(fn () => abort(404));
