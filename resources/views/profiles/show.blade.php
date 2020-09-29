<x-app-layout>

    <x-slot name="header">
        <x-forum-header />
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white border-b border-gray-200">

                    <h4 class="text-xl text-gray-500">
                        {{ $profileUser->name . "'s profile page" }}
                    </h4>

                    @forelse ($activities as $date => $activity)
                    <hr class="my-6">
                    <h4 class="text-xl text-gray-500">{{ $date }}</h4>

                    @foreach ($activity as $record)
                    @if (view()->exists("profiles.activities.{$record->type}"))
                    @include ("profiles.activities.{$record->type}", ['activity' => $record])
                    @endif

                    @if ( $loop->last )
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
    </div>



</x-app-layout>