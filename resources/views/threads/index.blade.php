<x-app-layout>

    <x-slot name="header">
        <x-forum-header />
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

                    {{ $threads->links() }}

                </div>
            </div>
        </div>
    </div>



</x-app-layout>