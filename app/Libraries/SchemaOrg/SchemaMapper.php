<?php

namespace App\Libraries\SchemaOrg;

use DateTimeInterface;
use Illuminate\Support\Collection;

/**
 * Maps a model to schema.org properties using the definition passed in by
 * the caller (typically inlined at the controller call site).
 *
 * Each definition value is either a model attribute/accessor name (resolved
 * against the wrapped model), a literal array, or a closure invoked with the
 * model and this mapper so computed properties can reuse the shared helpers
 * below. Null and empty values are filtered from the final entity, so
 * computed properties simply return null to omit themselves.
 *
 * The static factories (text, iso, canonical, heroImage, orgRef, siteRef)
 * build definition values in the shape map() expects; controllers compose
 * them declaratively in jsonLdDefinition() instead of inlining closures.
 */
class SchemaMapper
{
    /**
     * @var array<string, mixed>
     */
    protected array $definition;

    protected mixed $model;

    /**
     * @param array<string, mixed> $definition
     */
    public function __construct(mixed $model, array $definition)
    {
        $this->model = $model;
        $this->definition = $definition;
    }

    /**
     * Resolve the schema.org entity for the wrapped model.
     *
     * @return array<string, mixed>
     */
    public function map(): array
    {
        $data = [];

        foreach ($this->definition as $key => $value) {
            $resolved = $this->resolveProperty($key, $value);

            if ($this->isEmpty($resolved)) {
                continue;
            }

            $data[$key] = $resolved;
        }

        return $data;
    }

    /**
     * Map another model through the given definition. Used for nested entities
     * such as playlist videos. Null or empty definitions are skipped silently.
     *
     * @param mixed                     $model      The model to map.
     * @param array<string, mixed>|null $definition The schema.org definition.
     *
     * @return array<string, mixed>
     */
    public function mapWith(mixed $model, ?array $definition = null): array
    {
        if (!is_array($definition) || empty($definition)) {
            return [];
        }

        return (new self($model, $definition))->map();
    }

    /**
     * Resolve a single definition value: closures are invoked with the model
     * and this mapper; string values name model attributes; everything else
     * (literal arrays, literal @type strings) is returned untouched.
     */
    protected function resolveProperty(string $key, mixed $value): mixed
    {
        if ($value instanceof \Closure) {
            return $value($this->model, $this);
        }

        if ($key === '@type' || !is_string($value)) {
            return $value;
        }

        return $this->readAttribute($this->model, $value);
    }

    /**
     * Resolve a model attribute/accessor safely, returning null when the
     * attribute is absent or its accessor throws.
     */
    protected function readAttribute(mixed $model, string $key): mixed
    {
        try {
            return $model->{$key} ?? null;
        } catch (\Throwable $e) {
            return null;
        }
    }

    /**
     * Resolve the canonical page URL for the given route.
     */
    public function canonicalUrl(string $routeName, string $slugKey = 'slug'): ?string
    {
        $model = $this->model;

        if (empty($model->id)) {
            return null;
        }

        $params = ['id' => $model->id];

        $slug = $model->{$slugKey} ?? null;

        // Twill models expose the slug via getSlug() rather than a plain attribute
        if (!is_string($slug) || $slug === '') {
            $slug = method_exists($model, 'getSlug') ? $model->getSlug() : null;
        }

        if (is_string($slug) && $slug !== '') {
            $params['slug'] = $slug;
        }

        try {
            return route($routeName, $params);
        } catch (\Throwable $e) {
            return null;
        }
    }

    /**
     * Extract the hero image URL from an API or Eloquent model.
     */
    public function imageUrl(string $role = 'hero'): ?string
    {
        $image = $this->fetchImage($role);

        if (is_array($image)) {
            // Prefer the IIIF identifier exposed by imageFront(), fall back to the rendered src
            foreach (['iiifId', 'src'] as $key) {
                $url = $image[$key] ?? null;

                if (is_string($url) && str_starts_with($url, 'http')) {
                    return $url;
                }
            }

            return null;
        }

        return is_string($image) && str_starts_with($image, 'http') ? $image : null;
    }

    protected function fetchImage(string $role): mixed
    {
        if (method_exists($this->model, 'imageFront')) {
            try {
                $image = $this->model->imageFront($role);

                if (!empty($image)) {
                    return $image;
                }
            } catch (\Throwable $e) {
                // Fall through to the next strategy
            }
        }

        if (method_exists($this->model, 'imageAsArray')) {
            try {
                return $this->model->imageAsArray($role);
            } catch (\Throwable $e) {
                return null;
            }
        }

        return null;
    }

