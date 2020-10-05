<x-app-layout>

    <x-slot name="header">
        <x-forum-header />
    </x-slot>

    <div class="lg:flex py-12">
        <div class="lg:flex-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">

                    @livewire('manage-thread', ['thread' => $thread])

                    <h3 class="mt-8 text-2xl">
                        {{ __('Replies') }}
                    </h3>

                    @livewire('show-replies', ['thread' => $thread])

                    @if (auth()->check())
                    @livewire('create-reply', ['thread' => $thread])

                    @else
                    <h4 class="mt-8 text-2xl">
                        <a href="{{ route('login') }}">Please sign in...</a>
                    </h4>
                    @endif

                </div>
            </div>
        </div>

        <div class="lg:flex-1 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">

                    @livewire('thread-sidebar', ['thread' => $thread])

                </div>
            </div>
        </div>
    </div>

</x-app-layout>