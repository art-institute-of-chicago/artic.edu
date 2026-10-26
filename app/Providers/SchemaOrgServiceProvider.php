<?php

/**
 * Registers the schema.org JSON-LD manager and the @jsonLd Blade directive.
 */

namespace App\Providers;

use App\Libraries\SchemaOrg\JsonLdManager;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

/**
 * Provides schema.org JSON-LD rendering services.
 */
class SchemaOrgServiceProvider extends ServiceProvider
{
    /**
     * Register the JsonLdManager singleton.
     */
    public function register(): void
    {
        $this->app->singleton(JsonLdManager::class);
    }

    /**
     * Register the @jsonLd Blade directive.
     *
     * The directive collects the model's schema.org entity into the manager
     * without echoing anything; the entity is rendered later as part of the
     * layout's single JSON-LD script tag.
     */
    public function boot(): void
    {
        Blade::directive('jsonLd', function ($expression) {
            return "<?php app(\App\Libraries\SchemaOrg\JsonLdManager::class)->addModelEntity($expression); ?>";
        });
    }
}
