@extends('app')

@section('content')
    <div class="border-gray-200 bg-white px-4 pb-5">
        <div class="sticky top-0 z-50 pt-5 bg-white">
            <x-spotify.playlist-details :playlist="$playlist" />
            <nav class="border-b border-gray-300">
                <div class="px-2">
                    <div class="relative flex h-16 space-x-8 flex-1 items-stretch justify-start">
                        <a
                            href="{{ route('spotify.playlist-statistics', $playlist->id) }}"
                            @class([
                                'inline-flex items-center border-b-2 px-1 pt-1 text-sm font-medium',
                                'border-green-500 text-gray-900' => $page === 'contributors',
                                'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' => $page !== 'contributors'
                            ])
                            class="inline-flex items-center border-b-2 border-indigo-500 px-1 pt-1 text-sm font-medium text-gray-900">
                            {{ __('general.contributors') }}
                        </a>
                        <a
                            href="{{ route('spotify.playlist-statistics', [$playlist->id, 'tracks']) }}"
                            @class([
                                'inline-flex items-center border-b-2 px-1 pt-1 text-sm font-medium',
                                'border-green-500 text-gray-900' => $page === 'tracks',
                                'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700' => $page !== 'tracks'
                            ])
                            class="inline-flex items-center border-b-2 border-indigo-500 px-1 pt-1 text-sm font-medium text-gray-900">
                            {{ __('general.tracks') }}
                        </a>
                    </div>
                </div>
            </nav>
        </div>
        <div>
            @if ($page === 'contributors')
                <x-spotify.contributor-details :contributors="$playlist->contributors" />
            @elseif ($page === 'tracks')
                <x-spotify.track-details :tracks="$playlist->tracks" />
            @endif
        </div>
    </div>
@endsection
