<?php

declare(strict_types=1);

namespace App\View\Components\Spotify;

use App\Data\Playlist;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PlaylistDetails extends Component
{
    public function __construct(
        public Playlist $playlist
    ) {}

    public function render(): View
    {
        return view('components.spotify.playlist-details');
    }
}
