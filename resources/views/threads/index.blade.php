<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <a href="/threads" class="mr-5">{{ __('Threads') }}</a>
            <a href="/threads/create" class="mr-5">{{ __('Create') }}</a>
        </h2>
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