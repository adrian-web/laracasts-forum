<x-app-layout>

    <x-slot name="header">
        <div class="flex">
            <x-jet-nav-link href="/threads" :active=false class="mr-5">
                {{ __('Threads') }}
            </x-jet-nav-link>
            <x-jet-dropdown align="top" width="48" class="">
                <x-slot name="trigger">
                    <x-jet-nav-link href="#" :active=false class="mr-5">
                        {{ __('Channels') }}
                    </x-jet-nav-link>
                </x-slot>

                <x-slot name="content">

                    @foreach (App\Models\Channel::all() as $channel)
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
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">

                    @foreach ($threads as $thread)
                    <article>
                        <h4 class="mt-6 text-gray-500">
                            <a href="{{ $thread->path() }}">{{ $thread->title }}</a>
                        </h4>
                        <div class="mt-6 text-gray-500">{{ $thread->body }}</div>
                    </article>
                    <div class="mt-6"></div>
                    @if ( $loop->last )
                    @else
                    <hr>
                    @endif
                    @endforeach

                </div>
            </div>
        </div>
    </div>

</x-app-layout>