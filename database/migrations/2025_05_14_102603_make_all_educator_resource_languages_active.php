<?php

use App\Models\EducatorResource;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    public function up(): void
    {
        EducatorResource::published()->get()->each(function ($eduResource) {
            foreach (['en', 'es'] as $locale) {
                $tranModel = $eduResource->getTranslation($locale);
                if ($tranModel) {
                    $tranModel->active = true;
                    $tranModel->save();
                }
            }
        });
    }

    public function down(): void
    {
        EducatorResource::published()->get()->each(function ($eduResource) {
            foreach (['en', 'es'] as $locale) {
                $tranModel = $eduResource->getTranslation($locale);
                if ($tranModel) {
                    $tranModel->active = false;
                    $tranModel->save();
                }
            }
        });
    }
};
