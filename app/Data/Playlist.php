<?php

declare(strict_types=1);

namespace App\Data;

use Illuminate\Support\Collection;
use Spatie\LaravelData\Data;

class Playlist extends Data
{
    /**
     * @param  Collection<int, PlaylistContributor>  $contributors
     * @param  Collection<int, Track>  $tracks
     */
    public function __construct(
        public string $id,
        public string $name,
        public SpotifyUser $owner,
        public Collection $contributors,
        public Collection $tracks,
        public Image $image,
        public string $url,
    ) {}
}
