<?php

declare(strict_types=1);

namespace App\Http\Controllers\Spotify;

use App\Actions\Auth\Spotify\GetToken;
use App\Actions\Spotify\GetPlaylist;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class PlaylistStatisticsController extends Controller
{
    public function __invoke(string $playlistId, string $page = 'contributors'): View
    {
        if ($page !== 'contributors' && $page !== 'tracks') {
            abort(404);
        }

        $accessToken = (new GetToken())->handle();
        $playlist = (new GetPlaylist($accessToken, $playlistId))->handle();

        return view('spotify.playlist-statistics', [
            'playlist' => $playlist,
            'page' => $page,
        ]);
    }
}
