<div class="flex">
    <x-jet-dropdown align="top" width="48" class="">
        <x-slot name="trigger">
            <x-jet-nav-link href="#" :active=false class="mr-5">
                {{ __('Browse') }}
            </x-jet-nav-link>
        </x-slot>

        <x-slot name="content">

            <x-jet-dropdown-link href="/threads">
                {{ __('All Threads') }}
            </x-jet-dropdown-link>
            <div class="border-t border-gray-100"></div>
            @if (auth()->check())
            <x-jet-dropdown-link href="{{ '/threads?by=' . auth()->user()->name }}">
                {{ __('My Threads') }}
            </x-jet-dropdown-link>
            @endif
            <div class="border-t border-gray-100"></div>
            <x-jet-dropdown-link href="/threads?popular=1">
                {{ __('Popular Threads') }}
            </x-jet-dropdown-link>

        </x-slot>
    </x-jet-dropdown>
    <x-jet-dropdown align="top" width="48" class="">
        <x-slot name="trigger">
            <x-jet-nav-link href="#" :active=false class="mr-5">
                {{ __('Channels') }}
            </x-jet-nav-link>
        </x-slot>

        <x-slot name="content">

            @foreach ($channels as $channel)
            <x-jet-dropdown-link href="/threads/{{$channel->slug}}">
                {{ $channel->name }}
            </x-jet-dropdown-link>
            <div class="border-t border-gray-100"></div>
            @endforeach

        </x-slot>
    </x-jet-dropdown>
    <x-jet-nav-link href="/threads/create" :active=false class="mr-5">
        {{ __('Create') }}
    </x-jet-nav-link>
</div>