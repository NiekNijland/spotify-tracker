<?php

declare(strict_types=1);

namespace App\Actions\Spotify;

use App\Actions\Action;
use App\Data\Image;
use App\Data\Playlist;
use App\Data\PlaylistContributor;
use App\Data\SpotifyUser;
use App\Data\Track;
use Carbon\CarbonImmutable;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use RuntimeException;

readonly class GetPlaylist implements Action
{
    public function __construct(
        private string $accessToken,
        private string $playlistId,
    ) {}

    /**
     * @throws ConnectionException
     */
    public function handle(): Playlist
    {
        $result = Http::withToken($this->accessToken)
            ->get('https://api.spotify.com/v1/playlists/' . $this->playlistId);

        if (! $result->successful()) {
            throw new RuntimeException('Failed to get playlist');
        }

        $result = $result->json();

        [$contributors, $tracks] = $this->getContributorsAndTracks($result);

        return new Playlist(
            id: $result['id'],
            name: $result['name'],
            owner: new SpotifyUser(
                id: $result['owner']['id'],
                name: $result['owner']['display_name'],
                url: $result['owner']['external_urls']['spotify'],
                image: isset($result['images'][0])
                    ? new Image(url: $result['images'][0]['url'])
                    : null,
            ),
            contributors: $contributors,
            tracks: $tracks,
            image: new Image(
                url: $result['images'][0]['url'],
            ),
            url: $result['external_urls']['spotify'],
        );
    }

    /**
     * @param  array<string, mixed>  $result
     * @return array{Collection<int, PlaylistContributor>, Collection<int, Track>}
     *
     * @throws ConnectionException
     */
    private function getContributorsAndTracks(array $result): array
    {
        $tracks = new Collection();
        $contributors = new Collection();

        $rawTracks = $result['tracks']['items'];

        while (count($tracks) < $result['tracks']['total']) {
            foreach ($rawTracks as $rawTrack) {
                $contributor = $contributors->where('id', $rawTrack['added_by']['id'])->first();

                if ($contributor === null) {
                    $user = (new GetUser($this->accessToken, $rawTrack['added_by']['id']))->handle();
                    $contributor = PlaylistContributor::fromSpotifyUser($user, 0);
                    $contributors->push($contributor);
                }

                $contributor->contributionsCount++;

                $tracks->push(new Track(
                    id: $rawTrack['track']['id'],
                    addedAt: new CarbonImmutable($rawTrack['added_at']),
                    addedBy: $contributor,
                    name: $rawTrack['track']['name'],
                    album: $rawTrack['track']['album']['name'],
                    artist: $rawTrack['track']['artists'][0]['name'],
                    url: $rawTrack['track']['external_urls']['spotify'],
                ));
            }

            $rawTracks = Http::withToken($this->accessToken)
                ->get($result['tracks']['next'])
                ->json()['items'];
        }

        return [$contributors, $tracks];
    }
}
