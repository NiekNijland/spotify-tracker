<?php

namespace App\Http\Controllers\Spotify;

use App\Actions\Auth\Spotify\GetToken;
use App\Actions\Spotify\GetPlaylist;
use App\Actions\Spotify\GetUser;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class PlaylistStatisticsController extends Controller
{
    public function __invoke(string $playlistId): View
    {
        $viewData = Cache::remember('playlist-' . $playlistId, 10, function () use ($playlistId) {
            $accessToken = (new GetToken())->handle();
            $playlist = $this->getPlaylist($accessToken, $playlistId);
            return [
                'playlist' => $playlist,
                'statistics' => $this->getStatistics($accessToken, $playlist),
            ];
        });

        return view('spotify.playlist-statistics', $viewData);
    }

    private function getPlaylist(string $accessToken, string $playlistId): array
    {
        return (new GetPlaylist($accessToken, $playlistId))->handle();
    }

    private function getStatistics(string $accessToken, array $playlist): array
    {
        $duplicates = [];
        $users = [];

        foreach ($playlist['tracks']['items'] as $track) {
            if (!isset($users[$track['added_by']['id']])) {
                $users[$track['added_by']['id']] = [
                    'name' => $track['added_by']['id'],
                    'id' => $track['added_by']['id'],
                    'image' => $track['added_by']['images'][0]['url'] ?? 'https://via.placeholder.com/150',
                    'link' => $track['added_by']['external_urls']['spotify'],
                    'songs_count' => 0,
                ];
            }

            $users[$track['added_by']['id']]['songs_count']++;

            if (isset($duplicates[$track['track']['id']])) {
                $duplicates[$track['track']['id']] = true;
            } else {
                $duplicates[$track['track']['id']] = false;
            }
        }

        foreach ($users as $userId => $user) {
            $userProfile = (new GetUser($accessToken, $user['id']))->handle();
            $users[$userId]['name'] = $userProfile['display_name'];
            $users[$userId]['image'] = $userProfile['images'][0]['url'] ?? 'https://via.placeholder.com/150';
        }

        return [
            'users' => $users,
            'duplicates' => array_filter($duplicates, function ($duplicate) {
                return $duplicate;
            }),
        ];
    }
}
