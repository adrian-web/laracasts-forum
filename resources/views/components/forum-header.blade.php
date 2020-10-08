@php
$classes = 'inline-flex px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500
hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition
duration-150 ease-in-out';
@endphp

<div class="flex items-center">
    <div class="flex-1 inline-flex">
        <x-jet-dropdown align="top" width="48" class="">
            <x-slot name="trigger">
                <button type="button" class="mr-5 {{$classes}}">
                    {{ __('Browse') }}
                </button>
            </x-slot>

            <x-slot name="content">

                <x-jet-dropdown-link href="/threads">
                    {{ __('All Threads') }}
                </x-jet-dropdown-link>
                <div class="border-t border-gray-100"></div>
                @auth
                <x-jet-dropdown-link href="{{ '/threads?by=' . auth()->user()->username }}">
                    {{ __('My Threads') }}
                </x-jet-dropdown-link>
                @endauth
                <div class="border-t border-gray-100"></div>
                <x-jet-dropdown-link href="/threads?popular=1">
                    {{ __('Popular Threads') }}
                </x-jet-dropdown-link>
                <div class="border-t border-gray-100"></div>
                <x-jet-dropdown-link href="/threads?unanswered=1">
                    {{ __('Unanswered Threads') }}
                </x-jet-dropdown-link>

            </x-slot>
        </x-jet-dropdown>
        <x-jet-dropdown align="top" width="48" class="">
            <x-slot name="trigger">
                <button type="button" class="mr-5 {{$classes}}">
                    {{ __('Channels') }}
                </button>
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

        @if(auth()->check() && auth()->user()->hasVerifiedEmail())
        @livewire('create-thread', ['classes' => $classes])
        @endif
    </div>

    <div>
        @guest
        @if (Route::has('login'))
        <button type="button" class="{{$classes}}">
            <a href="{{ route('login') }}">{{ __('Login') }}</a>
        </button>
        @if (Route::has('register'))
        <button type="button" class="{{$classes}} ml-4">
            <a href="{{ route('register') }}">{{ __('Register') }}</a>
        </button>
        @endif
        @endif
        @endguest
    </div>
</div>