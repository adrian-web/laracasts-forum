<x-app-layout>

    <x-slot name="header">
        <x-forum-header />
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 sm:px-20 overflow-hidden shadow-xl sm:rounded-lg">

                <div class="flex items-center">
                    <img class="h-8 w-8 rounded-full object-cover" src="{{ $user->profile_photo_url }}"
                        alt="{{ $user->username }}" />
                    <h4 class="ml-3 text-xl text-gray-500">
                        {{ $user->name . "'s profiles page" }}
                    </h4>
                </div>

                @forelse ($activities as $date => $activity)
                <hr class="my-6">
                <h4 class="text-xl text-gray-500">{{ $date }}</h4>

                @foreach ($activity as $record)
                @if (view()->exists("profiles.activities.{$record->type}"))
                @include ("profiles.activities.{$record->type}", ['activity' => $record])
                @endif

                @if ( $loop->last )
                <div class="mt-6"></div>
                @else
                <hr class="mt-6">
                @endif
                @endforeach

                @empty
                <p class="mt-6 text-gray-500">
                    There's no activities...
                </p>
                @endforelse

            </div>
        </div>
    </div>



</x-app-layout>