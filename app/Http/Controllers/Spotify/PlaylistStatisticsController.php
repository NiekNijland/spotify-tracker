<?php

namespace App\Http\Controllers\Spotify;

use App\Actions\Auth\Spotify\GetToken;
use App\Actions\Spotify\GetPlaylist;
use App\Actions\Spotify\GetUser;
use App\Http\Controllers\Controller;
use Illuminate\View\View;

class PlaylistStatisticsController extends Controller
{
    public function __invoke(string $playlistId): View
    {
        $accessToken = (new GetToken())->handle();

        dd($playlist);
        return view('spotify.playlist-statistics', [
            'playlist' => $playlist,
            'users' => $this->getUsers($accessToken, $playlist),
        ]);
    }

    private function getUsers(string $accessToken, array $playlist): array
    {
        $users = [];
        foreach ($playlist['tracks']['items'] as $track) {
            if (!isset($users[$track['added_by']['id']])) {
                $users[$track['added_by']['id']] = [
                    'name' => $track['added_by']['id'],
                    'id' => $track['added_by']['id'],
                    'image' => $track['added_by']['images'][0]['url'] ?? config('images.user_picture_placeholder'),
                    'link' => $track['added_by']['external_urls']['spotify'],
                    'songs_count' => 0,
                ];
            }

            $users[$track['added_by']['id']]['songs_count']++;
        }

        // fetch user details
        foreach ($users as $userId => $user) {
            $userProfile = (new GetUser($accessToken, $user['id']))->handle();
            $users[$userId]['name'] = $userProfile['display_name'];
            $users[$userId]['image'] = $userProfile['images'][0]['url'] ?? 'https://via.placeholder.com/150';
        }

        return $users;
    }
}
