<?php

namespace App\Actions\Spotify;

use App\Actions\Action;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use JsonException;
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
        return Cache::remember(
            'playlist-' . $this->playlistId,
            300, // 5 minutes
            fn () => $this->getPlaylist(),
        );
    }

    /**
     * @throws JsonException
     */
    private function getPlaylist(): array
    {
        $result = Http::withToken($this->accessToken)
            ->get('https://api.spotify.com/v1/playlists/' . $this->playlistId);

        if (!$result->successful()) {
            throw new RuntimeException('Failed to get playlist');
        }

        return json_decode($result->body(), true, 512, JSON_THROW_ON_ERROR);
    }
}
