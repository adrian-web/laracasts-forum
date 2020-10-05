<x-app-layout>

    <x-slot name="header">
        <x-forum-header />
    </x-slot>

    @livewire('show-thread', ['thread' => $thread])

</x-app-layout>