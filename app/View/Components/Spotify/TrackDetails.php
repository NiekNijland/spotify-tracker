<?php

declare(strict_types=1);

namespace App\View\Components\Spotify;

use App\Data\Track;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class TrackDetails extends Component
{
    /** @var Collection<int, Track> */
    public Collection $duplicates;

    /**
     * @param  Collection<int, Track>  $tracks
     */
    public function __construct(public Collection $tracks)
    {
        $this->tracks = $this->tracks->sortByDesc('addedAt');
        $this->duplicates = $this->getDuplicates();
    }

    /**
     * @return Collection<int, Track>
     */
    private function getDuplicates(): Collection
    {
        $tracks = [];
        $duplicates = new Collection();

        foreach ($this->tracks as $track) {
            if (isset($tracks[$track->name])) {
                $duplicates->push($track);
            }

            $tracks[$track->name] = true;
        }

        return $duplicates;
    }

    public function render(): View
    {
        return view('components.spotify.track-details');
    }
}