    /**
     * Format a date-ish value as an ISO 8601 string.
     */
    public function toIso8601(mixed $value): ?string
    {
        if ($value instanceof DateTimeInterface) {
            return $value->format(DateTimeInterface::ATOM);
        }

        if (is_object($value) && method_exists($value, 'toIso8601String')) {
            return $value->toIso8601String();
        }

        if (is_string($value) && $value !== '') {
            try {
                return (new \DateTime($value))->format(DateTimeInterface::ATOM);
            } catch (\Throwable $e) {
                return null;
            }
        }

        return null;
    }

    /**
     * Strip HTML tags and trim; null when the result is empty.
     */
    public function cleanText(mixed $value): ?string
    {
        if (!is_string($value)) {
            return null;
        }

        $text = trim(strip_tags($value));

        return $text !== '' ? $text : null;
    }

    /**
     * Clean the first non-null value among the given model attributes.
     */
    public function cleanTextOf(mixed $model, string ...$keys): ?string
    {
        $value = null;

        foreach ($keys as $key) {
            try {
                $candidate = $model->{$key} ?? null;
            } catch (\Throwable $e) {
                $candidate = null;
            }

            if ($candidate !== null) {
                $value = $candidate;
                break;
            }
        }

        return $this->cleanText($value);
    }

    /**
     * IIIF thumbnail URL (!300,300) derived from the hero image, when the
     * image URL is an IIIF endpoint.
     */
    public function thumbnailUrl(): ?string
    {
        $url = $this->imageUrl();

        if (!is_string($url) || !str_contains($url, '/iiif/2/')) {
            return null;
        }

        if (preg_match('#(https?://[^/]+/iiif/2/[^/]+)/full/[^/]+/0/default\.jpg#', $url, $matches)) {
            return $matches[1] . '/full/!300,300/0/default.jpg';
        }

        return rtrim($url, '/') . '/full/!300,300/0/default.jpg';
    }

    /**
     * The museum's postal address, shared by event and exhibition locations.
     *
     * @return array<string, string>
     */
    public function museumAddress(): array
    {
        return [
            '@type' => 'PostalAddress',
            'streetAddress' => '111 S Michigan Ave',
            'addressLocality' => 'Chicago',
            'addressRegion' => 'IL',
            'postalCode' => '60603',
            'addressCountry' => 'US',
        ];
    }

    /**
     * First non-empty string among the given model attributes.
     */
    public function firstOf(string ...$fields): ?string
    {
        foreach ($fields as $field) {
            try {
                $value = $this->model->{$field} ?? null;
            } catch (\Throwable $e) {
                $value = null;
            }

            if (is_string($value) && $value !== '') {
                return $value;
            }
        }

        return null;
    }

    protected function isEmpty(mixed $value): bool
    {
        if ($value === null || $value === '' || $value === []) {
            return true;
        }

        if ($value instanceof Collection) {
            return $value->isEmpty();
        }

        return false;
    }

    /**
     * ISO 8601 date from the first non-null field on the model.
     *
     * @param string ...$fields Model attributes to try in order.
     *
     * @return \Closure Definition value resolving the first non-null field.
     */
    public static function iso(string ...$fields): \Closure
    {
        return static function ($m, $mapper) use ($fields) {
            foreach ($fields as $field) {
                $value = $m->{$field} ?? null;

                if ($value !== null) {
                    return $mapper->toIso8601($value);
                }
            }

            return null;
        };
    }

    /**
     * Cleaned (strip-tags, trimmed) text from the first non-null field.
     *
     * @param string ...$fields Model attributes to try in order.
     *
     * @return \Closure Definition value resolving the cleaned text.
     */
    public static function text(string ...$fields): \Closure
    {
        return static fn ($m, $mapper) => $mapper->cleanTextOf($m, ...$fields);
    }

    /**
     * Canonical route URL for the model from its id and slug.
     *
     * @param string $route   Route name for the canonical page.
     * @param string $slugKey Model attribute holding the slug.
     *
     * @return \Closure Definition value resolving the canonical URL.
     */
    public static function canonical(string $route, string $slugKey = 'slug'): \Closure
    {
        return static fn ($m, $mapper) => $mapper->canonicalUrl($route, $slugKey);
    }

    /**
     * Hero image URL from the model.
     *
     * @return \Closure Definition value resolving the hero image URL.
     */
    public static function heroImage(): \Closure
    {
        return static fn ($m, $mapper) => $mapper->imageUrl();
    }

    /**
     * Reference to the global Museum/Organization entity emitted in the @graph.
     *
     * @return array{@id: string}
     */
    public static function orgRef(): array
    {
        return ['@id' => 'https://www.artic.edu/#organization'];
    }

    /**
     * Reference to the global WebSite entity emitted in the @graph.
     *
     * @return array{@id: string}
     */
    public static function siteRef(): array
    {
        return ['@id' => 'https://www.artic.edu/#website'];
    }
}
