<?php

declare(strict_types=1);

namespace App\Actions\Spotify;

use App\Actions\Action;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use JsonException;
use RuntimeException;

class GetPlaylist implements Action
{
    public function __construct(
        private readonly string $accessToken,
        private readonly string $playlistId,
    ) {}

    /**
     * @return array<string, mixed>
     *
     * @throws JsonException
     * @throws ConnectionException
     */
    public function handle(): array
    {
        $result = Http::withToken($this->accessToken)
            ->get('https://api.spotify.com/v1/playlists/' . $this->playlistId);

        if (! $result->successful()) {
            throw new RuntimeException('Failed to get playlist');
        }

        return json_decode($result->body(), true, 512, JSON_THROW_ON_ERROR);
    }
}
