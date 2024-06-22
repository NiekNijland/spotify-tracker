<?php

declare(strict_types=1);

namespace App\Data;

use Carbon\CarbonImmutable;
use Spatie\LaravelData\Data;

class Track extends Data
{
    public function __construct(
        public string $id,
        public CarbonImmutable $addedAt,
        public PlaylistContributor $addedBy,
        public string $name,
        public string $album,
        public ?string $artist,
        public string $url,
        public ?Image $image,
    ) {}
}
