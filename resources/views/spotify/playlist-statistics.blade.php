@extends('app')

@section('content')
    <div class="border-gray-200 bg-white px-4 py-5">
        <x-spotify.playlist-details :playlist="$playlist" />
        <x-spotify.contributor-details :contributors="$playlist->contributors" />
    </div>
@endsection
