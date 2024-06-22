<?php

declare(strict_types=1);

namespace App\Data;

use Spatie\LaravelData\Data;

class SpotifyUser extends Data
{
    public function __construct(
        public string $id,
        public string $name,
        public string $url,
        public ?Image $image,
    ) {}
}
