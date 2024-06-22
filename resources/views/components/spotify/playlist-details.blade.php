<div class="pb-5 flex flex-nowrap items-center justify-between border-b border-gray-300">
    <div class="flex items-center">
        <div class="flex-shrink-0">
            <img class="h-12 w-12 rounded-full" src="{{ $playlist->image->url }}" alt="">
        </div>
        <div class="ml-4">
            <h3 class="text-base font-semibold leading-6 text-gray-900">
                {{ $playlist->name }}
            </h3>
            <p class="text-sm text-gray-500">
                <a href="{{ $playlist->owner->url }}">{{ '@' . $playlist->owner->name }}</a>
            </p>
        </div>
    </div>
    <div class="ml-4 mt-4 flex flex-shrink-0">
        <a href="{{ 'https://open.spotify.com/playlist/' . $playlist->id }}" class="relative inline-flex items-center rounded-md px-3 py-2 text-sm font-semibold text-white bg-green-500 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-green-600">
            <span>Spotify</span>
        </a>
    </div>
</div>
