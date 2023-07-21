<?php

namespace App\Actions\Spotify;

use App\Actions\Action;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use JsonException;
use RuntimeException;

class GetUser implements Action
{
    public function __construct(
        private readonly string $accessToken,
        private readonly string $userId,
    ) {
    }

    public function handle(): array
    {
        return Cache::remember(
            'user-' . $this->userId,
            3600, // 1 hour
            fn () => $this->getUser(),
        );
    }

    /**
     * @throws JsonException
     */
    private function getUser(): array
    {
        $response = Http::withToken($this->accessToken)
            ->get('https://api.spotify.com/v1/users/' . $this->userId);

        if (!$response->successful()) {
            throw new RuntimeException('Failed to get user');
        }

        return json_decode($response->body(), true, 512, JSON_THROW_ON_ERROR);
    }
}
