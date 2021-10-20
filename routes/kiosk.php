<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InteractiveFeatureExperiencesController;

Route::name('interactiveFeatures.showKiosk')->get('/interactive-features/{slug}', [InteractiveFeatureExperiencesController::class, 'showKiosk']);
