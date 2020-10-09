<x-app-layout>

    <x-slot name="header">
        <x-forum-header />
    </x-slot>

    <div class="lg:flex py-12">
        <div class="lg:flex-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="bg-white p-6 sm:px-20 overflow-hidden shadow-xl sm:rounded-lg">

                @forelse ($threads as $thread)
                <article>
                    <div class="flex items-center my-3">
                        <img class="h-8 w-8 rounded-full object-cover" src="{{ $thread->creator->profile_photo_url }}"
                            alt="{{ $thread->creator->username }}" />
                        <h4 class="ml-3 text-gray-500">
                            <a href="{{ $thread->creator->path() }}">
                                {{ $thread->creator->name }}
                            </a>
                            {{ ' created ' }}
                            <a href="{{ $thread->path() }}">
                                @if (auth()->check() && auth()->user()->hasSeenUpdatesFor($thread))
                                <strong>
                                    {{ $thread->title }}
                                </strong>
                                @else
                                {{ $thread->title }}
                                @endif
                            </a>
                        </h4>
                    </div>
                    <div class="mt-6 text-sm text-gray-500">{{ $thread->body }}</div>
                    <div class="flex mt-3 text-sm text-gray-500">
                        <p>
                            {{ $thread->visits . ' ' . Str::plural('visit', $thread->visits) }}
                        </p>
                        <p class="ml-auto "">
                            <a href=" {{ $thread->path() }}">{{ $thread->replies_count }}
                            {{ Str::plural('reply', $thread->replies_count) }}</a>
                        </p>
                    </div>
                </article>

                @if ( $loop->last )
                <div class="mt-3"></div>
                @else
                <hr class="mt-3">
                @endif

                @empty
                <p class="my-6 text-gray-500">
                    There's no threads...
                </p>
                @endforelse

                {{ $threads->withQueryString()->links() }}

            </div>
        </div>

        <div class="hidden lg:contents">
            <div class="lg:flex-grow lg:flex-shrink-0 sm:px-6 lg:px-8">
                <div class="bg-white p-6 sm:px-20 overflow-hidden shadow-xl sm:rounded-lg">

                    <p class="text-center text-gray-500">
                        {{ __('Trending Threads') }}
                    </p>
                    <hr class="my-3">

                    @forelse ($trending as $thread)

                    <p class="text-sm text-gray-500">
                        <a href="{{ $thread->path }}">{{ $thread->title }}</a>
                    </p>

                    @if ( $loop->last )
                    @else
                    <hr class="my-3">
                    @endif

                    @empty

                    <p class="my-3 text-sm text-gray-500">
                        {{ __('There\'s no trending threads...')}}
                    </p>

                    @endforelse

                </div>
            </div>
        </div>
    </div>

</x-app-layout>