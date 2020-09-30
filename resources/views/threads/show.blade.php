<x-app-layout>

    <x-slot name="header">
        <x-forum-header />
    </x-slot>

    <div>

        @livewire('manage-thread', ['thread' => $thread])

    </div>
</x-app-layout>