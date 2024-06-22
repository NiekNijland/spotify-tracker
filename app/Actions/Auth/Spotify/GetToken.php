<?php

namespace App\Actions\Auth\Spotify;

use App\Actions\Action;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use JsonException;
use RuntimeException;

class GetToken implements Action
{
    public function handle(): string
    {
        return Cache::remember(
            'spotify-token',
            3600, // 1 hour
            fn () => $this->getToken(),
        );
    }

    /**
     * @throws JsonException
     */
    private function getToken(): string
    {
        $response = Http::asForm()
            ->post('https://accounts.spotify.com/api/token', [
                'grant_type' => 'client_credentials',
                'client_id' => config('spotify.client_id'),
                'client_secret' => config('spotify.secret'),
            ]);

        if (! $response->successful()) {
            throw new RuntimeException('Failed to get token');
        }

        return json_decode($response->body(), true, 512, JSON_THROW_ON_ERROR)['access_token'];
    }
}
