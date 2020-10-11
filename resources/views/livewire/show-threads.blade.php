<div>

    <x-slot name="header">
        <x-forum-header />
    </x-slot>

    <div class="lg:flex py-12">
        <div class="lg:flex-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="bg-white p-6 sm:px-20 shadow-xl sm:rounded-lg">
                <x-jet-dropdown align="left" width="48">
                    <x-slot name="trigger">
                        <button class="mb-2 px-1 pt-1 border-b-2 border-transparent text-sm font-semibold leading-5 text-gray-500
                        hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition
                        duration-150 ease-in-out">
                            {{ __('Browse Threads') }}
                        </button>
                    </x-slot>

                    <x-slot name="content">

                        <x-jet-dropdown-link wire:click="filter('reset', 1)">
                            {{ __('All Threads') }}
                        </x-jet-dropdown-link>
                        <div class="border-t border-gray-100"></div>
                        @auth
                        <x-jet-dropdown-link wire:click="filter('by', '{{auth()->user()->username}}')">
                            {{ __('My Threads') }}
                        </x-jet-dropdown-link>
                        @endauth
                        <div class="border-t border-gray-100"></div>
                        <x-jet-dropdown-link wire:click="filter('popular', 1)">
                            {{ __('Popular Threads') }}
                        </x-jet-dropdown-link>
                        <div class=" border-t border-gray-100">
                        </div>
                        <x-jet-dropdown-link wire:click="filter('unanswered', 1)">
                            {{ __('Unanswered Threads') }}
                        </x-jet-dropdown-link>

                    </x-slot>
                </x-jet-dropdown>

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
            <div class=" lg:flex-shrink-0 sm:px-6 lg:px-8">
                <div class="bg-white p-6 sm:px-20  shadow-xl sm:rounded-lg">

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

</div>