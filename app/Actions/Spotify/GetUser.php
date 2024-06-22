<?php

declare(strict_types=1);

namespace App\Actions\Spotify;

use App\Actions\Action;
use App\Data\Image;
use App\Data\SpotifyUser;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use RuntimeException;

readonly class GetUser implements Action
{
    public function __construct(
        private string $accessToken,
        private string $userId,
    ) {}

    public function handle(): SpotifyUser
    {
        return Cache::remember(
            'user-' . $this->userId,
            3600, // 1 hour
            fn () => $this->getUser(),
        );
    }

    /**
     * @throws ConnectionException
     */
    private function getUser(): SpotifyUser
    {
        $response = Http::withToken($this->accessToken)
            ->get('https://api.spotify.com/v1/users/' . $this->userId);

        if (! $response->successful()) {
            throw new RuntimeException('Failed to get user');
        }

        $response = $response->json();

        return new SpotifyUser(
            id: $response['id'],
            name: $response['display_name'],
            url: $response['external_urls']['spotify'],
            image: isset($response['images'][0])
                ? new Image(url: $response['images'][0]['url'])
                : null,
        );
    }
}
