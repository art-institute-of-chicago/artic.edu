<?php

use App\Http\Controllers\DigitalExplorerController;
use App\Http\Controllers\InteractiveFeatureExperiencesController;
use App\Http\Controllers\PreviewController;
use Illuminate\Support\Facades\Route;

Route::get('p/{hash}', [PreviewController::class, 'show'])->name('previewLink');

Route::get(
    '/interactive-features/{slug}',
    [InteractiveFeatureExperiencesController::class, 'show']
)->name('interactiveFeatures.show');

Route::get('/digital-explorers/{id}/{slug?}', [DigitalExplorerController::class, 'show'])->name('digitalExplorer.show');

// Only needed so that the kiosk doesn't fallback to the web routes.
Route::fallback(fn () => abort(404));
