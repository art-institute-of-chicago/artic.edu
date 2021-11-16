<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InteractiveFeatureExperiencesController;

Route::get('/interactive-features/{slug}', [InteractiveFeatureExperiencesController::class, 'showKiosk'])->name('interactiveFeatures.showKiosk');
