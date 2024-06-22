<ul role="list" class="mr-2">
    @foreach($contributors as $contributor)
        <li class="flex justify-between gap-x-6 py-5 border-b border-dashed">
            <div class="flex gap-x-4">
                <img class="h-12 w-12 flex-none rounded-full bg-gray-50" src="{{ $contributor->image?->url ?? 'https://via.placeholder.com/150' }}" alt="">
                <a class="text-sm font-semibold leading-6 text-gray-900 py-3" href="{{ $contributor->url }}">
                    {{ $contributor->name }}
                </a>
            </div>
            <div class="flex flex-nowrap items-end text-sm leading-6 text-gray-900 py-3">
                <span class="font-semibold">{{ $contributor->contributionsCount }}</span>
                <span class="ml-1">Nummers</span>
            </div>
        </li>
    @endforeach
</ul>
