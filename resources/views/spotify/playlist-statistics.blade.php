@extends('layout')

@section('content')
    <div class="border-gray-200 bg-white px-4 py-5 sm:px-6 ml-4">
        <div class="pb-5 flex flex-nowrap items-center justify-between border-b border-gray-300">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <img class="h-12 w-12 rounded-full" src="{{ $playlist['images'][0]['url'] }}" alt="">
                </div>
                <div class="ml-4">
                    <h3 class="text-base font-semibold leading-6 text-gray-900">
                        {{ $playlist['name'] }}
                    </h3>
                    <p class="text-sm text-gray-500">
                        <a href="{{ $playlist['owner']['href'] }}">{{ '@' . $playlist['owner']['display_name'] }}</a>
                    </p>
                </div>
            </div>
            <div class="ml-4 mt-4 flex flex-shrink-0">
                <a href="{{ $playlist['href'] }}" class="relative inline-flex items-center rounded-md px-3 py-2 text-sm font-semibold text-white bg-green-500 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-green-600">
                    <span>Spotify</span>
                </a>
            </div>
        </div>
        <ul role="list">
            @foreach($users as $user)
                <li class="flex justify-between gap-x-6 py-5 border-b border-dashed">
                    <div class="flex gap-x-4">
                        <img class="h-12 w-12 flex-none rounded-full bg-gray-50" src="{{ $user['image'] }}" alt="">
                        <a class="text-sm font-semibold leading-6 text-gray-900 py-3" href="{{ $user['link'] }}">
                            {{ $user['name'] }}
                        </a>
                    </div>
                    <div class="flex flex-nowrap items-end text-sm leading-6 text-gray-900 py-3">
                        <span class="font-semibold">{{ $user['songs_count'] }}</span>
                        <span class="ml-1">Nummers</span>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
@endsection
