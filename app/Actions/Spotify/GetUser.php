<?php

namespace App\Actions\Spotify;

use App\Actions\Action;
use Illuminate\Support\Facades\Http;
use RuntimeException;

readonly class GetUser implements Action
{
    public function __construct(
        private string $accessToken,
        private string $userId,
    ) {
    }

    public function handle(): array
    {
        $response = Http::withToken($this->accessToken)
            ->get('https://api.spotify.com/v1/users/' . $this->userId);

        if (!$response->successful()) {
            throw new RuntimeException('Failed to get user');
        }

        return json_decode($response->body(), true);
    }
}
