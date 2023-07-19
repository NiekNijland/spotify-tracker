<?php

namespace App\Actions\Spotify;

use App\Actions\Action;
use Illuminate\Support\Facades\Http;
use RuntimeException;

readonly class GetPlaylist implements Action
{
    public function __construct(
        private string $accessToken,
        private string $playlistId,
    ) {
    }

    public function handle(): array
    {
        $result = Http::withToken($this->accessToken)
            ->get('https://api.spotify.com/v1/playlists/' . $this->playlistId);

        if (!$result->successful()) {
            throw new RuntimeException('Failed to get playlist');
        }

        return json_decode($result->body(), true);
    }
}
