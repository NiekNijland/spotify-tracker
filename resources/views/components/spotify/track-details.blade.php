<ul role="list" class="mr-2">
    @foreach($tracks as $track)
        <li class="flex justify-between gap-x-6 border-b border-dashed py-5 my-auto">
            <a href="{{ $track->url }}">
                <div class="flex gap-x-4">
                    <img class="h-12 w-12 flex-none rounded-full bg-gray-50" src="{{ $track->image?->url }}" alt="">
                    <div class="mt-1">
                        <h3 class="text-base font-semibold leading-6 text-gray-900">
                            {{ $track->name }}
                        </h3>
                        <p class="text-sm text-gray-500">
                            {{ '@' . $track->addedBy->name }}
                        </p>
                    </div>
                </div>
            </a>
            <div class="my-auto text-sm text-gray-500 text-right">
                {{ $track->addedAt->shortRelativeToNowDiffForHumans() }}
            </div>
        </li>
    @endforeach
</ul>
