<?php

namespace App\Libraries\SchemaOrg;

class JsonLdManager
{
    /**
     * Page-level schema.org entities collected via addEntity().
     *
     * @var array<int, array<string, mixed>>
     */
    protected array $graphEntities = [];

    /**
     * Collect a BreadcrumbList entity for the page @graph.
     *
     * Each item is ['label' => string, 'url' => string|null] with the current
     * page typically carrying no url. Positions are derived from the order.
     *
     * @param array<int, array{label: string, url?: string|null}> $items
     */
    public function addBreadcrumbs(array $items): void
    {
        $elements = [];
        $position = 1;

        foreach ($items as $item) {
            $label = $item['label'] ?? null;

            if (!is_string($label) || $label === '') {
                continue;
            }

            $element = [
                '@type' => 'ListItem',
                'position' => $position++,
                'name' => $label,
            ];

            $url = $item['url'] ?? null;

            if (is_string($url) && $url !== '') {
                $element['item'] = $url;
            }

            $elements[] = $element;
        }

        if (!empty($elements)) {
            $this->addEntity([
                '@type' => 'BreadcrumbList',
                'itemListElement' => $elements,
            ]);
        }
    }

    /**
     * Collect a schema.org entity for inclusion in the page @graph.
     *
     * @param array<string, mixed> $entity
     */
    public function addEntity(array $entity): void
    {
        $this->graphEntities[] = $this->filterEmptyValues($entity);
    }

    /**
     * Resolve the schema.org mapper for the given model and definition, or
     * null when no definition is provided.
     *
     * @param mixed                     $model      The model to map.
     * @param array<string, mixed>|null $definition The schema.org definition.
     *
     * @return SchemaMapper|null
     */
    public function mapperFor(mixed $model, ?array $definition = null): ?SchemaMapper
    {
        if (!is_object($model) || empty($definition)) {
            return null;
        }

        return new SchemaMapper($model, $definition);
    }

    /**
     * Resolve the schema.org entity for the given model and collect it into the
     * page @graph without returning anything. A definition is optional; models
     * without one are skipped silently.
     *
     * @param mixed                     $model      The model to map.
     * @param array<string, mixed>|null $definition The schema.org definition.
     *
     * @return void
     */
    public function addModelEntity(mixed $model, ?array $definition = null): void
    {
        if (empty($definition)) {
            return;
        }

        $entity = $this->resolveEntity($model, $definition);

        if ($entity !== null) {
            $this->addEntity($entity);
        }
    }

    /**
     * Resolve the given model and return the mapped entity, or null when the
     * model cannot be mapped.
     *
     * @param mixed                $model      The model to map.
     * @param array<string, mixed> $definition The schema.org definition.
     *
     * @return array<string, mixed>|null
     */
    private function resolveEntity(mixed $model, array $definition): ?array
    {
        $mapper = $this->mapperFor($model, $definition);

        return $mapper?->map();
    }

    /**
     * Render a single JSON-LD script tag containing the global entities and any
     * page entities collected via addEntity()/addModelEntity().
     */
    public function renderGraphScript(): string
    {
        $payload = [
            '@context' => 'https://schema.org',
            '@graph' => array_merge($this->globalEntities(), $this->graphEntities),
        ];

        $json = json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);

        return '<script type="application/ld+json">' . $json . '</script>';
    }

    /**
     * Drop empty values (null, '', [], empty collections) so the rendered
     * JSON-LD stays free of null clutter.
     *
     * Unlike plain array_filter($entity), this preserves valid falsy values
     * such as false (isAccessibleForFree=false), 0, and '0' (an Offer priced
     * at $0), which array_filter would drop.
     *
     * @param array<string, mixed> $entity
     * @return array<string, mixed>
     */
    protected function filterEmptyValues(array $entity): array
    {
        return array_filter($entity, fn ($value) => !SchemaMapper::isEmpty($value));
    }

    /**
     * Entities shared by every page.
     *
     * @return array<int, array<string, mixed>>
     */
    protected function globalEntities(): array
    {
        return [
            $this->organization(),
            $this->website(),
        ];
    }

    /**
     * The Art Institute of Chicago museum/organization entity.
     *
     * @return array<string, mixed>
     */
    protected function organization(): array
    {
        return [
            '@type' => ['Museum', 'Organization'],
            '@id' => SchemaMapper::ORGANIZATION_ID,
            'name' => 'Art Institute of Chicago',
            'url' => 'https://www.artic.edu',
            'logo' => $this->organizationLogoUrl(),
            'foundingDate' => '1879',
            'contactPoint' => [
                '@type' => 'ContactPoint',
                'contactType' => 'customer service',
                'url' => 'https://www.artic.edu/visit',
            ],
            'address' => config('aic.museum_address'),
            'sameAs' => array_values(config('aic.socials')),
        ];
    }

    /**
     * The site's WebSite entity.
     *
     * @return array<string, mixed>
     */
    protected function website(): array
    {
        return [
            '@type' => 'WebSite',
            '@id' => SchemaMapper::WEBSITE_ID,
            'url' => 'https://www.artic.edu',
            'name' => 'Art Institute of Chicago',
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => 'https://www.artic.edu/search?q={search_term_string}',
                'query-input' => 'required name=search_term_string',
            ],
        ];
    }

    protected function organizationLogoUrl(): ?string
    {
        try {
            return url(\App\Helpers\FrontendHelpers::revAsset('images/aic-favicon.svg'));
        } catch (\Throwable $e) {
            return 'https://www.artic.edu/apple-touch-icon.png';
        }
    }
}
