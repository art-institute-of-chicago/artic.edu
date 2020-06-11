@php
    use App\Models\Api\Exhibition;
    use App\Repositories\Api\ExhibitionRepository;

    $exhibitionIds = $block->browserIds('exhibitions');
    $exhibitions = (new ExhibitionRepository(new Exhibition))->getById($exhibitionIds, ['apiElements']);

    $orderedExhibitions = collect($exhibitionIds)->map(function($id) use ($exhibitions) {
        return $exhibitions->firstWhere('id', $id);
    });

    $items = $orderedExhibitions->map(function($exhibition) {
        return [
            'title' => $exhibition->title_display ?? $exhibition->title,
            'dateDisplay' => $exhibition->present()->formattedDate(),
            'href' => route('exhibitions.show', ['id' => $exhibition->id, 'slug' => $exhibition->titleSlug ]),
        ];
    });
@endphp

@if ($items && $items->count() > 0)
    @component('components.molecules._m-listing----publication-happenings')
        @slot('variation', 'm-listing--publication-happenings--exhibitions m-listing--magazine')
        @slot('title', $block->input('title') ?? null)
        @slot('btnText', 'See all exhibitions')
        @slot('btnHref', route('exhibitions'))
        @slot('items', $items)
    @endcomponent
@endif
