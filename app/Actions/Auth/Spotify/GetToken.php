<?php

namespace App\Actions\Auth\Spotify;

use App\Actions\Action;
use Illuminate\Support\Facades\Http;
use RuntimeException;

class GetToken implements Action
{
    public function handle(): string
    {
        $response = Http::asForm()
            ->post('https://accounts.spotify.com/api/token', [
                'grant_type' => 'client_credentials',
                'client_id' => config('spotify.client_id'),
                'client_secret' => config('spotify.secret'),
            ]);

        if (!$response->successful()) {
            throw new RuntimeException('Failed to get token');
        }

        return json_decode($response->body(), true)['access_token'];
    }
}
