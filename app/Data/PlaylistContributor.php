<?php

declare(strict_types=1);

namespace App\Data;

class PlaylistContributor extends SpotifyUser
{
    public function __construct(
        string $id,
        string $name,
        string $url,
        ?Image $image,
        public int $contributionsCount,
    ) {
        parent::__construct($id, $name, $url, $image);
    }

    public static function fromSpotifyUser(SpotifyUser $user, int $contributionsCount): self
    {
        return new self(
            $user->id,
            $user->name,
            $user->url,
            $user->image,
            $contributionsCount,
        );
    }
}
