<?php

declare(strict_types=1);

namespace App\View\Components\Spotify;

use App\Data\PlaylistContributor;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;

class ContributorDetails extends Component
{
    /**
     * @param  Collection<int, PlaylistContributor>  $contributors
     */
    public function __construct(
        public Collection $contributors
    ) {}

    public function render(): View
    {
        return view('components.spotify.contributors-details');
    }
}
