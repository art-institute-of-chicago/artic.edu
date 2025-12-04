<?php

use App\Http\Controllers\DigitalExplorerController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\InteractiveFeatureExperiencesController;

Route::get(
    '/interactive-features/{slug}',
    [InteractiveFeatureExperiencesController::class, 'show']
)->name('interactiveFeatures.show');

Route::get('/digital-explorers/{id}', [DigitalExplorerController::class, 'show'])->name('digitalExplorer.show');

// Only needed so that the kiosk doesn't fallback to the web routes.
Route::fallback(fn () => abort(404));
