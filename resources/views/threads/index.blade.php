<x-app-layout>

    <x-slot name="header">
        <x-forum-header />
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">

                    @forelse ($threads as $thread)
                    <article>
                        <div class="flex mt-6">
                            <div class="flex-1 items-center inline-flex">
                                <img class="h-8 w-8 rounded-full object-cover"
                                    src="{{ $thread->creator->profile_photo_url }}"
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

                            <strong class="text-gray-500">
                                <a href="{{ $thread->path() }}">{{ $thread->replies_count }}
                                    {{ Str::plural('reply', $thread->replies_count) }}</a>
                            </strong>

                        </div>
                        <div class="mt-6 text-sm text-gray-500">{{ $thread->body }}</div>
                    </article>

                    @if ( $loop->last )
                    <div class="mt-6"></div>
                    @else
                    <hr class="mt-6">
                    @endif

                    @empty
                    <p class="mt-6 mb-6 text-gray-500">
                        There's no threads...
                    </p>
                    @endforelse

                    {{ $threads->appends(request()->input())->links() }}

                </div>
            </div>
        </div>
    </div>

</x-app-layout>