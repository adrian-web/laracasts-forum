@props(['threads'])

{{-- Filter Threads --}}
<x-jet-dropdown align="left" width="48">
    <x-slot name="trigger">
        <button type="button" class="mb-3 px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500
            hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition
            duration-150 ease-in-out">
            {{ __('Browse Threads') }}
        </button>
    </x-slot>

    <x-slot name="content">

        <x-jet-dropdown-link href="" wire:click.prevent="query('reset', 1)">
            {{ __('All Threads') }}
        </x-jet-dropdown-link>
        <div class="border-t border-gray-100"></div>
        @auth
        <x-jet-dropdown-link href="" wire:click.prevent="query('by', '{{auth()->user()->username ?? 'guest'}}')">
            {{ __('My Threads') }}
        </x-jet-dropdown-link>
        @endauth
        <div class="border-t border-gray-100"></div>
        <x-jet-dropdown-link href="" wire:click.prevent="query('popular', 1)">
            {{ __('Popular Threads') }}
        </x-jet-dropdown-link>
        <div class=" border-t border-gray-100">
        </div>
        <x-jet-dropdown-link href="" wire:click.prevent="query('unanswered', 1)">
            {{ __('Unanswered Threads') }}
        </x-jet-dropdown-link>

    </x-slot>
</x-jet-dropdown>

{{-- Show Threads --}}
@forelse ($threads as $thread)
<article>
    <div class="flex items-center">
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
        <p class="ml-auto">
            <a href=" {{ $thread->path() }}">{{ $thread->replies_count }}
                {{ Str::plural('reply', $thread->replies_count) }}</a>
        </p>
    </div>
</article>

@if ( $loop->last )
<div class="my-3"></div>
@else
<hr class="my-3">
@endif

@empty
<p class="my-6 text-gray-500">
    There's no threads...
</p>
@endforelse

{{ $threads->withQueryString()->links() }}