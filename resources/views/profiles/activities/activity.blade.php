<article>

    <div class="flex">
        <h4 class="flex-1 mt-6 text-xl text-gray-500">
            {{ $activityHeader }}

        </h4>

        {{-- <strong class="mt-6 text-gray-500">
            <a href="{{ $thread->path() }}">
        {{ $thread->created_at->diffForHumans() }}
        </a>
        </strong> --}}

    </div>

    <div class="mt-6 text-sm text-gray-500">
        {{ $activitySlot }}

    </div>

</article>