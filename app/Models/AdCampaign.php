<?php

namespace App\Models;

use A17\Twill\Models\Behaviors\HasMedias;
use A17\Twill\Models\Behaviors\HasPosition;
use A17\Twill\Models\Behaviors\HasRevisions;
use A17\Twill\Models\Behaviors\Sortable;
use App\Models\Behaviors\HasApiRelations;
use App\Repositories\Api\ArtistRepository;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AdCampaign extends AbstractModel implements Sortable
{
    use HasApiRelations;
    use HasFactory;
    use HasMedias;
    use HasPosition;
    use HasRevisions;

    protected $fillable = [
        'published',
        'position',
        'title',
        'start_date',
        'end_date',
        'header',
        'description',
        'destination_url',
        'destination_label',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public $mediasParams = [
        'hero' => [
            'default' => [
                [
                    'name' => 'default',
                    'ratio' => 'default',
                ],
            ],
        ],
    ];

    public static function findPriorityForArtwork(Artwork|int $artwork): ?static {
        $artworkId = $artwork;
        if (is_a($artwork, Artwork::class)) {
            $artworkId = $artwork->datahub_id;
        }

        $hasNoRelations = fn ($campaign) => !((bool) $campaign->artists()->count() || (bool) $campaign->artworks()->count());
        $activeCampaigns = AdCampaign::published()->get()
            ->filter(fn ($campaign) => now()->between($campaign->start_date ?? '', $campaign->end_date ?? ''))
            ->sortBy([
                // Sort campaigns that have no related artists or artworks after
                // those that do
                fn ($left, $right) => $hasNoRelations($left) <=> $hasNoRelations($right),
                // ...then sort by increasing position value
                fn ($left, $right) => $left->position <=> $right->position,
            ]);
        foreach ($activeCampaigns as $campaign) {
            $artworkIds = $campaign->artworks()->pluck('datahub_id');
            if ($artworkIds->contains($artworkId)) {
                return $campaign;
            }

            $artistIds = $campaign->artists()->pluck('datahub_id');
            foreach ($artistIds as $artistId) {
                try {
                    $artist = app(ArtistRepository::class)->getById($artistId);
                    $artistArtworkIds = $artist->artworks()->pluck('id');
                    if ($artistArtworkIds->contains($artworkId)) {
                        return $campaign;
                    }
                } catch (\Exception $exception) {
                    // If there is an API error, continue to the next artist.
                    continue;
                }
            }

            if ($artistIds->isNotEmpty()) {
                // If there are related artists but none of their artworks have
                // matched, continue to the next campaign.
                continue;
            } elseif ($artworkIds->isEmpty()) {
                return $campaign;
            }
        }

        return null;
    }

    public function artists()
    {
        return $this->apiElements()->where('relation', 'artists');
    }

    public function artworks()
    {
        return $this->apiElements()->where('relation', 'artworks');
    }
}
